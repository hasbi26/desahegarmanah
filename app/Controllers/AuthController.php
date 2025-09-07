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
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[6]',
        ];

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $this->userModel->getUserByUsernameAndRole($username);
        if ($user) {
            if (!password_verify($password, $user['password'])) {
                // Catat upaya login gagal
                // $this->authLogger->logFailedAttempt($user['id']);
                return redirect()->to("/")->with('error', 'Password salah. Silakan coba lagi');
            }
            if($user['is_active'] == 0){
                return redirect()->to("/")->with('error', 'User belum aktif konfirmasi Ke Admin untuk Aktivasi');                
            }

            $sessionData = [
                'user_id'      => $user['user_id'],
                'username'     => $user['username'],
                'role'         => $user['role'],
                'email'         => $user['email'],
                'role_id'      => $user['role_id'],
                'wilayah_nama' => $user['wilayah_nama'], // langsung dapat
                'logged_in'    => true
            ];
            $this->session->set($sessionData);
            return redirect()->to(base_url('dashboard'));
        }

        return redirect()->to("/")->with('error', 'Login Gagal User Tidak Ada');
    }


    public function logout()
    {
    
    // Hancurkan session
    $this->session->destroy();
    
    // Redirect langsung ke halaman sesuai role
    return redirect()->to("/");
    }
}
