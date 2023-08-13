<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

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
        $sessionIdPegawai = $this->session->userdata('idpegawai');
        if (!$sessionIdPegawai) {
			redirect('auth/index');
		}
		$data['pegawai'] = $this->Auth_model->getPegawaiById($sessionIdPegawai);

        $data['divisi'] = $this->Divisi_model->getDivisi();
        $data['pegawai'] = $this->Pegawai_model->getPegawai();
        $this->load->view('template/header', $data);
        $this->load->view('admin/pegawai', $data);
        $this->load->view('template/footer');
    }
    

    public function tambahpegawai()
{
    // Set rules for form validation
    $this->form_validation->set_rules('divisi', 'Divisi', 'required');
    $this->form_validation->set_rules('namaPegawai', 'Nama Pegawai', 'required');
    $this->form_validation->set_rules('emailPegawai', 'Email Pegawai', 'required|valid_email');
    $this->form_validation->set_rules('nomorTelepon', 'Nomor Telepon', 'required|numeric|min_length[11]');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('jumlahCuti', 'Jumlah Cuti', 'required|numeric');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('rePassword', 'Konfirmasi Password', 'required|matches[password]');

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, kembali ke halaman index dengan notifikasi error
        $this->session->set_flashdata('error', 'Gagal menambahkan pegawai. Harap lengkapi semua field.');
        redirect('pegawai/index');
    } else {
        // Jika validasi berhasil, tambahkan data ke tabel pegawai melalui model
        $data = array(
            'divisi' => $this->input->post('divisi'),
            'nama_pegawai' => $this->input->post('namaPegawai'),
            'email_pegawai' => $this->input->post('emailPegawai'),
            'nomor_telepon' => $this->input->post('nomorTelepon'),
            'jabatan' => $this->input->post('jabatan'),
            'jumlah_cuti' => $this->input->post('jumlahCuti'),
            'sisa_cuti' => $this->input->post('jumlahCuti'),
            'password' => hash('sha256', $this->input->post('password'))
        );
        $this->Pegawai_model->tambahPegawai($data);

        // Tampilkan notifikasi success dan kembali ke halaman index
        $this->session->set_flashdata('success', 'Pegawai berhasil ditambahkan.');
        redirect('pegawai/index');
    }
}

public function cekdetail($idpegawai)
{
    // Ambil data pegawai berdasarkan $idpegawai
    $pegawai = $this->Pegawai_model->getPegawaiById($idpegawai);

    // Kirim data pegawai dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($pegawai);
}

public function editpegawai()
{
    // Form validation rules
    $this->form_validation->set_rules('divisi', 'Divisi', 'required');
    $this->form_validation->set_rules('namaPegawai', 'Nama Pegawai', 'required');
    $this->form_validation->set_rules('emailPegawai', 'Email Pegawai', 'required|valid_email');
    $this->form_validation->set_rules('nomorTelepon', 'Nomor Telepon', 'required');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('jumlahCuti', 'Jumlah Cuti', 'required|numeric');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('rePassword', 'Konfirmasi Password', 'required|matches[password]');


    if ($this->form_validation->run() == FALSE) {
        // Jika validasi form gagal, tampilkan kembali halaman edit pegawai dengan pesan error
        $this->session->set_flashdata('error', 'Form validation error.');
        redirect('pegawai/index');
    } else {
        $idpegawai = $this->input->post('idpegawai');

        // Menggunakan model untuk mendapatkan data pegawai berdasarkan idpegawai
        $pegawai = $this->Pegawai_model->getPegawaiById($idpegawai);

        if (!$pegawai) {
            // Jika pegawai tidak ditemukan, tampilkan pesan error
            $this->session->set_flashdata('error', 'Pegawai not found.');
            redirect('pegawai/index');
        }

        // Mengupdate data pegawai dengan data yang baru
        $data = array(
            'divisi' => $this->input->post('divisi'),
            'nama_pegawai' => $this->input->post('namaPegawai'),
            'email_pegawai' => $this->input->post('emailPegawai'),
            'nomor_telepon' => $this->input->post('nomorTelepon'),
            'jabatan' => $this->input->post('jabatan'),
            'jumlah_cuti' => $this->input->post('jumlahCuti'),
            'password' => hash('sha256', $this->input->post('password'))

        );

        $result = $this->Pegawai_model->updatePegawai($idpegawai, $data);

        if ($result) {
            // Jika pembaruan sukses, tampilkan pesan sukses dengan SweetAlert2
            $this->session->set_flashdata('success', 'Pegawai updated successfully.');
            redirect('pegawai/index');
        } else {
            // Jika pembaruan gagal, tampilkan pesan error dengan SweetAlert2
            $this->session->set_flashdata('error', 'Failed to update pegawai.');
            redirect('pegawai/index');
        }
    }
}

public function resetcuti($idpegawai) {
    // Mengambil jumlah cuti dari tabel pegawai berdasarkan idpegawai
    $jumlahCuti = $this->Pegawai_model->getJumlahCutiById($idpegawai);
  
// Mengupdate sisa cuti pada tabel pegawai
$sisaCuti = $jumlahCuti;
    
    $this->Pegawai_model->updateSisaCuti($idpegawai, $sisaCuti);
  
    // Tampilkan notifikasi menggunakan library SweetAlert2
    $this->session->set_flashdata('success', 'Cuti berhasil direset.');
  
    // Redirect ke halaman pegawai/index
    redirect('pegawai/index');
  }
  
  public function hapusdata($idpegawai) {
    // Hapus data pegawai berdasarkan idpegawai
    $this->Pegawai_model->hapusPegawai($idpegawai);

    // Tampilkan notifikasi menggunakan library SweetAlert2
    $this->session->set_flashdata('success', 'Data pegawai berhasil dihapus.');

    // Redirect ke halaman pegawai/index
    redirect('pegawai/index');
}

public function staffindex()
    {
        $sessionIdPegawai = $this->session->userdata('idpegawai');
        if (!$sessionIdPegawai) {
			redirect('auth/index');
		}
		$data['pegawai'] = $this->Auth_model->getPegawaiById($sessionIdPegawai);

        $data['divisi'] = $this->Divisi_model->getDivisi();
        $data['pegawai'] = $this->Pegawai_model->getPegawai();
        $this->load->view('template/header', $data);
        $this->load->view('manager/staff', $data);
        $this->load->view('template/footer');
    }

    public function indexstaff()
    {
        $sessionIdPegawai = $this->session->userdata('idpegawai');
        if (!$sessionIdPegawai) {
			redirect('auth/index');
		}
		$data['pegawai'] = $this->Auth_model->getPegawaiById($sessionIdPegawai);

        $data['divisi'] = $this->Divisi_model->getDivisi();
        $data['pegawai'] = $this->Pegawai_model->getPegawai();
        $this->load->view('template/header', $data);
        $this->load->view('manager/staff', $data);
        $this->load->view('template/footer');
    }
  


}
