<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_Voucher_Model extends CI_Model
{

    public function getAllProsesVoucher()
    {
        return $this->db->get('jenis_proses')->result_array();
    }
    public function getProsesById($id)
    {
        return $this->db->get_where('jenis_proses', ['id_proses' => $id])->row_array();
    }
    public function getAllHargaVoucher()
    {
        return $this->db->get('harga')->result_array();
    }
    public function getUserById($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }
    public function getDataHarga($id)
    {
        return $this->db->get_where('harga', ['id_harga' => $id])->row_array();
    }

    public function TambahJenisProses()
    {

        $data = [
            "nama_proses" => $this->input->post('nama_proses', true),
            "input_by_id" => $this->session->userdata('id'),
            "tgl_input" => time()
        ];
        $this->db->insert('jenis_proses', $data);
    }
    public function TambahHarga()
    {

        $data = [
            "id_proses" => $this->input->post('jenis_proses', true),
            "lokasi" => $this->input->post('lokasi', true),
            "rupiah" => $this->input->post('rupiah', true),
            "dollar" => $this->input->post('dollar', true),
            "input_by_id" => $this->session->userdata('id'),
            "tgl_input" => time()
        ];
        $this->db->insert('harga', $data);
    }
    public function EditHarga($id)
    {

        $data = [
            "id_proses" => $this->input->post('jenis_proses', true),
            "lokasi" => $this->input->post('lokasi', true),
            "rupiah" => $this->input->post('rupiah', true),
            "dollar" => $this->input->post('dollar', true)
        ];
        $this->db->where('id_harga', $id);
        $this->db->update('harga', $data);
    }
    public function EditProses($id)
    {

        $data = [
            "nama_proses" => $this->input->post('nama_proses', true)
        ];
        $this->db->where('id_proses', $id);
        $this->db->update('jenis_proses', $data);
    }

    public function DeleteHarga($id)
    {
        $this->db->delete('harga', array('id_harga' => $id));
    }
    public function DeleteProses($id)
    {
        $this->db->delete('jenis_proses', array('id_proses' => $id));
    }
}
