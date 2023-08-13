<?php

class Cuti_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
    }

 
    
    public function getCutiByIdPegawai($idPegawai)
    {
        $this->db->select('*');
        $this->db->from('pengajuan');
        $this->db->where('idpegawai', $idPegawai);
        $this->db->order_by('idpengajuan', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getSisaCuti($idPegawai) {
        // Ambil data sisa cuti dari tabel pegawai berdasarkan ID Pegawai
        $this->db->select('sisa_cuti');
        $this->db->where('idpegawai', $idPegawai);
        $query = $this->db->get('pegawai');
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->sisa_cuti;
        } else {
            return 0; // Jika tidak ada data, return 0 atau nilai default yang sesuai
        }
    }
    
    public function updateSisaCuti($idPegawai, $sisaCuti) {
        // Update nilai sisa cuti pada tabel pegawai
        $data = array(
            'sisa_cuti' => $sisaCuti
        );
        
        $this->db->where('idpegawai', $idPegawai);
        $this->db->update('pegawai', $data);
    }
    
    public function insertPengajuanCuti($data) {
        // Insert data pengajuan cuti ke dalam tabel pengajuan
        $this->db->insert('pengajuan', $data);
    }

    public function getPengajuanById($idpengajuan)
    {
        return $this->db->get_where('pengajuan', ['idpengajuan' => $idpengajuan])->row();
    }
    
    public function getPegawaiById($idpegawai)
    {
        return $this->db->get_where('pegawai', ['idpegawai' => $idpegawai])->row();
    }
    
    public function updateSisaCuti2($idpegawai, $newSisaCuti)
    {
        $this->db->where('idpegawai', $idpegawai);
        $this->db->update('pegawai', ['sisa_cuti' => $newSisaCuti]);
        return $this->db->affected_rows() > 0;
    }
    
    public function updateStatusPengajuan($idpengajuan, $status)
    {
        $this->db->where('idpengajuan', $idpengajuan);
        $this->db->update('pengajuan', ['status' => $status]);
        return $this->db->affected_rows() > 0;
    }
    
    public function getCutiByIdPegawai2($idPegawai) {
        $this->db->select('pengajuan.*, pegawai.nama_pegawai');
        $this->db->from('pengajuan');
        $this->db->join('pegawai', 'pengajuan.idpegawai = pegawai.idpegawai');
        $this->db->where('pengajuan.idpegawai', $idPegawai);
        $this->db->order_by('pengajuan.idpengajuan', 'desc'); // Sort by idpengajuan in descending order
        $query = $this->db->get();
        $result = $query->result();
    
        if (!empty($result)) {
            $idDivisi = $result[0]->iddivisi;
    
            // Retrieve the nama_pegawai from the pegawai table based on idpegawai in the pengajuan table
            $this->db->select('nama_pegawai');
            $this->db->from('pegawai');
            $this->db->where('idpegawai', $result[0]->idpegawai);
            $query = $this->db->get();
            $namaPegawai = $query->row()->nama_pegawai;
    
            $this->db->select('pengajuan.*, divisi.nama_divisi');
            $this->db->from('pengajuan');
            $this->db->join('divisi', 'pengajuan.iddivisi = divisi.iddivisi');
            $this->db->where('pengajuan.iddivisi', $idDivisi);
            //filter jabatan 3 dari table pegawai
            $this->db->order_by('pengajuan.idpengajuan', 'desc'); // Sort by idpengajuan in descending order
            $query = $this->db->get();
            $result = $query->result();
    
            // Add the 'nama_pegawai' to each record
            foreach ($result as $item) {
                $item->nama_pegawai = $namaPegawai;
            }
    
            return $result;
        } else {
            return array();
        }
    }

    public function getCutiByIdPegawai3() {
        $this->db->select('pengajuan.*, pegawai.nama_pegawai');
        $this->db->from('pengajuan');
        $this->db->join('pegawai', 'pengajuan.idpegawai = pegawai.idpegawai');
        $this->db->order_by('pengajuan.idpengajuan', 'desc'); // Sort by idpengajuan in descending order
        $query = $this->db->get();
        $result = $query->result();
    
        if (!empty($result)) {
            $namaPegawai = $result[0]->nama_pegawai;
    
            // Add the 'nama_pegawai' to each record
            foreach ($result as $item) {
                $item->nama_pegawai = $namaPegawai;
            }
    
            return $result;
        } else {
            return array();
        }
    }



    
    

}
