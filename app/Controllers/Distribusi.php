<?php

namespace App\Controllers;

use App\Models\DistribusiModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class Distribusi extends BaseController
{
  protected $distribusiModel;
  protected $db;
  protected $session;

  public function __construct()
  {
    $this->_akses();
    // Initial
    $this->distribusiModel = new DistribusiModel;
    $this->db = db_connect();
    $this->dataAlat = $this->distribusiModel->getAlat();
    $this->dataCustomer = $this->distribusiModel->getCustomer();
    $this->dataSementara = $this->distribusiModel->getSementara();
    $this->dataSementaraAlat = $this->distribusiModel->getSementaraAlat();
    $this->session = $this->db->table('login')->where('id', session('id'))->get()->getRowArray();
    helper('rupiah_helper');
    helper('tanggal_indo_helper');
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
    $distribusi = $this->distribusiModel->getInvoice();

    $data = [
      'judul'       => 'Distribusi Produk | PT. MAKNA DIST.',
      'session'     => $this->session,
      'distribusi'  => $distribusi,
      'jumlah'      => $this->db->table('tb_pesan')
    ];

    return view('distribusi/index', $data);
  }

  public function jumlahStok()
  {
    $alat = $this->request->getPost('alat');
    $query = $this->db->query("SELECT * FROM tb_alat WHERE kode_alat = '$alat'");
    $result = $query->getRow();

    if ($result) {
      echo $result->stok;
    } else {
      echo "-- Pilih Produk";
    }
  }

  public function hapusInv($kdCustomer)
  {
    $query = $this->db->table('tb_pesan')->join('tb_alat', 'tb_pesan.kode_alat = tb_alat.kode_alat')->get()->getResultArray();

    $i = 0;
    foreach ($query as $q) {
      $i++;
      $kode[$i] = $q['kode_alat'];
      $stok[$i] = $q['stok'];
      $jumlahAlat[$i] = $q['jumlah'];

      // update jumlah alat d table alat
      $stokUpdate[$i] = $stok[$i] + $jumlahAlat[$i];
      $this->db->query("UPDATE tb_alat SET stok = $stokUpdate[$i] WHERE kode_alat = '$kode[$i]'");
    }

    $this->db->query("DELETE FROM tb_pesan WHERE kode_customer = '$kdCustomer'");
    $this->db->query("DELETE FROM tb_invoice WHERE kode_customer = '$kdCustomer'");
    $this->db->query("UPDATE tb_customer SET konfir=0 WHERE kode_customer = '$kdCustomer'");

    session()->setFlashdata('pesan', 'Data Berhasil Dihapus');

    return redirect()->to('/distribusi');
  }

  public function tambah()
  {
    $data = [
      'judul'       => 'Tambah Distribusi Produk | PT. MAKNA DIST.',
      'session'  => $this->db->table('login')->where('id', session('id'))->get()->getRowArray(),
      'dataAlat'  => $this->dataAlat,
      'dataCustomer'  => $this->dataCustomer,
      'dataSementaraAlat'  => $this->dataSementaraAlat,
      'session'     => $this->session
    ];

    return view('distribusi/tambah', $data);
  }

  public function tambahProduk()
  {
    $nama_kodeAlat = explode("|", $this->request->getVar('alatSelect'));
    $alat = $nama_kodeAlat[0];
    $nama = $nama_kodeAlat[1];
    $disc = !empty($this->request->getVar('disc')) ? $this->request->getVar('disc') : '0';
    $jumlah = $this->request->getVar('jumlah');

    // get harga dari table alat
    $queryAlat = $this->db->query("SELECT * FROM tb_alat WHERE kode_alat = '$alat'");
    $resultAlat = $queryAlat->getRow();

    // get Data dari table sementara
    $querySementara = $this->db->query("SELECT * FROM tb_sementara WHERE kode_alat = '$alat'");
    $resultSementara = $querySementara->getRow();

    if (@$resultSementara->kode_alat === $alat) {
      $jumlahUpdate = $resultSementara->jumlah + $jumlah;
      $this->db->query("UPDATE tb_sementara SET jumlah = '$jumlahUpdate', disc = '$disc' WHERE kode_alat = '$alat'");
    } else {
      $this->db->query("INSERT INTO tb_sementara VALUES ('','$alat', '$nama', '$resultAlat->harga', '$disc', '$jumlah') ");
    }

    $stokUpdate = $resultAlat->stok - $jumlah;
    $this->db->query("UPDATE tb_alat SET stok = '$stokUpdate' WHERE kode_alat = '$alat'");

    session()->setFlashdata('pesan', 'Produk Berhasil Ditambahkan');

    return redirect()->to('/distribusi/tambah');
  }

  public function hapus($alat)
  {
    // get Data alat dari table alat
    $queryAlat = $this->db->query("SELECT * FROM tb_alat WHERE kode_alat = '$alat'");
    $resultAlat = $queryAlat->getRow();

    // get Data dari table sementara
    $querySementara = $this->db->query("SELECT * FROM tb_sementara WHERE kode_alat = '$alat'");
    $resultSementara = $querySementara->getRow();

    // update stok
    $stokUpdate = $resultAlat->stok + @$resultSementara->jumlah;

    $this->db->query("UPDATE tb_alat SET stok = '$stokUpdate' WHERE kode_alat = '$alat'");
    $this->db->query("DELETE FROM tb_sementara WHERE kode_alat = '$alat'");

    session()->setFlashdata('pesan', 'Produk Berhasil Dihapus');

    return redirect()->to('/distribusi/tambah');
  }

  public function simpan()
  {
    $kdCustomer = $this->request->getPost('customer');

    for ($i = 0; $i < count($this->dataSementara); $i++) {
      $total[$i] = $this->dataSementara[0]['jumlah'];
    }

    // jumlah Alat di table sementara
    $total = array_sum($total);

    // buat tanggal sekarang
    $tanggal = date("d/") . bulanIni() . "/" . date("Y");

    // Buat Invoice
    $invoice = "INV/" . date("d") . "/" . $kdCustomer . "/" . substr("000{$total}", -3) . "/" . random_int(1, 1000);

    $suc = $this->db->query("INSERT INTO tb_invoice VALUES('', '$kdCustomer', '$total', '$tanggal', '$invoice')");

    if ($suc) {
      $this->db->query("INSERT INTO tb_pesan (kode_alat, nama_alat, kode_customer, harga, disc, jumlah) SELECT kode_alat, nama_alat, '$kdCustomer', harga, disc, jumlah FROM tb_sementara");
      $this->db->query("TRUNCATE TABLE tb_sementara");
      $this->db->query("UPDATE tb_customer SET konfir = 1 WHERE kode_customer = '$kdCustomer'");
      echo "berhasil";
    } else {
      echo "gagal";
    }
  }

  public function edit($kdCustomer)
  {
    $query = $this->db->table('tb_pesan')->join('tb_alat', 'tb_pesan.kode_alat = tb_alat.kode_alat')->where('tb_pesan.kode_customer', $kdCustomer)->get()->getResultArray();
    $customerEdit = $this->db->table('tb_customer')->where('kode_customer', $kdCustomer)->get()->getRow();

    $data = [
      'judul'   => 'Edit Data Invoice | MAKNA DIST.',
      'dataAlat'  => $this->dataAlat,
      'namaCustomer'  => $customerEdit->nama_customer,
      'dataSementaraAlat'  => $this->dataSementaraAlat,
      'dataEdit'  => $query,
      'kodeCustomer' => $kdCustomer,
      'session'     => $this->session
    ];

    return view('distribusi/edit', $data);
  }

  public function editProduk()
  {
    $nama_kodeAlat = explode("|", $this->request->getVar('alatSelect'));
    $alat = $nama_kodeAlat[0];
    $nama = $nama_kodeAlat[1];
    $disc = !empty($this->request->getVar('disc')) ? $this->request->getVar('disc') : '0';
    $jumlah = $this->request->getVar('jumlah');
    $kodeCustomer = $this->request->getVar('kodeCustomer');

    // get harga dari table alat
    $queryAlat = $this->db->query("SELECT * FROM tb_alat WHERE kode_alat = '$alat'");
    $resultAlat = $queryAlat->getRow();

    // get Data dari table pesan
    $queryPesan = $this->db->query("SELECT * FROM tb_pesan WHERE kode_alat = '$alat' AND kode_customer = '$kodeCustomer'");
    $resultPesan = $queryPesan->getRow();

    if (@$resultPesan->kode_alat === $alat) {
      $jumlahUpdate = $resultPesan->jumlah + $jumlah;
      $this->db->query("UPDATE tb_pesan SET jumlah = '$jumlahUpdate', disc = '$disc' WHERE kode_alat = '$alat' AND kode_customer = '$kodeCustomer'");
    }

    if (@$resultPesan->kode_alat != $alat) {
      $this->db->query("INSERT INTO tb_pesan VALUES ('','$alat', '$nama', '$kodeCustomer', '$resultAlat->harga', '$disc', '$jumlah')");
    }

    // update stok
    $stokUpdate = $resultAlat->stok - $jumlah;
    $this->db->query("UPDATE tb_alat SET stok = '$stokUpdate' WHERE kode_alat = '$alat'");

    session()->setFlashdata('pesan', 'Data ' . $nama . ' Berhasil Ditambahkan');

    return redirect()->to('/distribusi/edit/' . $kodeCustomer);
  }

  public function hapusEdit($alat, $customer)
  {
    // get Data alat dari table alat
    $queryAlat = $this->db->query("SELECT * FROM tb_alat WHERE kode_alat = '$alat'");
    $resultAlat = $queryAlat->getRow();

    // get Data dari table pesan
    $queryPesan = $this->db->query("SELECT * FROM tb_pesan WHERE kode_alat = '$alat' AND kode_customer = '$customer'");
    $resultPesan = $queryPesan->getRow();

    // update stok
    $stokUpdate = $resultAlat->stok + @$resultPesan->jumlah;

    $this->db->query("UPDATE tb_alat SET stok = '$stokUpdate' WHERE kode_alat = '$alat'");
    $this->db->query("DELETE FROM tb_pesan WHERE kode_alat = '$alat' AND kode_customer = '$customer'");

    session()->setFlashdata('pesan', 'Produk ' . $alat . ' Berhasil Dihapus');

    return redirect()->to('/distribusi/edit/' . $customer);
  }

  public function simpanEdit()
  {
    $kdCustomer = $this->request->getPost('customer');

    $dataPesan = $this->db->table('tb_pesan')->where('kode_customer', $kdCustomer)->get()->getResultArray();

    for ($i = 0; $i < count($dataPesan); $i++) {
      $ttl[$i] = $dataPesan[0]['jumlah'];
    }

    // jumlah Alat di table sementara
    $total = array_sum($ttl);

    // buat tanggal sekarang
    $tanggal = date("d/") . bulanIni() . "/" . date("Y");

    // Buat Invoice
    $invoice = "INV/" . date("d") . "/" . $kdCustomer . "/" . substr("000{$total}", -3) . "/" . random_int(1, 1000);

    $suc = $this->db->query("UPDATE tb_invoice SET jumlah_alat = '$total', tanggal = '$tanggal', invoice = '$invoice' WHERE kode_customer = '$kdCustomer'");

    if ($suc) {
      echo "berhasil";
    } else {
      echo "gagal";
    }
  }

  public function invoice($kdCustomer)
  {
    $jumlahPesan = $this->db->table("tb_pesan ")->where("kode_customer", $kdCustomer)->get()->getResultArray();
    $max = 10;
    $tot = ceil(count($jumlahPesan) / $max);

    $query = $this->db->table('tb_pesan')
      ->join('tb_customer', 'tb_pesan.kode_customer = tb_customer.kode_customer')
      ->join('tb_invoice', 'tb_customer.kode_customer = tb_invoice.kode_customer')->where('tb_pesan.kode_customer', $kdCustomer)->get()->getRowArray();

    $data = [
      'judul'         => 'Print Invoice | MAKNA DIST.',
      'max'           => $max,
      'tot'           => $tot,
      'dataCustomer'  => $query,
      'jumlahPesan'   => $jumlahPesan,
      'dataPA'        => $this->db,
      'kdCustomer'    => $kdCustomer,
      'session'     => $this->session
    ];

    return view('distribusi/invoice', $data);
  }

  public function excel($kdCustomer)
  {
    $query = $this->db->table('tb_pesan')->where('kode_customer', $kdCustomer)->get()->getResultArray();
    $jumlah = count($query);

    $query2 = $this->db->table('tb_pesan')->join('tb_customer', 'tb_pesan.kode_customer = tb_customer.kode_customer')->join('tb_invoice', 'tb_customer.kode_customer = tb_invoice.kode_customer')->where('tb_pesan.kode_customer', $kdCustomer)->get()->getRowArray();

    $n = 0;
    foreach ($query as $row) {
      $n++;
      $ttl = $row['harga'] * $row['jumlah'] - ($row['disc'] / 100) * $row['harga'] * $row['jumlah'];
      $total[$n] = $ttl;
    }

    $spreadsheet = new Spreadsheet();

    // jumlah maximal data tampil
    $max = 10;

    // total looping dibulatkan keatas
    $tot = ceil($jumlah / $max);
    $rowCount = 0;

    $loop = 1;

    for ($i = 1; $i <= $tot; $i++) {

      // HEADER
      $spreadsheet->getActiveSheet()
        ->setCellValue('A' . $loop, "PT MAKNA KARYA SELARAS")
        ->setCellValue('A' . ($loop + 1), "Trading & Logistik")
        ->setCellValue('A' . ($loop + 2), "Jl. Kalimantan")
        ->setCellValue('A' . ($loop + 3), "Liluwo, Gorontalo 96126")
        ->setCellValue('F' . ($loop + 2), "Telp:")
        ->setCellValue('F' . ($loop + 3), "Faks:")
        ->setCellValue('G' . ($loop + 2), "(0435) - 833628")
        ->setCellValue('G' . ($loop + 3), "(0435) - 833628")
        ->setCellValue('A' . ($loop + 4), "Kepada:")
        ->setCellValue('A' . ($loop + 5), "Alamat:")
        ->setCellValue('B' . ($loop + 4), $query2['nama_customer'])
        ->setCellValue('B' . ($loop + 5), $query2['alamat'])
        ->setCellValue('D' . ($loop + 4), "Telp:")
        ->setCellValue('D' . ($loop + 5), "Faks:")
        ->setCellValue('D' . ($loop + 6), "Email:")
        ->setCellValue('E' . ($loop + 4), $query2['telp'])
        ->setCellValue('E' . ($loop + 5), empty($query2['faks']) ? '-' : $query2['faks'])
        ->setCellValue('E' . ($loop + 6), $query2['email'])
        ->setCellValue('F' . ($loop + 4), "No Faktur:")
        ->setCellValue('F' . ($loop + 5), "Jatuh Tempo:")
        ->setCellValue('F' . ($loop + 6), "Kontak:")
        ->setCellValue('H' . ($loop + 4), $query2['invoice'])
        ->setCellValue('H' . ($loop + 5), "")
        ->setCellValue('H' . ($loop + 6), "APOTEK")
        ->setCellValue('A' . ($loop + 8), "Tanggal")
        ->setCellValue('B' . ($loop + 8), "No. Item")
        ->setCellValue('C' . ($loop + 8), "Deksripsi")
        ->setCellValue('F' . ($loop + 8), "Jlh")
        ->setCellValue('G' . ($loop + 8), "Harga + PPN")
        ->setCellValue('H' . ($loop + 8), "Diskon")
        ->setCellValue('J' . ($loop + 8), "Total");

      $row = 9 + $loop;
      // menampilkan data Pesan 
      $query3 = $this->db->table("tb_pesan")->join("tb_alat", "tb_pesan.kode_alat = tb_alat.kode_alat")->limit($max, $rowCount)->where('kode_customer', $kdCustomer)->get()->getResultArray();
      foreach ($query3 as $baris) {
        $spreadsheet->getActiveSheet()
          ->setCellValue('A' . $row, $baris['expired'])
          ->setCellValue('B' . $row, strtoupper($baris['kode_alat']))
          ->setCellValue('C' . $row, ucwords($baris['nama_alat']))
          ->setCellValue('F' . $row, $baris['jumlah'])
          ->setCellValue('G' . $row, rupiahRp($baris['harga']))
          ->setCellValue('H' . $row, $baris['disc'] == 0 ? '0 %' : $baris['disc'] . ' %')
          ->setCellValue('J' . $row, rupiahRp($baris['jumlah'] * $baris['harga'] - ($baris['disc'] / 100) * $baris['jumlah'] * $baris['harga']));

        // Merge Cell
        $spreadsheet->getActiveSheet()->mergeCells('B' . ($loop + 5) . ':C' . ($loop + 6));
        $spreadsheet->getActiveSheet()->mergeCells("E" . ($loop + 6) . ":E" . ($loop + 7));
        $spreadsheet->getActiveSheet()->mergeCells("F" . ($loop + 4) . ":G" . ($loop + 4));
        $spreadsheet->getActiveSheet()->mergeCells("F" . ($loop + 5) . ":G" . ($loop + 5));
        $spreadsheet->getActiveSheet()->mergeCells("F" . ($loop + 6) . ":G" . ($loop + 6));
        $spreadsheet->getActiveSheet()->mergeCells("C" . ($loop + 8) . ":E" . ($loop + 8));
        $spreadsheet->getActiveSheet()->mergeCells("H" . ($loop + 8) . ":I" . ($loop + 8));
        $spreadsheet->getActiveSheet()->mergeCells("J" . ($loop + 8) . ":M" . ($loop + 8));
        $spreadsheet->getActiveSheet()->mergeCells("C" . $row . ":E" . $row);
        $spreadsheet->getActiveSheet()->mergeCells("H" . $row . ":I" . $row);
        $spreadsheet->getActiveSheet()->mergeCells("J" . $row . ":M" . $row);

        // Alignment
        $spreadsheet->getActiveSheet()->getStyle('B' . ($loop + 5) . ':C' . ($loop + 6))->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('E' . ($loop + 6) . ':E' . ($loop + 7))->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('F' . ($loop + 2) . ':F' . ($loop + 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('D' . ($loop + 4) . ':D' . ($loop + 6))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('F' . ($loop + 4) . ':F' . ($loop + 6))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C' . ($loop + 8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('G' . ($loop + 8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('H' . ($loop + 8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('J' . ($loop + 8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('J' . ($loop + 8) . ':J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // set Borders
        $spreadsheet->getActiveSheet()->getStyle('A' . ($loop + 8) . ':M' . ($loop + 8))->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('00000000'));
        $spreadsheet->getActiveSheet()->getStyle('A' . ($loop + 8) . ':M' . ($loop + 8))->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('00000000'));

        // set Font
        $spreadsheet->getActiveSheet()->getStyle('A' . ($loop))->getFont()->setSize(40);
        $spreadsheet->getActiveSheet()->getStyle('A' . ($loop + 8) . ':J' . ($loop + 8))->getFont()->setBold(true);

        $row++;
      }

      $loop = $loop + 29;
      $rowCount = $rowCount + $max;
    }

    // =============== TOTAL ============================
    $spreadsheet->getActiveSheet()->setCellValue('G' . $row, "Subtotal Faktur");
    $spreadsheet->getActiveSheet()->setCellValue('A' . ($row), "Rekening BCA: An PT. MAKNA 797 5516 385");
    $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 1), "Rekening Mandiri: An PT. MAKNA 150 00 1610394");
    $spreadsheet->getActiveSheet()->setCellValue('G' . ($row + 2), "Total");
    $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 3), "Admin");
    $spreadsheet->getActiveSheet()->setCellValue('C' . ($row + 3), "Penerima");
    $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 6), "Yuli");
    $spreadsheet->getActiveSheet()->setCellValue('C' . ($row + 6), "....................");

    $spreadsheet->getActiveSheet()->setCellValue('J' . $row, rupiahRp(array_sum($total)));
    $spreadsheet->getActiveSheet()->setCellValue('J' . ($row + 2), rupiahRp(array_sum($total)));

    $spreadsheet->getActiveSheet()->mergeCells("J" . $row . ":M" . $row);
    $spreadsheet->getActiveSheet()->mergeCells("J" . ($row + 2) . ":M" . ($row + 2));

    $spreadsheet->getActiveSheet()->getStyle('A10:J' . ($row + 7))->getFont()->setSize(38)->setName('Arial');
    $spreadsheet->getActiveSheet()->getStyle('A' . ($row) . ':A' . ($row + 1))->getFont()->setSize(32)->setName('Arial');

    $spreadsheet->getActiveSheet()->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('G' . ($row + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

    $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':M' . $row)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('00000000'));
    // =============== /.TOTAL ============================

    // set Zoom Scale
    $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(50);

    // Set no gridlines
    $spreadsheet->getActiveSheet()->setShowGridlines(False);

    // font
    $spreadsheet->getActiveSheet()->getStyle('A2:M9')->getFont()->setSize(38)->setName('Arial');

    // set Paper
    $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
    $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);
    // set margins
    $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.748031);
    $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.23622);
    $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.23622);
    $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.748031);
    $spreadsheet->getActiveSheet()->getPageMargins()->setHeader(0.314961);
    $spreadsheet->getActiveSheet()->getPageMargins()->setFooter(0.314961);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('A')
      ->setWidth(40);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('B')
      ->setWidth(37);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('C')
      ->setWidth(44);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('D')
      ->setWidth(23);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('E')
      ->setWidth(65);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('F')
      ->setWidth(15);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('G')
      ->setWidth(47);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('H')
      ->setWidth(22);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('I')
      ->setWidth(9);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('J')
      ->setWidth(9);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('K')
      ->setWidth(9);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('L')
      ->setWidth(9);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('M')
      ->setWidth(20);

    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Print Faktur {' . $kdCustomer . '}.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    die;
  }
}
