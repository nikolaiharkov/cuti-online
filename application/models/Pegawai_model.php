<?php

class Pegawai_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
    }

    public function tambahPegawai($data)
{
    $this->db->insert('pegawai', $data);
}

public function getPegawai()
{
    $this->db->select('pegawai.*, divisi.nama_divisi');
    $this->db->from('pegawai');
    $this->db->join('divisi', 'pegawai.divisi = divisi.iddivisi');
    $query = $this->db->get();
    return $query->result();
}

public function getPegawaiById($idpegawai) {
    // Query untuk mengambil data pegawai berdasarkan idpegawai
    $query = $this->db->get_where('pegawai', array('idpegawai' => $idpegawai));

    // Mengembalikan hasil query dalam bentuk array satu baris
    return $query->row_array();
}

public function updatePegawai($idpegawai, $data)
{
    $this->db->where('idpegawai', $idpegawai);
    $this->db->update('pegawai', $data);

    return $this->db->affected_rows() > 0;
}

public function getJumlahCutiById($idpegawai) {
    // Mengambil jumlah cuti dari tabel pegawai berdasarkan idpegawai
    $this->db->select('jumlah_cuti');
    $this->db->where('idpegawai', $idpegawai);
    $query = $this->db->get('pegawai');
    $result = $query->row();

    if ($result) {
      return $result->jumlah_cuti;
    } else {
      return 0;
    }
  }

  public function updateSisaCuti($idpegawai, $jumlahCuti) {
    // Mengupdate nilai sisa cuti pada tabel pegawai
    $data = array(
      'sisa_cuti' => $jumlahCuti
    );
    $this->db->where('idpegawai', $idpegawai);
    $this->db->update('pegawai', $data);
  }
  
  public function hapusPegawai($idpegawai) {
    $this->db->where('idpegawai', $idpegawai);
    $this->db->delete('pegawai');
}

public function getDivisiById($idDivisi) {
  $this->db->where('divisi', $idDivisi);
  $query = $this->db->get('divisi');
  
  if ($query->num_rows() > 0) {
      return $query->row()->nama_divisi;
  } else {
      return 'Divisi Tidak Ditemukan';
  }
}

public function getPegawaiById2($idpegawai)
{
    $query = $this->db->get_where('pegawai', ['idpegawai' => $idpegawai]);
    return $query->row();
}


public function getNamaById($idpegawai) {
  $this->db->where('idpegawai', $idpegawai);
  $query = $this->db->get('pegawai');
  $result = $query->row();
  return $result->nama_pegawai;
}



}
