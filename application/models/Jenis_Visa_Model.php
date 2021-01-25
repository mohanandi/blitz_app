<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_Visa_Model extends CI_Model
{

    public function getAllKategori()
    {
        return $this->db->get('kategori_visa')->result();
    }
    public function getAllJenisVisa()
    {
        $this->db->join('kategori_visa', 'jenis_visa.kategori_id = kategori_visa.id_kategori');
        return $this->db->get('jenis_visa')->result();
    }
    public function getJenisVisaById($id)
    {
        return $this->db->get_where('jenis_visa', ['id' => $id])->row_array();
    }
    public function getJenisVisa()
    {
        $this->db->order_by('visa', 'ASC');
        return $this->db->get_where('jenis_visa')->result_array();
    }
    public function TambahJenisVisa()
    {

        $data = [
            "visa" => $this->input->post('nama_visa', true),
            "kategori_id" => $this->input->post('status_rptka', true),
            "id_visa_sebelumnya" => $this->input->post('visa_sebelumnya', true),
            "input_by_id" => $this->session->userdata('id'),
            "tgl_input" => time()
        ];
        $this->db->insert('jenis_visa', $data);
    }
    public function EditJenisVisa()
    {

        $data = [
            "visa" => $this->input->post('nama_visa', true),
            "kategori_id" => $this->input->post('status_rptka', true),
            "id_visa_sebelumnya" => $this->input->post('visa_sebelumnya', true)
        ];
        $this->db->where('id', $this->input->post('id_visa'));
        $this->db->update('jenis_visa', $data);
    }
    public function DeleteJenisVisa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jenis_visa');
    }
}
