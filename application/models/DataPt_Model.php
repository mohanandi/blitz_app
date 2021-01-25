<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPt_Model extends CI_Model
{

    public function getAllDataPt()
    {
        $this->db->order_by('nama_pt', 'ASC');
        return $this->db->get('pt')->result_array();
    }
    public function tambahDataPt()
    {
        $data = [
            "nama_pt" => $this->input->post('nama_pt', true),
            "id_pic" => $this->input->post('pic', true),
            "nama_client" => $this->input->post('client', true),
            "alamat" => $this->input->post('alamat', true),
            "ket" => $this->input->post('ket', true),
            "input_by_id" => $this->session->userdata('id'),
            "tgl_input" => time()
        ];
        $this->db->insert('pt', $data);
    }
    public function getPtById($id)
    {
        return $this->db->get_where('pt', ['id' => $id])->row_array();
    }
    public function getDataTka($id)
    {
        return $this->db->get_where('tka', ['id_pt' => $id])->result_array();
    }

    public function hapusDataPt($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pt');
    }

    public function EditPt()
    {
        $data = [
            "nama_pt" => $this->input->post('nama_pt', true),
            "id_pic" => $this->input->post('pic', true),
            "nama_client" => $this->input->post('client', true),
            "alamat" => $this->input->post('alamat', true),
            "ket" => $this->input->post('ket', true)
        ];
        $this->db->where('id', $this->input->post('id_pt'));
        $this->db->update('pt', $data);
    }
    public function getDataJenisVisa()
    {
        $this->db->order_by('visa', 'ASC');
        $this->db->select('*');
        $this->db->from('jenis_visa');
        $this->db->where('id !=', 1);
        $this->db->where('id !=', 2);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function jumlahVoucher($id_pt)
    {
        $this->db->select('id_voucher');
        $this->db->where('id_pt', $id_pt);
        $this->db->from('voucher_visa');
        $query = $this->db->get();
        $voucher_visa = $query->num_rows();
        $this->db->select('id_voucher');
        $this->db->where('id_pt', $id_pt);
        $this->db->from('voucher_entertaint');
        $query = $this->db->get();
        $voucher_entertaint = $query->num_rows();
        $total_voucher = $voucher_visa + $voucher_entertaint;
        return $total_voucher;
    }
}
