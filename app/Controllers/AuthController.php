<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $session;
    protected $authLogger;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        // $this->authLogger = new AuthLogger(\Config\Services::request());
    }
    public function index(): string
    {
        return view('auth/login_form');
    }

    public function auth()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        // DEBUG: log username, db name, and direct count from table
        try {
            $db = db_connect();
            $dbName = method_exists($db, 'getDatabase') ? $db->getDatabase() : 'unknown';
            $directCount = $db->table('user')->where('username', $username)->countAllResults();
            log_message('info', 'AUTH DEBUG username="{username}", db="{db}", directCount={count}', [
                'username' => $username,
                'db' => $dbName,
                'count' => $directCount,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'AUTH DEBUG failed: {msg}', ['msg' => $e->getMessage()]);
        }

        $user = $this->userModel->getUserByUsernameAndRole($username);
        $foundViaModel = $user ? 'yes' : 'no';
        log_message('info', 'AUTH DEBUG userModel_found=' . $foundViaModel);
        @file_put_contents(WRITEPATH . 'logs/auth-debug.txt', date('c') . " userModel_found=" . $foundViaModel . "\n", FILE_APPEND);

        // Fallback: ambil langsung dari tabel user jika model tidak menemukan (hindari dampak JOIN)
        if (!$user) {
            try {
                $db = db_connect();
                $direct = $db->table('user')->where('username', $username)->get()->getRowArray();
                $foundDirect = $direct ? 'yes' : 'no';
                log_message('info', 'AUTH DEBUG directUser_found=' . $foundDirect);
                @file_put_contents(WRITEPATH . 'logs/auth-debug.txt', date('c') . " directUser_found=" . $foundDirect . "\n", FILE_APPEND);

                if ($direct) {
                    // Samakan struktur minimum yang dibutuhkan proses login
                    $user = [
                        'user_id'      => $direct['id'] ?? null,
                        'username'     => $direct['username'] ?? null,
                        'password'     => $direct['password'] ?? null,
                        'role'         => $direct['role'] ?? null,
                        'email'        => $direct['email'] ?? null,
                        'role_id'      => $direct['role_id'] ?? null,
                        'rt_id'        => $direct['rt_id'] ?? null,
                        'is_active'    => $direct['is_active'] ?? 1,
                        // kolom join akan diisi ulang nanti bila perlu
                        'wilayah_nama' => null,
                    ];
                }
            } catch (\Throwable $e) {
                log_message('error', 'AUTH DEBUG direct fetch failed: {msg}', ['msg' => $e->getMessage()]);
                @file_put_contents(WRITEPATH . 'logs/auth-debug.txt', date('c') . " direct_fetch_failed=" . $e->getMessage() . "\n", FILE_APPEND);
            }
        }

        if ($user) {
            $stored = $user['password'] ?? '';
            $isValid = false;

            // DEBUG: catat info alg/len sebelum verifikasi
            $pinfo = password_get_info((string)$stored);
            $alg = $pinfo['algo'] ?? 0;
            @file_put_contents(WRITEPATH . 'logs/auth-debug.txt', date('c') . sprintf(' precheck alg=%s inLen=%d stLen=%d stPref=%s', (string)$alg, strlen((string)$password), strlen((string)$stored), substr((string)$stored, 0, 10)) . "\n", FILE_APPEND);

            // Jika sudah hash (bcrypt/argon), gunakan password_verify
            if ($alg !== 0) {
                $isValid = password_verify($password, $stored);
                // Rehash bila diperlukan
                if ($isValid && password_needs_rehash($stored, PASSWORD_DEFAULT)) {
                    $this->userModel->updatePassword($user['user_id'], $password);
                }
            } else {
                // Kompatibilitas data lama: plaintext, MD5, SHA-1, SHA-256, atau crypt($1$/$5$/$6$)
                $storedTrim = trim((string) $stored);
                $matches = false;

                // DEBUG: info panjang dan prefix untuk audit tanpa bocor password
                $debugInfo = sprintf(
                    'pwd_debug user=%s inLen=%d stLen=%d stPref=%s',
                    $username,
                    strlen((string)$password),
                    strlen($storedTrim),
                    substr($storedTrim, 0, 10)
                );
                @file_put_contents(WRITEPATH . 'logs/auth-debug.txt', date('c') . ' ' . $debugInfo . "\n", FILE_APPEND);

                // Plaintext
                $plainOk = hash_equals((string)$storedTrim, (string)$password);
                if ($plainOk) {
                    $matches = true;
                }

                // Hex digests
                $md5Ok = $sha1Ok = $sha256Ok = false;
                if (!$matches) {
                    $lower = strtolower($storedTrim);
                    if (preg_match('/^[a-f0-9]{32}$/i', $storedTrim)) { // MD5
                        $md5Ok = hash_equals($lower, md5($password));
                        $matches = $md5Ok;
                    } elseif (preg_match('/^[a-f0-9]{40}$/i', $storedTrim)) { // SHA-1
                        $sha1Ok = hash_equals($lower, sha1($password));
                        $matches = $sha1Ok;
                    } elseif (preg_match('/^[a-f0-9]{64}$/i', $storedTrim)) { // SHA-256
                        $sha256Ok = hash_equals($lower, hash('sha256', $password));
                        $matches = $sha256Ok;
                    }
                }

                // crypt variants ($1$ MD5-crypt, $5$ SHA256-crypt, $6$ SHA512-crypt)
                $cryptOk = false;
                if (!$matches && str_starts_with($storedTrim, '$') && strlen($storedTrim) >= 12) {
                    $cryptOk = hash_equals(crypt($password, $storedTrim), $storedTrim);
                    $matches = $cryptOk;
                }

                // DEBUG: hasil checks
                $checkLine = sprintf(
                    'checks plain=%s md5=%s sha1=%s sha256=%s crypt=%s',
                    $plainOk ? '1' : '0',
                    $md5Ok ? '1' : '0',
                    $sha1Ok ? '1' : '0',
                    $sha256Ok ? '1' : '0',
                    $cryptOk ? '1' : '0'
                );
                @file_put_contents(WRITEPATH . 'logs/auth-debug.txt', date('c') . ' ' . $checkLine . "\n", FILE_APPEND);

                if ($matches) {
                    // Upgrade ke bcrypt
                    $this->userModel->updatePassword($user['user_id'], $password);
                    $isValid = true;
                    // Refresh data user setelah update
                    $user = $this->userModel->getUserByUsernameAndRole($username);
                }
            }

            if (!$isValid) {
                return redirect()->to("/")->with('error', 'Password salah. Silakan coba lagi');
            }

            if ((int)($user['is_active'] ?? 1) === 0) {
                return redirect()->to("/")->with('error', 'User belum aktif konfirmasi Ke Admin untuk Aktivasi');
            }

            $normalizedRole = $user['role'];
            // Normalisasi role agar konsisten (int 1/2)
            if (is_string($normalizedRole)) {
                $low = strtolower($normalizedRole);
                if ($low === 'admin') {
                    $normalizedRole = 1;
                } elseif ($low === 'pengelola rt' || $low === 'rt' || $low === 'user') {
                    $normalizedRole = 2;
                } elseif (is_numeric($normalizedRole)) {
                    $normalizedRole = (int)$normalizedRole;
                }
            }

            $sessionData = [
                'user_id'      => $user['user_id'],
                'username'     => $user['username'],
                'role'         => $normalizedRole,
                'email'        => $user['email'],
                'role_id'      => $user['role_id'],
                'wilayah_nama' => $user['wilayah_nama'],
                'rt_id'        => $user['rt_id'] ?? null,
                'logged_in'    => true
            ];
            $this->session->set($sessionData);
            return redirect()->to(base_url('dashboard'));
        }

        return redirect()->to("/")->with('error', 'Login Gagal User Tidak Ada');
    }


    public function logout()
    {
        $this->session->destroy();
        return redirect()->to("/");
    }
}
