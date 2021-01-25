<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rptka_Model extends CI_Model
{
    public function getPenggunaRptka($id)
    {
        return $this->db->get_where('penghubung_visa312', ['id_rptka' => $id])->result_array();
    }
    public function getAllRptka()
    {
        return $this->db->get_where('rptka')->result_array();
    }
    public function getRptkaById($id)
    {
        return $this->db->get_where('rptka', ['id' => $id])->row_array();
    }
    public function getJabatanByRptka($id)
    {
        return $this->db->get_where('jabatan_rptka', ['id_rptka' => $id])->result_array();
    }
    public function getJabatanByRptkaById($id)
    {
        return $this->db->get_where('jabatan_rptka', ['id_jabatan_rptka' => $id])->row_array();
    }
    public function getJabatanById($id)
    {
        return $this->db->get_where('jabatan_rptka', ['id_jabatan_rptka' => $id])->row_array();
    }
    public function TambahRptka()
    {
        $data = [
            "id_pt" => $this->input->post('nama_pt', true),
            "no_rptka" => $this->input->post('no_rptka', true),
            "tgl_terbit" => strtotime($this->input->post('tgl_terbit', true)),
            "tgl_expired" => strtotime($this->input->post('tgl_expired', true)),
            "jumlah_rptka" => $this->input->post('jumlah_pengguna', true),
            "jumlah_terpakai" => 0,
            "ket" => $this->input->post('ket', true),
            "input_by_id" => $this->session->userdata('id'),
            "tgl_input" => time()
        ];
        $this->db->insert('rptka', $data);
    }
    public function EditRptka()
    {
        $data = [
            "id_pt" => $this->input->post('nama_pt', true),
            "no_rptka" => $this->input->post('no_rptka', true),
            "tgl_terbit" => strtotime($this->input->post('tgl_terbit', true)),
            "tgl_expired" => strtotime($this->input->post('tgl_expired', true)),
            "jumlah_rptka" => $this->input->post('jumlah_pengguna', true),
            "ket" => $this->input->post('ket', true)
        ];
        $this->db->where('id', $this->input->post('id_rptka'));
        $this->db->update('rptka', $data);
    }
    public function TambahJabatan($id)
    {
        $data = [
            "id_rptka" => $id,
            "jabatan" => $this->input->post("jabatan", true),
            "jumlah" => $this->input->post("jumlah", true),
            "terpakai" => 0
        ];
        $this->db->insert('jabatan_rptka', $data);
    }
    public function EditJabatan($id)
    {
        $data = [
            "jabatan" => $this->input->post("jabatan", true),
            "jumlah" => $this->input->post("jumlah", true)
        ];
        $this->db->where('id_jabatan_rptka', $id);
        $this->db->update('jabatan_rptka', $data);
    }
    public function TambahTerpakaiJabatan($terpakai)
    {
        $data = [
            "terpakai" => $terpakai
        ];
        $this->db->where('id_jabatan_rptka', $this->input->post('jabatan_rptka'));
        $this->db->update('jabatan_rptka', $data);
    }
    public function editJabatanRptkaVisa($id_jabatan, $jumlah)
    {
        $data = [
            "terpakai" => $jumlah
        ];
        $this->db->where('id_jabatan_rptka', $id_jabatan);
        $this->db->update('jabatan_rptka', $data);
    }
    public function EditUser()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "email" => $this->input->post('email', true),
            "role_id" => $this->input->post('role_id', true),
            "pic_pt" => $this->input->post('pic_pt', true),
            "is_active" => $this->input->post('is_active', true),
        ];
        $this->db->where('id', $this->input->post('id_user'));
        $this->db->update('user', $data);
    }

    // Untuk mendapatkan pilihan RPTKA
    public function getRptkaByPt($id_pt)
    {
        $this->db->where('id_pt', $id_pt);
        return $this->db->get('rptka')->result();
    }
    public function getJabatanTerpakai($id_rptka)
    {
        $this->db->select(array('id_jabatan_rptka', 'jumlah'));
        $this->db->from('jabatan_rptka');
        $this->db->where('id_rptka', $id_rptka);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Untuk mendapatkan pilihan Jabatan
    public function getJabtanPilihan()
    {
        $this->db->join('rptka', 'jabatan_rptka.id_rptka = rptka.id');
        return $this->db->get('jabatan_rptka')->result();
    }

    public function TambahTerpakaiRptka($terpakai)
    {
        $data = [
            "jumlah_terpakai" => $terpakai
        ];
        $this->db->where('id', $this->input->post('no_rptka'));
        $this->db->update('rptka', $data);
    }
    public function editTerpakaiRptka($id_rptka, $terpakai)
    {
        $data = [
            "jumlah_terpakai" => $terpakai
        ];
        $this->db->where('id', $id_rptka);
        $this->db->update('rptka', $data);
    }
    public function EditJabatanRptka($jumlah_jabatan, $id_rptka)
    {
        $data = [
            "jumlah_rptka" => $jumlah_jabatan
        ];
        $this->db->where('id', $id_rptka);
        $this->db->update('rptka', $data);
    }
}
