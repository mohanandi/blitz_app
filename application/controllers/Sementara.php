<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sementara extends CI_Controller
{
    public function index()
    {
        $data['judul'] = 'Data PT';
        $this->load->view('templates/header', $data);
        $this->load->view('data_pt');
        $this->load->view('templates/footer');
    }
    public function PT_Dashboard()
    {
        $data['judul'] = 'Data PT | Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('Data PT-Dashboard');
        $this->load->view('templates/footer');
    }
    public function PT_Notif()
    {
        $data['judul'] = 'Data PT | Notif';
        $this->load->view('templates/header', $data);
        $this->load->view('Data PT-Dashboard');
        $this->load->view('templates/footer');
    }
    public function TKA_Detail()
    {
        $data['judul'] = 'Data TKA | Detail';
        $this->load->view('templates/header', $data);
        $this->load->view('Data TKA-Detail');
        $this->load->view('templates/footer');
    }
    public function TKA_Edit()
    {
        $data['judul'] = 'Data TKA | Edit';
        $this->load->view('templates/header', $data);
        $this->load->view('Data TKA-Edit');
        $this->load->view('templates/footer');
    }
    public function TKA_Notif()
    {
        $data['judul'] = 'Data TKA | Notif';
        $this->load->view('templates/header', $data);
        $this->load->view('Data TKA-Notif');
        $this->load->view('templates/footer');
    }
    public function TKA_Tambah()
    {
        $data['judul'] = 'Data TKA | Tambah';
        $this->load->view('templates/header', $data);
        $this->load->view('Data TKA-Tambah');
        $this->load->view('templates/footer');
    }
    public function Data_TKA()
    {
        $data['judul'] = 'Data TKA';
        $this->load->view('templates/header', $data);
        $this->load->view('Data TKA');
        $this->load->view('templates/footer');
    }
    public function Visa_Dashboard()
    {
        $data['judul'] = 'Data Visa | Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('Data Visa-Dashboard');
        $this->load->view('templates/footer');
    }
    public function Visa_Tambah()
    {
        $data['judul'] = 'Data Visa | Tambah';
        $this->load->view('templates/header', $data);
        $this->load->view('Data Visa-tambah');
        $this->load->view('templates/footer');
    }
    public function Home()
    {
        $data['judul'] = 'Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('Home');
        $this->load->view('templates/footer');
    }
    public function User_Profile()
    {
        $data['judul'] = 'User Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('User Profile');
        $this->load->view('templates/footer');
    }
    public function User()
    {
        $data['judul'] = 'User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('user');
        $this->load->view('templates/footer');
    }
}
