<?php
namespace App\Controllers;
use App\Models\UserModel;


class DashboardController extends BaseController
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


    public function index()
    {

        if (!$this->session->get('logged_in')) {
            return redirect()->to('/')
                             ->with('error', 'Silakan login terlebih dahulu');
        }

        $data = [
            'title' => 'Form SDGS',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama')
        ];


        return view('pages/dashboard', $data);
    }

    public function settings()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/')
                             ->with('error', 'Silakan login terlebih dahulu');
        }


        $data = [
            'title' => 'Settings',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama')
        ];
        return view('pages/settings', $data);
    }

    public function keluarga()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/')
                             ->with('error', 'Silakan login terlebih dahulu');
        }


        $data = [
            'title' => 'KUESIONER RUMAH TANGGA',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama')
        ];
        return view('pages/keluarga', $data);
    }

    public function formIndividu(){

        if (!$this->session->get('logged_in')) {
            return redirect()->to('/')
                             ->with('error', 'Silakan login terlebih dahulu');
        }


        $data = [
            'title' => 'KUESIONER Individu',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama')
        ];
        return view('pages/form_individu', $data);
        
    }
}