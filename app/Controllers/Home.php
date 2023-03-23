<?php

namespace App\Controllers;

class Home extends BaseController
{
	protected $modelBeranda;
	protected $db;
	protected $session;

	public function __construct()
	{
		$this->_akses();
		helper('rupiah_helper');
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
		$data = [
			'judul' 	=> 'MAKNA DIST.',
			'session'  => $this->session
		];
		return view('home/beranda', $data);
	}

	public function beranda()
	{
		$dataInvoice = $this->db->query('SELECT * FROM tb_invoice');
		$dataAlat = $this->db->query('SELECT * FROM tb_alat');
		$dataCustomer = $this->db->query('SELECT * FROM tb_customer');

		$result = [];

		$resultsInvoice = $dataInvoice->getResult();
		$resultsAlat = $dataAlat->getResult();
		$resultsCustomer = $dataCustomer->getResult();

		$last4alat = $this->db->query('SELECT * FROM tb_alat ORDER BY id DESC LIMIT 4');
		$dataAlat = $last4alat->getResultArray();
		$hasilAlat = [];
		foreach ($dataAlat as $alat) {
			array_push($hasilAlat, ['nama' => ucwords($alat['nama_alat']), 'hrg' => "Rp. " . rupiah($alat['harga']), 'exp' => $alat['expired']]);
		}

		$last4customer = $this->db->query('SELECT * FROM tb_customer ORDER BY kode_customer DESC LIMIT 4');
		$dataCustomer = $last4customer->getResultArray();
		$hasilCustomer = [];
		foreach ($dataCustomer as $customer) {
			array_push($hasilCustomer, ['nama' => $customer['nama_customer'], 'telp' => $customer['telp'], 'almt' => $customer['alamat']]);
		}

		array_push($result, ['jumlah_invoice' => count($resultsInvoice), 'jumlah_alat' => count($resultsAlat), 'jumlah_customer' => count($resultsCustomer)]);

		echo json_encode(array("result" => $result, "hasilAlat" => $hasilAlat, "hasilCustomer" => $hasilCustomer));
	}

	public function changePass()
	{
		$data = [
			'judul'				=> 'Change Password | MAKNA DIST.',
			'session'			=> $this->session,
			'validation'	=> \Config\Services::validation()
		];

		return view('home/changePass', $data);
	}

	public function updatePass()
	{
		if (!$this->validate([
			'upload'		=> [
				'rules'		=> 'max_size[upload,1024]|mime_in[upload,image/png,image/jpg,image/jpeg]|is_image[upload]',
				'errors'	=> [
					'max_size'	=> 'Maksimal Gamabar yang di Upload 1MB',
					'mime_in'		=> 'Pastikan anda mengupload Gambar yang berextensi jpg, jpeg atau png',
					'is_image'	=> 'pastikan Anda mengupload gambar'
				]
			],
			'password2' => [
				'rules'		=> 'matches[password]',
				'errors'	=> [
					'matches'		=> 'Passtikan sama dengan yang diketikan sebelumnya!'
				]
			]
		])) {
			return redirect()->to('/home/changePass')->withInput();
		}
		$pass		= $this->request->getVar('password');
		$pass2	= $this->request->getVar('password2');
		$pic		= $this->request->getFile('upload');

		if ($pic->getError() == 4) {
			$namaPic = "profile.jpg";
		} else {
			$namaPic = $pic->getName();
			$extPic = explode('.', $namaPic);
			$extPic = end($extPic);

			$namaPic = 'upload/' . $this->session['nama'] . '.' . $extPic;
		}

		if (!empty($pass)) {
			$password = password_hash($pass, PASSWORD_DEFAULT);

			$this->db->table('login')->set(['password' => $password, 'pic' => $namaPic])->where('id', $this->session['id'])->update();
		} else {
			$this->db->table('login')->set('pic', $namaPic)->where('id', $this->session['id'])->update();
		}

		move_uploaded_file($pic->getPathname(), './img/' . $namaPic);
		// session()->setFlashdata('pesan', 'Data Berhasil Diupdate');
		return redirect()->to('/home/changePass');
	}

	public function logout()
	{
		session()->remove('login');
		session()->remove('id');
		session()->remove('level');
		session()->destroy();

		return redirect()->to('/');
	}
}
