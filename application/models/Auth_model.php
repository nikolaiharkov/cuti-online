<?php

class Auth_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
    }

    public function getPegawaiByEmail($email)
    {
        $this->db->where('email_pegawai', $email);
        $query = $this->db->get('pegawai');
        return $query->row();
    }

    public function getPegawaiById($idpegawai) {
        $this->db->where('idpegawai', $idpegawai);
        return $this->db->get('pegawai')->row_array();
    }
    
    public function logout() {
        $this->session->sess_destroy();
    }

}
