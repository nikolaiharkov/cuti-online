<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		// Load model yang diperlukan
        $this->load->library('session'); // Load the session library
		$this->load->library('form_validation');
		$this->load->model('Auth_model');
        $this->load->model('Cuti_model');
        $this->load->model('Pegawai_model');
        

	}

    public function pengajuanmanagerindex()
    {
        $sessionIdPegawai = $this->session->userdata('idpegawai');
        if (!$sessionIdPegawai) {
            redirect('auth/index');
        }
    
        $data['pegawai'] = $this->Auth_model->getPegawaiById($sessionIdPegawai);
        $data['cuti'] = $this->Cuti_model->getCutiByIdPegawai($sessionIdPegawai); // Mengambil data cuti berdasarkan idpegawai
    
        $this->load->view('template/header', $data);
        $this->load->view('manager/pengajuanmanager', $data); // Mengirim data cuti ke view
        $this->load->view('template/footer');
    }
    
    public function buatcutimanager() {
        // Load model        
        // Validasi form
        $this->form_validation->set_rules('tanggalAwal', 'Tanggal Awal Cuti', 'required');
        $this->form_validation->set_rules('tanggalSelesai', 'Tanggal Selesai Cuti', 'required');
        $this->form_validation->set_rules('jumlahcuti', 'Jumlah Cuti', 'required|numeric');
        $this->form_validation->set_rules('alasan', 'Alasan Cuti', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan pesan error
            $this->session->set_flashdata('error', validation_errors());
            redirect('cuti/pengajuanmanagerindex');
        } else {
            // Jika validasi sukses, proses pengajuan cuti
            
            // Ambil ID Pegawai dari session (ganti dengan implementasi sesuai dengan sistem Anda)
            $idPegawai = $this->session->userdata('idpegawai');
            $iddivisi = $this->session->userdata('divisi');

            
            // Ambil data sisa cuti pegawai
            $sisaCuti = $this->Cuti_model->getSisaCuti($idPegawai);
            
            // Ambil inputan dari form
            $tanggalAwal = $this->input->post('tanggalAwal');
            $tanggalSelesai = $this->input->post('tanggalSelesai');
            $jumlahCuti = $this->input->post('jumlahcuti');
            $alasan = $this->input->post('alasan');
            
            // Cek apakah sisa cuti mencukupi
            if ($sisaCuti < $jumlahCuti) {
                // Jika sisa cuti tidak mencukupi, tampilkan pesan error
                $this->session->set_flashdata('error', 'Sisa cuti tidak mencukupi');
                redirect('cuti/pengajuanmanagerindex');
            } else {
                // Jika sisa cuti mencukupi, proses pengurangan sisa cuti dan insert data pengajuan cuti
                
                // Kurangi sisa cuti dengan jumlah cuti yang diajukan
                $sisaCuti -= $jumlahCuti;
                
                // Update sisa cuti pada database
                $this->Cuti_model->updateSisaCuti($idPegawai, $sisaCuti);
                
                // Insert data pengajuan cuti
                $data = array(
                    'idpegawai' => $idPegawai,
                    'iddivisi' => $iddivisi,
                    'tanggal_awal' => $tanggalAwal,
                    'tanggal_akhir' => $tanggalSelesai,
                    'jumlah_cuti' => $jumlahCuti,
                    'alasan_cuti' => $alasan,
                    'status' => 4,
                    'keterangan_manager' => '-',
                    'keterangan_hrd' => '-'
                );
                
                $this->Cuti_model->insertPengajuanCuti($data);
                
                // Tampilkan pesan sukses
                $this->session->set_flashdata('success', 'Pengajuan cuti berhasil');
                redirect('cuti/pengajuanmanagerindex');
            }
        }
    }

    public function hapuspengajuan($idpengajuan)
    {
        // Ambil data pengajuan cuti berdasarkan idpengajuan
        $pengajuan = $this->Cuti_model->getPengajuanById($idpengajuan);
    
        if ($pengajuan) {
            $idpegawai = $pengajuan->idpegawai;
            $jumlahCuti = $pengajuan->jumlah_cuti;
    
            // Ambil sisa cuti saat ini dari tabel pegawai
            $pegawai = $this->Cuti_model->getPegawaiById($idpegawai);
            $currentSisaCuti = $pegawai->sisa_cuti;
    
            // Hitung sisa cuti baru
            $newSisaCuti = $currentSisaCuti + $jumlahCuti;
    
            // Update sisa cuti pada tabel pegawai
            $this->Cuti_model->updateSisaCuti2($idpegawai, $newSisaCuti);
    
            // Ubah status menjadi 0 pada tabel pengajuan
            $updated = $this->Cuti_model->updateStatusPengajuan($idpengajuan, 0);
    
            if ($updated) {
                $this->session->set_flashdata('success', 'Pengajuan cuti berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan. Gagal menghapus pengajuan cuti.');
            }
        } else {
            $this->session->set_flashdata('error', 'Pengajuan cuti tidak ditemukan.');
        }
    
        // Redirect ke halaman pengajuan cuti
        redirect('cuti/pengajuanmanagerindex');
    }
    
    public function pengajuanstaffindex()
    {
        $sessionIdPegawai = $this->session->userdata('idpegawai');
        if (!$sessionIdPegawai) {
            redirect('auth/index');
        }
    
        $data['pegawai'] = $this->Auth_model->getPegawaiById($sessionIdPegawai);
        $data['cuti'] = $this->Cuti_model->getCutiByIdPegawai($sessionIdPegawai); // Mengambil data cuti berdasarkan idpegawai
    
        $this->load->view('template/header', $data);
        $this->load->view('staff/pengajuanstaff', $data); // Mengirim data cuti ke view
        $this->load->view('template/footer');
    }

    public function buatcutistaff() {
        // Load model        
        // Validasi form
        $this->form_validation->set_rules('tanggalAwal', 'Tanggal Awal Cuti', 'required');
        $this->form_validation->set_rules('tanggalSelesai', 'Tanggal Selesai Cuti', 'required');
        $this->form_validation->set_rules('jumlahcuti', 'Jumlah Cuti', 'required|numeric');
        $this->form_validation->set_rules('alasan', 'Alasan Cuti', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan pesan error
            $this->session->set_flashdata('error', validation_errors());
            redirect('cuti/pengajuanmanagerindex');
        } else {
            // Jika validasi sukses, proses pengajuan cuti
            
            // Ambil ID Pegawai dari session (ganti dengan implementasi sesuai dengan sistem Anda)
            $idPegawai = $this->session->userdata('idpegawai');
            $iddivisi = $this->session->userdata('divisi');
            // Ambil data sisa cuti pegawai
            $sisaCuti = $this->Cuti_model->getSisaCuti($idPegawai);
            
            // Ambil inputan dari form
            $tanggalAwal = $this->input->post('tanggalAwal');
            $tanggalSelesai = $this->input->post('tanggalSelesai');
            $jumlahCuti = $this->input->post('jumlahcuti');
            $alasan = $this->input->post('alasan');
            
            // Cek apakah sisa cuti mencukupi
            if ($sisaCuti < $jumlahCuti) {
                // Jika sisa cuti tidak mencukupi, tampilkan pesan error
                $this->session->set_flashdata('error', 'Sisa cuti tidak mencukupi');
                redirect('cuti/pengajuanmanagerindex');
            } else {
                // Jika sisa cuti mencukupi, proses pengurangan sisa cuti dan insert data pengajuan cuti
                
                // Kurangi sisa cuti dengan jumlah cuti yang diajukan
                $sisaCuti -= $jumlahCuti;
                
                // Update sisa cuti pada database
                $this->Cuti_model->updateSisaCuti($idPegawai, $sisaCuti);
                
                // Insert data pengajuan cuti
                $data = array(
                    'idpegawai' => $idPegawai,
                    'iddivisi' => $iddivisi,
                    'tanggal_awal' => $tanggalAwal,
                    'tanggal_akhir' => $tanggalSelesai,
                    'jumlah_cuti' => $jumlahCuti,
                    'alasan_cuti' => $alasan,
                    'status' => 1,
                    'keterangan_manager' => '-',
                    'keterangan_hrd' => '-'
                );
                
                $this->Cuti_model->insertPengajuanCuti($data);
                
                // Tampilkan pesan sukses
                $this->session->set_flashdata('success', 'Pengajuan cuti berhasil');
                redirect('cuti/pengajuanstaffindex');
            }
        }
    }

    public function permintaanindex()
    {
        $sessionIdPegawai = $this->session->userdata('idpegawai');
        if (!$sessionIdPegawai) {
            redirect('auth/index');
        }
        // ambil session divisi
        $data['pegawai'] = $this->Auth_model->getPegawaiById($sessionIdPegawai);
        $data['cuti'] = $this->Cuti_model->getCutiByIdPegawai2($sessionIdPegawai); // Mengambil data cuti berdasarkan idpegawai

            $this->load->view('template/header', $data);
            $this->load->view('manager/permintaan', $data);
            $this->load->view('template/footer');

    }
    
    public function tolakmanager()
    {
        // Mendapatkan data yang dikirim dari form
        $idpengajuan = $this->input->post('idpengajuan');
        $keterangan = $this->input->post('keterangan');
    
        // Lakukan update status dan keterangan di tabel pengajuan
        $data = array(
            'status' => 3,
            'keterangan_manager' => $keterangan
        );
        $this->db->where('idpengajuan', $idpengajuan);
        $this->db->update('pengajuan', $data);
    
        // Redirect kembali ke halaman cuti/permintaanindex
        redirect('cuti/permintaanindex');
    }    
    
    public function accmanager($idpengajuan)
    {
        // Lakukan update status menjadi 4 di tabel pengajuan
        $data = array(
            'status' => 4
        );
        $this->db->where('idpengajuan', $idpengajuan);
        $this->db->update('pengajuan', $data);
    
        // Berikan respon berhasil menggunakan SweetAlert2
        $this->session->set_flashdata('success', 'Pengajuan cuti berhasil disetujui.');
        redirect('cuti/permintaanindex');
    }

    public function permintaanadminindex()
    {
        $sessionIdPegawai = $this->session->userdata('idpegawai');
        if (!$sessionIdPegawai) {
            redirect('auth/index');
        }
        // ambil session divisi
        $data['pegawai'] = $this->Auth_model->getPegawaiById($sessionIdPegawai);
        $data['cuti'] = $this->Cuti_model->getCutiByIdPegawai3(); // Mengambil data cuti berdasarkan idpegawai

            $this->load->view('template/header', $data);
            $this->load->view('admin/permintaan', $data);
            $this->load->view('template/footer');

    }

    public function tolakadmin()
{
    // Mendapatkan data yang dikirim dari form
    $idpengajuan = $this->input->post('idpengajuan');
    $keterangan = $this->input->post('keterangan');

    // Lakukan update status dan keterangan di tabel pengajuan
    $data = array(
        'status' => 6,
        'keterangan_hrd' => $keterangan
    );
    $this->db->where('idpengajuan', $idpengajuan);
    $this->db->update('pengajuan', $data);

    // Update sisa_cuti pada tabel pegawai
    $pengajuan = $this->db->get_where('pengajuan', array('idpengajuan' => $idpengajuan))->row();
    $idpegawai = $pengajuan->idpegawai;
    $jumlahCuti = $pengajuan->jumlah_cuti;

    $pegawai = $this->db->get_where('pegawai', array('idpegawai' => $idpegawai))->row();
    $sisaCuti = $pegawai->sisa_cuti + $jumlahCuti;

    $this->db->where('idpegawai', $idpegawai);
    $this->db->update('pegawai', array('sisa_cuti' => $sisaCuti));

    // Redirect kembali ke halaman cuti/permintaanadminindex
    redirect('cuti/permintaanadminindex');
}
    
    
    public function accadmin($idpengajuan)
    {
        // Lakukan update status menjadi 4 di tabel pengajuan
        $data = array(
            'status' => 5
        );
        $this->db->where('idpengajuan', $idpengajuan);
        $this->db->update('pengajuan', $data);
    
        // Berikan respon berhasil menggunakan SweetAlert2
        $this->session->set_flashdata('success', 'Pengajuan cuti berhasil disetujui.');
        redirect('cuti/permintaanadminindex');
    }
    
    public function getKeteranganPengajuanCuti()
{
    // Mendapatkan data idpengajuan dari POST request
    $idpengajuan = $this->input->post('idpengajuan');

    // Mengambil keterangan manager dan keterangan HRD dari database berdasarkan idpengajuan
    $this->db->select('keterangan_manager, keterangan_hrd');
    $this->db->from('pengajuan');
    $this->db->where('idpengajuan', $idpengajuan);
    $query = $this->db->get();
    $result = $query->row();

    // Mengembalikan keterangan dalam format JSON
    echo json_encode($result);
}


}
