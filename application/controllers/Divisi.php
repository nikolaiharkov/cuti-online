<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // Load the session library
		$this->load->library('form_validation');
		$this->load->model('Divisi_model');
        $this->load->model('Auth_model');

		
    }

	public function index()
	{
        $sessionIdPegawai = $this->session->userdata('idpegawai');
        if (!$sessionIdPegawai) {
			redirect('auth/index');
		}
		$data['pegawai'] = $this->Auth_model->getPegawaiById($sessionIdPegawai);
        $data['divisi'] = $this->Divisi_model->getDivisi();
        $this->load->view('template/header', $data);
        $this->load->view('admin/divisi', $data);
        $this->load->view('template/footer');
	}

    public function tambahdivisi()
{
    // Set rules for form validation
    $this->form_validation->set_rules('namaDivisi', 'Nama Divisi', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, kembali ke halaman index dengan notifikasi error
        $this->session->set_flashdata('error_message', 'Data divisi gagal ditambahkan.');
        redirect('divisi/index');
    } else {
        // Jika validasi berhasil, tambahkan data ke tabel divisi melalui model
        $this->load->model('Divisi_model');
        $data = array(
            'nama_divisi' => $this->input->post('namaDivisi')
        );
        $this->Divisi_model->tambahDivisi($data);

        // Tampilkan notifikasi success dan kembali ke halaman index
        $this->session->set_flashdata('success_message', 'Data divisi berhasil ditambahkan.');
        redirect('divisi/index');
    }
}

public function hapusdivisi($idDivisi)
{
    if ($this->Divisi_model->hapusDivisi($idDivisi)) {
        // Jika penghapusan berhasil, tampilkan notifikasi success
        $this->session->set_flashdata('success', 'Data divisi berhasil dihapus.');
    } else {
        // Jika penghapusan gagal, tampilkan notifikasi error
        $this->session->set_flashdata('error', 'Gagal menghapus data divisi.');
    }

    redirect('divisi/index');
}


}
