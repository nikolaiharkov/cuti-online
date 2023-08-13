<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		// Load model yang diperlukan
		$this->load->model('Auth_model');
		$this->load->library('session');
		$this->load->model('Pegawai_model');
		$this->load->model('Divisi_model');


	}

	public function index()
	{
		$sessionIdPegawai = $this->session->userdata('idpegawai');
		if (!$sessionIdPegawai) {
			redirect('auth/index');
		}
		$data['pegawai'] = $this->Pegawai_model->getPegawaiById2($sessionIdPegawai);
		$this->load->view('template/header', $data);
		$this->load->view('home', $data);
		$this->load->view('template/footer');
	}
}
