<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_Visa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Jenis_Visa_Model');
    }

    public function index()
    {
        $data['judul'] = 'Visa';
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisa();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('visa_voucher/data_visa', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id)
    {
        $data['jenis_visa_detail'] = $this->Jenis_Visa_Model->getJenisVisaById($id);
        if ($data['jenis_visa_detail']['visa'] == $this->input->post('nama_visa', true)) {
            $this->form_validation->set_rules('nama_visa', 'Nama Visa', 'required');
        } else {
            $this->form_validation->set_rules('nama_visa', 'Nama Visa', 'required|is_unique[jenis_visa.visa]', [
                'is_unique' => 'Nama Visa ini sudah ada di Database'
            ]);
        }
        $this->form_validation->set_rules('status_rptka', 'Status RPTKA', 'required');
        $this->form_validation->set_rules('visa_sebelumnya', 'Syarat Pengisian Sebelumnya', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'data_kategori' => $this->Jenis_Visa_Model->getAllKategori(),
                'data_jenis_visa' => $this->Jenis_Visa_Model->getAllJenisVisa(),
            );
            $data['judul'] = 'Visa';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['button'] = 'Simpan Edit Visa';
            $data['subjudul'] = 'Edit Visa';
            $data['jenis_visa_detail'] = $this->Jenis_Visa_Model->getJenisVisaById($id);
            $this->load->view('templates/header', $data);
            $this->load->view('visa_voucher/data_visa_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Jenis_Visa_Model->EditJenisVisa();
            $this->session->set_flashdata('flash', 'Dirubah');
            redirect("Jenis_Visa");
        }
    }

    public function tambah()
    {
        $this->form_validation->set_rules('nama_visa', 'Nama Visa', 'required|is_unique[jenis_visa.visa]', [
            'is_unique' => 'Nama Visa ini sudah ada di Database'
        ]);
        $this->form_validation->set_rules('status_rptka', 'Status RPTKA', 'required');
        $this->form_validation->set_rules('visa_sebelumnya', 'Syarat Pengisian Sebelumnya', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'data_kategori' => $this->Jenis_Visa_Model->getAllKategori(),
                'data_jenis_visa' => $this->Jenis_Visa_Model->getAllJenisVisa(),
            );
            $data['jenis_visa_detail'] = null;
            $data['judul'] = 'Visa';
            $data['subjudul'] = 'Tambah Visa';
            $data['button'] = 'Tambahkan Visa';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('visa_voucher/data_visa_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Jenis_Visa_Model->TambahJenisVisa();
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect("Jenis_Visa");
        }
    }
    public function hapus($id)
    {
        $this->Jenis_Visa_Model->DeleteJenisVisa($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect("Jenis_Visa");
    }
}
