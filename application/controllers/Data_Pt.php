<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Pt extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataPt_Model');
        $this->load->model('User_Model');
        is_logged_in();
    }

    public function index()
    {
        $data['judul'] = 'Data Perusahaan';
        $data['pt'] = $this->DataPt_Model->getAllDataPt();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_pt/data_pt', $data);
        $this->load->view('templates/footer');
    }
    public function detail($id)
    {
        $data['judul'] = 'Data Perusahaan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['data_pt'] = $this->DataPt_Model->getPtById($id);
        $data['data_pic'] = $this->User_Model->getUserById($data['data_pt']['id_pic']);
        $data['input_by'] = $this->User_Model->getUserById($data['data_pt']['input_by_id']);
        $data['data_jenis_visa'] = $this->DataPt_Model->getDataJenisVisa();
        $data['data_tka'] = $this->DataPt_Model->getDataTka($id);
        $data['jumlah_voucher'] = $this->DataPt_Model->jumlahVoucher($id);
        $this->load->view('templates/header', $data);
        $this->load->view('data_pt/data_pt_detail', $data);
        $this->load->view('templates/footer');
    }
    public function tambah()
    {
        $this->form_validation->set_rules('nama_pt', 'Nama PT', 'trim|required|is_unique[pt.nama_pt]', [
            'is_unique' => 'Nama PT ini sudah ada di Database'
        ]);
        $this->form_validation->set_rules('pic', 'PIC', 'required');
        $this->form_validation->set_rules('client', 'Nama Client', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['pic'] = $this->User_Model->getPic();
            $data['judul'] = 'Data Perusahaan';
            $data['subjudul'] = "Tambah PT";
            $data['button'] = "Tambahkan";
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['data_pt'] = null;
            $this->load->view('templates/header', $data);
            $this->load->view('data_pt/data_pt_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->DataPt_Model->tambahDataPt();
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('Data_Pt');
        }
    }

    public function hapus($id)
    {
        $this->DataPt_Model->hapusDataPt($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Data_Pt');
    }

    public function edit($id)
    {
        $data['judul'] = 'Data Perusahaan';
        $data['subjudul'] = 'Edit PT';
        $data['button'] = 'Simpan Edit';
        $data['data_pt'] = $this->DataPt_Model->getPtById($id);
        $data['pic'] = $this->User_Model->getPic();
        $id_pt = $data['data_pt']['id'];
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($data['data_pt']['nama_pt'] == $this->input->post('nama_pt', true)) {
            $this->form_validation->set_rules('nama_pt', 'Nama PT', 'trim|required');
        } else {
            $this->form_validation->set_rules('nama_pt', 'nama_pt', 'required|is_unique[pt.nama_pt]', [
                'is_unique' => 'Nama Pt ini sudah ada di Database'
            ]);
        }
        $this->form_validation->set_rules('pic', 'PIC', 'required');
        $this->form_validation->set_rules('client', 'Client', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('data_pt/data_pt_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->DataPt_Model->EditPt();
            $this->session->set_flashdata('flash', 'Diubah');
            redirect("Data_Pt/detail/$id_pt");
        }
    }

    public function sidebar()
    {
        $this->load->view('sidebar');
    }
}
