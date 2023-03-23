<?php

namespace App\Controllers;

use App\Models\ProdukModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Produk extends BaseController
{
  protected $produkModel;
  protected $db;
  protected $session;

  public function __construct()
  {
    $this->_akses();
    $this->produkModel = new ProdukModel();
    $this->db = db_connect();
    $this->session = $this->db->table('login')->where('id', session('id'))->get()->getRowArray();
  }

  private function _akses()
  {
    if (!session('login')) {
      header('Location: /login');
      die();
    }
  }

  public function index()
  {
    $produk = $this->produkModel->findAll();
    helper('rupiah_helper');

    $data = [
      'judul'  => 'Produk | MAKNA DIST.',
      'session'  => $this->session,
      'produk' => $produk
    ];
    return view('produk/index', $data);
  }

  public function tambah()
  {
    $data = [
      'judul'      => 'Tambah Produk | MAKNA DIST.',
      'session'     => $this->session,
      'validation' => \Config\Services::validation()
    ];
    session()->setFlashdata('pesan', 'Produk baru berhasil ditambahkan');
    return view('produk/produk-tambah', $data);
  }

  public function simpan()
  {
    // validasi
    if (!$this->validate([
      'nama_alat' => [
        'rules'  => 'required|is_unique[tb_alat.nama_alat]',
        'errors' => [
          'required'  => 'Nama alat tidak boleh kososng!',
          'is_unique' => 'Nama alat yang Anda masuklan sudah terdaftar!'
        ]
      ],
      'kode_alat' => [
        'rules'  => 'required|is_unique[tb_alat.kode_alat]',
        'errors' => [
          'required'  => 'Kode alat tidak boleh kososng!',
          'is_unique' => 'Kode alat yang Anda masuklan sudah terdaftar!'
        ]
      ],
      'satuan' => [
        'rules'  => 'required',
        'errors' => [
          'required'  => 'Satuan tidak boleh kososng!'
        ]
      ],
      'harga' => [
        'rules'  => 'required',
        'errors' => [
          'required'  => 'Harga tidak boleh kosong!'
        ]
      ],
      'stok' => [
        'rules'  => 'required',
        'errors' => [
          'required'  => 'STOK tidak boleh kososng!'
        ]
      ]
    ])) {
      $validation = \Config\Services::validation();
      return redirect()->to('/produk/tambah')->withInput()->with('validation', $validation);
    }

    // mengembalikan format harga menjadi angka biasa
    $harga = explode(",", $this->request->getVar('harga'));
    $harga = explode(" ", $harga[0]);
    $harga = explode(".", $harga[1]);
    for ($i = 0; $i < count($harga); $i++) {
      $harga[$i];
    }
    $harga = implode($harga);

    $this->produkModel->save([
      'nama_alat' => $this->request->getVar('nama_alat'),
      'kode_alat' => $this->request->getVar('kode_alat'),
      'satuan'    => $this->request->getVar('satuan'),
      'expired'   => $this->request->getVar('expired'),
      'harga'     => $harga,
      'stok'      => $this->request->getVar('stok')
    ]);

    session()->setFlashdata('pesan', 'Data Produk Berhasil Ditambahkan');
    return redirect()->to('/produk');
  }

  public function ubah($id)
  {
    // mengembalikan format harga menjadi angka biasa
    $harga = explode(",", $this->request->getVar('harga'));
    $harga = explode(" ", $harga[0]);
    $harga = explode(".", $harga[1]);
    for ($i = 0; $i < count($harga); $i++) {
      $harga[$i];
    }
    $harga = implode($harga);

    $this->produkModel->save([
      'id'        => $id,
      'nama_alat' => $this->request->getVar('nama_alat'),
      'kode_alat' => $this->request->getVar('kode_alat'),
      'satuan'    => $this->request->getVar('satuan'),
      'expired'   => $this->request->getVar('expired'),
      'harga'     => $harga,
      'stok'      => $this->request->getVar('stok')
    ]);

    session()->setFlashdata('pesan', 'Data Produk Berhasil Diubah');
    return redirect()->to('/produk');
  }

  public function hapus($id)
  {
    $this->produkModel->delete($id);
    session()->setFlashdata('pesan', 'Data Produk Berhasil Dihapus!');
    return redirect()->to('/produk');
  }

  public function import()
  {
    $data = [
      'judul'   => 'Import Excel Produk | MAKNA DIST.',
      'session'  => $this->session
    ];

    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    return view('produk/import', $data);
  }

  public function import_excel()
  {
    $valid = $this->validate([
      'importexcel' => [
        'label'   => 'Inputan File Excel',
        'rules'   => 'uploaded[importexcel]|ext_in[importexcel,xls,xlsx]',
        'errors'  => [
          'uploaded'  => 'Pilih File yang ingin di import, Tidak Boleh Kosong!',
          'ext_in'    => 'Extensi yang bisa di import Xls dan Xlsx'
        ]
      ]
    ]);

    if (!$valid) {
      session()->setFlashdata('pesan', "Data tidak boleh kosong");
      return redirect()->to('/produk/import');
    } else {
      $file_excel = $this->request->getFile('importexcel');

      $ext = $file_excel->getClientExtension();

      if ($ext === 'xls') {
        // File excel 2007
        $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
      } else {
        // File excel 2010 keatas
        $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      }

      $spreadsheet = $render->load($file_excel);

      $data = $spreadsheet->getActiveSheet()->toArray();

      $jumlahErr = 0;
      $jumlahSucc = 0;
      foreach ($data as $x => $row) {
        if ($x == 0) {
          continue;
        }

        $namaAlat = $row[0];
        $kodeAlat = $row[1];
        $satuan = $row[2];
        $expired = $row[3];
        $harga = $row[4];
        $stok = $row[5];

        $db = \Config\Database::connect();

        $cekKodeAlat = $db->table('tb_alat')->getWhere(['kode_alat' => $kodeAlat])->getResult();

        if (count($cekKodeAlat) > 0) {
          $jumlahErr++;
        } else {
          $dataSimpan = [
            'id'          => '',
            'nama_alat'   => $namaAlat,
            'kode_alat'   => $kodeAlat,
            'satuan'      => $satuan,
            'expired'     => $expired,
            'harga'       => $harga,
            'stok'        => $stok
          ];

          $db->table('tb_alat')->insert($dataSimpan);
          $jumlahSucc++;
        }
      }

      session()->setFlashdata('sukses', "<span style='padding: 5px; background: red; color: white; font-weight: bolder;'>$jumlahErr Data tidak bisa disimpan</span>
                      <span style='padding: 5px; background: green; color: white; font-weight: bolder;'>$jumlahSucc Berhasil disimpan</span>");

      return redirect()->to('/produk/import');
    }
  }

  public function template_excel()
  {
    $spreadsheet = new Spreadsheet();

    $spreadsheet->getActiveSheet()
      ->setCellValue('A1', "NAMA ALAT")
      ->setCellValue('B1', "KODE ALAT")
      ->setCellValue('C1', "SATUAN")
      ->setCellValue('D1', "EXPIRED")
      ->setCellValue('E1', "HARGA")
      ->setCellValue('F1', "STOK");

    // set Zoom Scale
    $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(140);

    // alignment
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // font
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(12)->setBold(true);

    // fill
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('76C5D1');

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('A')
      ->setWidth(35);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('B')
      ->setWidth(20);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('C')
      ->setWidth(10);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('D')
      ->setWidth(15);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('E')
      ->setWidth(17);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('F')
      ->setWidth(9);

    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Template Import Excel.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    die;
  }
}
