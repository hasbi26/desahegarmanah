<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RTModel;

class UsersController extends BaseController
{
    protected $userModel;
    protected $rtModel;

    public function __construct()
    {
        helper(['form']);
        $this->userModel = new UserModel();
        $this->rtModel = new RTModel();
    }

    public function index()
    {
        // Only admin or desa/admin
        $__role = strtolower((string)session('role'));
        if ($__role !== 'admin' && $__role !== 'desa/admin') {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'message' => 'Akses ditolak']);
            }
            return redirect()->to('dashboard')->with('error', 'Akses ditolak');
        }

        $q = trim((string)($this->request->getGet('q') ?? ''));
        $page = max(1, (int)($this->request->getGet('page') ?? 1));
        $perPage = 10;

        $builder = $this->userModel->db->table('user u')
            ->select('u.id, u.username, u.email, u.role, u.rt_id, u.is_active, r.rt, r.rw')
            ->join('rts r', 'r.id = u.rt_id', 'left');
        if ($q !== '') {
            $builder->groupStart()
                ->like('u.username', $q)
                ->orLike('u.email', $q)
                ->groupEnd();
        }
        $total = $builder->countAllResults(false);
        $builder->orderBy('u.id', 'DESC')->limit($perPage, ($page - 1) * $perPage);
        $items = $builder->get()->getResultArray();

        // Pagination logic
        $totalPages = (int)ceil($total / $perPage);
        $pagination = [];
        if ($totalPages > 10) {
            for ($i = 1; $i <= 10; $i++) {
                $pagination[] = $i;
            }
            $pagination['next'] = $page < $totalPages ? $page + 1 : null;
        } else {
            for ($i = 1; $i <= $totalPages; $i++) {
                $pagination[] = $i;
            }
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'ok',
                'items' => $items,
                'page' => $page,
                'perPage' => $perPage,
                'totalPages' => $totalPages,
                'total' => $total,
            ]);
        }
        
        return view('users/index', [
            'title' => 'Pengguna',
            'items' => $items,
            'q' => $q,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages,
            'pagination' => $pagination,
        ]);
    }

    public function create()
    {
        $__role = session('role');
        $__isAdmin = in_array(strtolower((string)($__role ?? '')), ['admin', 'desa/admin']);
        if (!$__isAdmin) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak');
        }
        $rtOptions = $this->rtModel->select('id, rt, rw')->orderBy('rt')->findAll();
        return view('users/form', ['title' => 'Tambah Pengguna', 'rtOptions' => $rtOptions]);
    }

    public function store()
    {
        $__role = session('role');
        $__isAdmin = in_array(strtolower((string)($__role ?? '')), ['admin', 'desa/admin']);
        if (!$__isAdmin) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak');
        }
        $username = trim((string)$this->request->getPost('username'));
        $email = trim((string)$this->request->getPost('email'));
        $password = (string)$this->request->getPost('password');
        $rtId = (int)$this->request->getPost('rt_id');
        $role = $this->request->getPost('role');
        $isActive = (int)$this->request->getPost('is_active') === 1 ? 1 : 0;

        if ($username === '' || $password === '' || $rtId <= 0 || $role === '') {
            return redirect()->back()->with('error', 'Username, Password, RT, dan Role wajib diisi')->withInput();
        }
        if (!in_array($role, ['desa/admin', 'rt', 'kecamatan', 'kabupaten'], true)) {
            return redirect()->back()->with('error', 'Role tidak valid')->withInput();
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Format email tidak valid')->withInput();
        }
        // Cek unik username
        $exists = $this->userModel->where('username', $username)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Username sudah digunakan')->withInput();
        }

        $data = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'rt_id' => $rtId,
            'is_active' => $isActive,
        ];
        $this->userModel->insert($data);
        return redirect()->to(base_url('users'))->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $__role = session('role');
        $__isAdmin = in_array(strtolower((string)($__role ?? '')), ['admin', 'desa/admin']);
        if (!$__isAdmin) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak');
        }
        $item = $this->userModel->find($id);
        if (!$item) return redirect()->to(base_url('users'))->with('error', 'User tidak ditemukan');
        $rtOptions = $this->rtModel->select('id, rt, rw')->orderBy('rt')->findAll();
        return view('users/form', ['title' => 'Edit Pengguna', 'item' => $item, 'rtOptions' => $rtOptions]);
    }

    public function update($id)
    {
        $__role = session('role');
        $__isAdmin = in_array(strtolower((string)($__role ?? '')), ['admin', 'desa/admin']);
        if (!$__isAdmin) {
            return redirect()->to('dashboard')->with('error', 'Akses ditolak');
        }
        $username = trim((string)$this->request->getPost('username'));
        $email = trim((string)$this->request->getPost('email'));
        $rtId = (int)$this->request->getPost('rt_id');
        $role = $this->request->getPost('role');
        $isActive = (int)$this->request->getPost('is_active') === 1 ? 1 : 0;
        if ($username === '' || $rtId <= 0 || $role === '') {
            return redirect()->back()->with('error', 'Username, RT, dan Role wajib diisi')->withInput();
        }
        if (!in_array($role, ['desa/admin', 'rt', 'kecamatan', 'kabupaten'], true)) {
            return redirect()->back()->with('error', 'Role tidak valid')->withInput();
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Format email tidak valid')->withInput();
        }
        // Cek unik username (kecuali dirinya)
        $exists = $this->userModel->where('username', $username)->where('id !=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Username sudah digunakan')->withInput();
        }

        $payload = [
            'username' => $username,
            'email' => $email,
            'rt_id' => $rtId,
            'role' => $role,
            'is_active' => $isActive,
        ];
        $password = (string)$this->request->getPost('password');
        if ($password !== '') {
            $payload['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->userModel->update($id, $payload);
        // If the currently logged-in user updated their own account, refresh session values
        try {
            $current = session('user_id');
            if ($current && (int)$current === (int)$id) {
                $sess = session();
                $sess->set([
                    'username' => $username,
                    'email' => $email,
                    'role' => $role,
                    'rt_id' => $rtId,
                ]);
            }
        } catch (\Throwable $e) {
            // avoid breaking flow on session set errors; log for debugging
            log_message('error', 'Failed to refresh session after user update: ' . $e->getMessage());
        }
        return redirect()->to(base_url('users'))->with('success', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        $__role = session('role');
        $__isAdmin = in_array(strtolower((string)($__role ?? '')), ['admin', 'desa/admin']);
        if (!$__isAdmin) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'message' => 'Akses ditolak']);
            }
            return redirect()->to('dashboard')->with('error', 'Akses ditolak');
        }
        $this->userModel->delete($id);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'ok',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash(),
                ],
            ]);
        }
        return redirect()->to(base_url('users'))->with('success', 'User dihapus');
    }
}
