<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // Load the session library
		$this->load->library('form_validation');
		$this->load->model('Divisi_model');
        $this->load->model('Pegawai_model');
		$this->load->model('Auth_model');

    }

    public function index()
	{
        $this->load->view('login');
	}

    public function login()
{
    // Mengambil data email dan password dari form
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    // Mengambil data pegawai berdasarkan email
    $pegawai = $this->Auth_model->getPegawaiByEmail($email);

    // Jika data pegawai ditemukan
    if ($pegawai) {
        // Mengambil password yang disimpan di database
        $storedPassword = $pegawai->password;

        // Mengenkripsi password yang diinputkan oleh pengguna
        $hashedPassword = hash('sha256', $password);

        // Memeriksa kecocokan password
        if ($hashedPassword === $storedPassword) {
            // Membuat session dengan idpegawai
            $this->session->set_userdata('idpegawai', $pegawai->idpegawai);
            $this->session->set_userdata('divisi', $pegawai->divisi);

            // Redirect ke halaman home/index
            redirect('home/index');
        }
    }

    // Jika proses autentikasi gagal, tampilkan notifikasi menggunakan library SweetAlert2
    $this->session->set_flashdata('error', 'Email atau password salah.');

    // Redirect ke halaman auth/index
    redirect('auth/index');
}

public function logout()
{
    // Hapus session
    $this->Auth_model->logout();
    
    // Redirect ke halaman login
    redirect('auth/login');
}

}