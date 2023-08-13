<?php

class Divisi_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
    }

    public function tambahDivisi($data)
    {
        // Insert data ke tabel divisi
        $this->db->insert('divisi', $data);
    }

    public function getDivisi()
    {
        return $this->db->get('divisi')->result_array();
    }

    public function hapusDivisi($idDivisi)
{
    $this->db->where('iddivisi', $idDivisi);
    return $this->db->delete('divisi');
}

public function getDivisiById($iddivisi) {
    $this->db->where('iddivisi', $iddivisi);
    $query = $this->db->get('divisi');
    return $query->row();
}

}
