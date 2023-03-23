<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
  protected $userModel;
  protected $db;
  protected $session;

  public function __construct()
  {
    $this->_akses();
    $this->userModel = new UserModel();
    $this->db = db_connect();
    $this->session = $this->db->table('login')->where('id', session('id'))->get()->getRowArray();
  }

  private function _akses()
  {
    if (!session('login')) {
      header('Location: /login');
      die;
    }
  }

  public function index()
  {
    $daftarUser = $this->userModel->getLogin();
    $jumlah     = $this->db->table('login')->where('level', 2)->get()->getResultArray();
    $data = [
      'judul'   => 'Daftar User | MAKNA DIST.',
      'user'    => $daftarUser,
      'session'  => $this->session,
      'jumlah'  => count($jumlah)
    ];

    return view('users/index', $data);
  }

  public function hapusUser($id)
  {
    $this->db->table('login')->where('id', $id)->delete();
    session()->setFlashdata('pesan', 'User berhasil dihapus');
    return redirect()->to('/users');
  }

  public function resetPass($id)
  {
    $pass = password_hash('qwerty12345', PASSWORD_DEFAULT);
    $this->db->table('login')->set('password', $pass)->where('id', $id)->update();
    session()->setFlashdata('pesan', 'Password berhasil di RESET');
    return redirect()->to('/users');
  }

  public function tambah()
  {
    $data = [
      'judul'   => 'Tambah Users | MAKNA DIST.',
      'session'  => $this->session,
      'validation'  => \Config\Services::validation()
    ];

    return view('users/tambah', $data);
  }

  public function tambahUser()
  {
    // validasi
    if (!$this->validate([
      'nama' => [
        'rules'  => 'required',
        'errors' => [
          'required'  => 'Nama tidak boleh kosong!'
        ]
      ],
      'email' => [
        'rules'  => 'required|is_unique[login.username]',
        'errors' => [
          'required'  => 'E-mail tidak boleh kosong!',
          'is_unique' => 'E-mail yang Anda masuklan sudah terdaftar!'
        ]
      ],
      'password' => [
        'rules'  => 'required|min_length[8]',
        'errors' => [
          'required'    => 'Masukan password!',
          'min_length'  => 'Minimal Password 8 Karakter'
        ]
      ],
      'password2' => [
        'rules'  => 'required|matches[password]',
        'errors' => [
          'required'  => 'Password tidak boleh kosong!',
          'matches'   => 'Passtikan anda memasukan password yang sama dengan diatas'
        ]
      ]
    ])) {
      $validation = \Config\Services::validation();
      return redirect()->to('/users/tambah')->withInput()->with('validation', $validation);
    }

    $pass = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);

    $data = [
      'nama'      => $this->request->getVar('nama'),
      'username'  => $this->request->getVar('email'),
      'password'  => $pass,
      'pic'       => 'profile.jpg',
      'level'     => 2
    ];

    $this->db->table('login')->insert($data);
    session()->setFlashdata('pesan', 'Berhasil menambahkan 1 User baru');
    return redirect()->to('/users');
  }
}
