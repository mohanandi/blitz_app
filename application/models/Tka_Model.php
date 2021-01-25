<?php

class Tka_Model extends CI_model
{
    public function getAllTka()
    {
        $this->db->select('*');
        $this->db->from('tka');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getAllIdTka()
    {
        $this->db->select('*');
        $this->db->from('tka');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getTkaIdPt()
    {
        $this->db->select('id');
        $this->db->from('tka');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getTkaIdByPt($id)
    {
        $this->db->select('id');
        $this->db->from('tka');
        $this->db->where('id_pt', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getIdVisa211($id)
    {
        $this->db->select('*');
        $this->db->from('penghubung_visa211');
        $this->db->where('id_tka', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getIdVisa312($id)
    {
        $this->db->select('*');
        $this->db->from('penghubung_visa312');
        $this->db->where('id_tka', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getTkaById($id)
    {
        return $this->db->get_where('tka', ['id' => $id])->row_array();
    }

    public function tambahTka()
    {
        $data = [
            "id_pt" => $this->input->post('nama_pt', true),
            "nama_mandarin" => $this->input->post('nama_mandarin', true),
            "nama_latin" => $this->input->post('nama_latin', true),
            "kewarganegaraan" => $this->input->post('kewarganegaraan', true),
            "passport" => $this->input->post('passport', true),
            "expired_passport" => strtotime($this->input->post('exp_passport', true)),
            "tgl_lahir" => strtotime($this->input->post('tgl_lahir', true)),
            "ket" => $this->input->post('ket', true),
            "input_by_id" => $this->session->userdata('id'),
            "tgl_input" => time()
        ];
        $this->db->insert('tka', $data);
    }

    public function hapusDataMahasiswa($id)
    {
        // $this->db->where('id', $id);
        $this->db->delete('mahasiswa', ['id' => $id]);
    }

    public function getMahasiswaById($id)
    {
        return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
    }
    public function getVoucher($id)
    {
        return $this->db->get_where('pengguna_voucher_visa', ['id_tka' => $id])->result_array();
    }

    public function EditTka()
    {
        $data = [
            "id_pt" => $this->input->post('nama_pt', true),
            "nama_mandarin" => $this->input->post('nama_mandarin', true),
            "nama_latin" => $this->input->post('nama_latin', true),
            "kewarganegaraan" => $this->input->post('kewarganegaraan', true),
            "passport" => $this->input->post('passport', true),
            "expired_passport" => strtotime($this->input->post('exp_passport', true)),
            "tgl_lahir" => strtotime($this->input->post('tgl_lahir', true)),
            "ket" => $this->input->post('ket', true)
        ];

        $this->db->where('id', $this->input->post('id_tka'));
        $this->db->update('tka', $data);
    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}
