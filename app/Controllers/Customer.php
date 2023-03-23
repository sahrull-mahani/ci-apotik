<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customer extends BaseController
{
  protected $customerModel;
  protected $db;
  public function __construct()
  {
    $this->_akses();
    $this->customerModel = new CustomerModel();
    $this->db = db_connect();
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
    $customer = $this->customerModel->findAll();

    $data = [
      'judul'    => 'Customer | MAKNA DIST.',
      'session'  => $this->db->table('login')->where('id', session('id'))->get()->getRowArray(),
      'customer' => $customer
    ];

    return view('customer/index', $data);
  }

  public function tambah()
  {
    $data = [
      'judul'       => 'Tambah Data Customer | MAKNA DIST.',
      'session'  => $this->db->table('login')->where('id', session('id'))->get()->getRowArray(),
      'validation'  => \Config\Services::validation()
    ];

    return view('customer/tambah', $data);
  }

  public function simpan()
  {
    if (!$this->validate([
      'kode_customer' => [
        'rules'   => 'required|is_unique[tb_customer.kode_customer]',
        'errors'  => [
          'required'  => 'Kode Customer Harus dimasukan!',
          'is_unique' => 'Kode Customer Sudah Pernah Terdaftar!'
        ]
      ],
      'nama_customer' => [
        'rules'   => 'required|is_unique[tb_customer.nama_customer]',
        'errors'  => [
          'required'  => 'Nama Customer harus dimasukan!',
          'is_unique' => 'Nama customer terdaftar'
        ]
      ],
      'alamat'  => [
        'rules'   => 'required',
        'errors'  => [
          'required' => 'Alamat harus dimasukan!'
        ]
      ],
      'telp'  => [
        'rules'   => 'required',
        'errors'  => [
          'required' => 'Telefon harus dimasukan!'
        ]
      ],
      'faks'  => [
        'rules'   => 'required',
        'errors'  => [
          'required' => 'Faks harus dimasukan, Jika tidak ada masukan "-"'
        ]
      ],
      'email'  => [
        'rules'   => 'required',
        'errors'  => [
          'required' => 'E-mail harus dimasukan!'
        ]
      ]
    ])) {
      $validation = \Config\Services::validation();
      return redirect()->to('/customer/tambah')->withInput()->with('validation', $validation);
    }

    $this->customerModel->save([
      'kode_customer' => $this->request->getVar('kode_customer'),
      'nama_customer' => $this->request->getVar('nama_customer'),
      'alamat'        => $this->request->getVar('alamat'),
      'telp'          => $this->request->getVar('telp'),
      'faks'          => $this->request->getVar('faks'),
      'email'         => $this->request->getVar('email'),
    ]);

    session()->setFlashdata('pesan', 'Data Customer Berhasil Ditambahkan');
    return redirect()->to('/customer');
  }

  public function ubah($kodeCustomer)
  {
    $this->customerModel->replace([
      'kode_customer' => $kodeCustomer,
      'nama_customer' => $this->request->getVar('nama_customer'),
      'alamat'        => $this->request->getVar('alamat'),
      'telp'          => $this->request->getVar('telp'),
      'faks'          => $this->request->getVar('faks'),
      'email'         => $this->request->getVar('email'),
    ]);

    session()->setFlashdata('msg', 'Data Customer Berhasil Diubah');
    return redirect()->to('/customer');
  }

  public function hapus($kodeCustomer)
  {
    $this->customerModel->where('kode_customer', $kodeCustomer)->delete();
    session()->setFlashdata('pesan', 'Data Customer Berhasil Dihapus!');
    return redirect()->to('/customer');
  }
}
