<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Login extends BaseController
{
  protected $loginModel;
  protected $db;

  public function __construct()
  {
    $this->_akses();
    $this->loginModel = new LoginModel();
    $this->db = db_connect();
  }

  private function _akses()
  {
    if (session('login')) {
      header('Location: /');
      die;
    }
  }

  public function index()
  {
    $data = [
      'judul'       => 'LOGIN | MAKNA DIST.',
      'validation'  => \Config\Services::validation()
    ];

    return view('login/index', $data);
  }

  public function login()
  {
    if (!$this->validate([
      'email' => [
        'rules'   => 'required',
        'errors'  => [
          'required'    => 'E-mail harus dimasukan'
        ]
      ],
      'password'  => [
        'rules'   => 'required',
        'errors'  => [
          'required'  => 'Masukan password'
        ]
      ]
    ])) {
      return redirect()->to('/login')->withInput();
    }
    $username = $this->request->getVar('email');
    $password = $this->request->getVar('password');

    $res = $this->db->table('login')->where('username', $username)->get()->getResultArray();

    if (count($res) > 0) {
      if (password_verify($password, $res[0]['password'])) {
        session()->set('login', true);
        session()->set('id', $res[0]['id']);

        return redirect()->to('/home');
      }

      // jika password salah
      session()->setFlashdata('gagal', 'Periksa kembali password anda!');
      return redirect()->to('/login');
    }

    // jika username salah
    session()->setFlashdata('gagal', 'Periksa kembali username anda!');
    return redirect()->to('/login');
  }
}
