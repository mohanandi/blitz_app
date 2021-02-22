<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Rptka extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DataPt_Model');
        $this->load->model('Rptka_Model');
        is_logged_in();
    }
    public function index()
    {
        $this->form_validation->set_rules('dari', 'Dari', 'trim|required');
        $this->form_validation->set_rules('sampai', 'Sampai', 'trim|required');
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['data_rptka'] = $this->Rptka_Model->getAllRptka();
            $data['judul'] = 'Data RPTKA';
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_rptka/data_rptka', $data);
            $this->load->view('templates/footer');
        } else {
            $data['dari'] = strtotime($this->input->post('dari'));
            $data['sampai'] = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
            $data['data_rptka'] = $this->Rptka_Model->getAllRptkaFilter($this->input->post('nama_pt'));
            $data['judul'] = 'Data RPTKA';
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_rptka/data_rptka', $data);
            $this->load->view('templates/footer');
        }
    }
    public function tambah()
    {
        $this->form_validation->set_rules('nama_pt', 'Nama Mandarin', 'required');
        $this->form_validation->set_rules('no_rptka', 'Nama Latin', 'trim|required');
        $this->form_validation->set_rules('tgl_terbit', 'Kewarganegaraan', 'required');
        $this->form_validation->set_rules('tgl_expired', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('jumlah_pengguna', 'Jumalah Pengguna RPTKA', "required");
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Data RPTKA';
            $data['subjudul'] = 'Tambah RPTKA';
            $data['button'] = 'Tambahkan RPTKA';
            $data['data_rptka'] = null;
            $data['pt'] = $this->DataPt_Model->getAllDataPt();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_rptka/data_rptka_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Rptka_Model->TambahRptka();
            $rptka = $this->Rptka_Model->getLastRptka();
            $id_rptka =  $rptka['id'];
            $this->session->set_flashdata('flash', 'RPTKA berhasil Ditambah');
            redirect("Data_Rptka/detail/$id_rptka");
        }
    }
    public function edit($id)
    {
        $this->form_validation->set_rules('nama_pt', 'Nama Mandarin', 'required');
        $this->form_validation->set_rules('no_rptka', 'Nama Latin', 'required');
        $this->form_validation->set_rules('tgl_terbit', 'Kewarganegaraan', 'required');
        $this->form_validation->set_rules('tgl_expired', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'required');
        $this->form_validation->set_rules('jumlah_pengguna', 'Jumalah Pengguna RPTKA', "required");
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Data RPTKA';
            $data['subjudul'] = 'Tambah RPTKA';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['button'] = 'Simpan Edit RPTKA';
            $data['data_rptka'] = $this->Rptka_Model->getRptkaById($id);
            $data['pt'] = $this->DataPt_Model->getAllDataPt();
            $this->load->view('templates/header', $data);
            $this->load->view('data_rptka/data_rptka_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Rptka_Model->EditRptka();
            $this->session->set_flashdata('flash', 'RPTKA Berhasil Diubah');
            redirect("Data_Rptka/detail/$id");
        }
    }

    public function detail($id)
    {
        $data['judul'] = 'Data RPTKA';
        $data['data_rptka'] = $this->Rptka_Model->getRptkaById($id);
        $data['data_jabatan'] = $this->Rptka_Model->getJabatanByRptka($id);
        $data['data_pengguna'] = $this->Rptka_Model->getPenggunaRptka($id);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_rptka/data_rptka_detail', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_jabatan($id)
    {
        $data['data_rptka'] = $this->Rptka_Model->getRptkaById($id);
        $this->form_validation->set_rules('jabatan', 'Nama Jabatan', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Jabatan', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Data RPTKA';
            $data['subjudul'] = 'Tambah Jabatan RPTKA';
            $data['button'] = 'Tambahkan Jabatan RPTKA';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['data_jabatan'] = null;
            $this->load->view('templates/header', $data);
            $this->load->view('data_rptka/data_rptka_jabatan_form', $data);
            $this->load->view('templates/footer');
        } else {
            $jumlah_rptka = $data['data_rptka']['jumlah_rptka'];
            $terpakai = $this->Rptka_Model->getJabatanTerpakai($id);
            $jabatan_terpakai = 0;
            foreach ($terpakai as $jt) :
                $jabatan_terpakai += $jt['jumlah'];
            endforeach;
            $jabatan_terpakai += $this->input->post('jumlah');
            if ($jabatan_terpakai <= $jumlah_rptka) {
                $this->Rptka_Model->TambahJabatan($id);
                $this->session->set_flashdata('flash', 'Jabatan RPTKA Berhasil Ditambahkan');
                redirect("Data_Rptka/detail/$id");
            } else {
                $data['judul'] = 'Data RPTKA';
                $data['subjudul'] = 'Tambah Jabatan RPTKA';
                $data['button'] = 'Tambahkan Jabatan RPTKA';
                $data['data_jabatan'] = null;
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $this->session->set_flashdata('flash', 'Jabatan RPTKA Gagal Ditambahkan Karena Total Jumlah Tidak Sesuai');
                $this->load->view('templates/header', $data);
                $this->load->view('data_rptka/data_rptka_jabatan_form', $data);
                $this->load->view('templates/footer');
            }
        }
    }
    public function edit_jabatan($id)
    {
        $data['data_jabatan'] = $this->Rptka_Model->getJabatanByRptkaById($id);
        $data['data_rptka'] = $this->Rptka_Model->getRptkaById($data['data_jabatan']['id_rptka']);
        $id_rptka = $data['data_jabatan']['id_rptka'];
        $this->form_validation->set_rules('jabatan', 'Nama Jabatan', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Jabatan', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Data RPTKA';
            $data['subjudul'] = 'Edit Jabatan RPTKA';
            $data['button'] = 'Simpan Edit Jabatan RPTKA';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_rptka/data_rptka_jabatan_form', $data);
            $this->load->view('templates/footer');
        } else {
            $jumlah_rptka = $data['data_rptka']['jumlah_rptka'];
            $terpakai = $this->Rptka_Model->getJabatanTerpakai($id_rptka);
            $jabatan_terpakai = 0;
            foreach ($terpakai as $jt) :
                $jabatan_terpakai += $jt['jumlah'];
            endforeach;
            $jabatan_terpakai = $jabatan_terpakai - $data['data_jabatan']['jumlah'];
            $jabatan_terpakai += $this->input->post('jumlah');
            if ($jabatan_terpakai <= $jumlah_rptka) {
                $this->Rptka_Model->EditJabatan($id);
                $this->session->set_flashdata('flash', 'Jabatan RPTKA Berhasil Dirubah');
                redirect("Data_Rptka/detail/$id_rptka");
            } else {
                $data['judul'] = 'Data RPTKA';
                $data['subjudul'] = 'Edit Jabatan RPTKA';
                $data['button'] = 'Simpan Edit Jabatan RPTKA';
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $this->session->set_flashdata('flash', 'Jabatan RPTKA Gagal Ditambahkan Karena Total Jumlah Tidak Sesuai');
                $this->load->view('templates/header', $data);
                $this->load->view('data_rptka/data_rptka_jabatan_form', $data);
                $this->load->view('templates/footer');
            }
        }
    }
}
