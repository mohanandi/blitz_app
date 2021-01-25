<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Tka extends CI_Controller
{
    public $judul = 'Data TKA';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tka_Model');
        $this->load->model('DataPt_Model');
        $this->load->model('User_Model');
        is_logged_in();
    }
    public function index()
    {
        $data['id_tka'] = $this->Tka_Model->getAllIdTka();
        $data['judul'] = $this->judul;
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_tka/data_tka', $data);
        $this->load->view('templates/footer');
    }
    public function detail($id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['tka'] = $this->Tka_Model->getTkaById($id);
        $data['pt'] = $this->DataPt_Model->getPtById($data['tka']['id_pt']);
        $data['user'] = $this->User_Model->getUserById($data['tka']['input_by_id']);
        $data['riwayat_visa211'] = $this->Tka_Model->getIdVisa211($id);
        $data['riwayat_visa312'] = $this->Tka_Model->getIdVisa312($id);
        $data['riwayat_voucher'] = $this->Tka_Model->getVoucher($id);
        $data['judul'] = $this->judul;
        $this->load->view('templates/header', $data);
        $this->load->view('data_tka/data_tka_detail', $data);
        $this->load->view('templates/footer');
    }
    public function edit($id)
    {
        $data['tka'] = $this->Tka_Model->getTkaById($id);

        $this->form_validation->set_rules('nama_mandarin', 'Nama Mandarin', 'required');
        $this->form_validation->set_rules('nama_latin', 'Nama Latin', 'required');
        $this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        if ($data['tka']['passport'] == $this->input->post('passport', true)) {
            $this->form_validation->set_rules('passport', 'Passport', 'required');
        } else {
            $this->form_validation->set_rules('passport', 'Passport', 'required|is_unique[tka.passport]', [
                'is_unique' => 'Passport ini sudah ada di Database'
            ]);
        }
        $this->form_validation->set_rules('exp_passport', 'Expired Passport', 'required');
        $this->form_validation->set_rules('nama_pt', 'Nama PT', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pt'] = $this->DataPt_Model->getAllDataPt();
            $data['judul'] = $this->judul;
            $data['subjudul'] = "Edit TKA";
            $data['button'] = "Simpan Edit";
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_tka/data_tka_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Tka_Model->EditTka();
            $this->session->set_flashdata('flash', 'Dirubah');
            redirect("Data_Tka/detail/$id");
        }
    }
    public function tambah()
    {
        $this->form_validation->set_rules('nama_mandarin', 'Nama Mandarin', 'required');
        $this->form_validation->set_rules('nama_latin', 'Nama Latin', 'required');
        $this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('passport', 'Passport', 'required|is_unique[tka.passport]', [
            'is_unique' => 'Passport ini sudah ada di Database'
        ]);
        $this->form_validation->set_rules('exp_passport', 'Expired Passport', 'required');
        $this->form_validation->set_rules('nama_pt', 'Nama PT', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['pt'] = $this->DataPt_Model->getAllDataPt();
            $data['tka'] = null;
            $data['button'] = "Tambahkan";
            $data['subjudul'] = "Tambah TKA";
            $data['judul'] = $this->judul;
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_tka/data_tka_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Tka_Model->tambahTka();
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('Data_Tka');
        }
    }
    public function notif()
    {
        $data['judul'] = $this->judul;
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header');
        $this->load->view('data_taka/data_tka_notif');
        $this->load->view('templates/footer');
    }
}
