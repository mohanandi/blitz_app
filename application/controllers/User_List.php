<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_List extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
        is_logged_in();
    }
    public function index()
    {
        $data['judul'] = 'User List';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['users'] = $this->User_Model->getAllUser();
        $this->load->view('templates/header', $data);
        $this->load->view('user/user_list', $data);
        $this->load->view('templates/footer');
    }
    public function tambah()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]', [
            'is_unique' => 'Email ini sudah ada di Database'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('pic_pt', 'PIC PT', 'required');
        $this->form_validation->set_rules('is_active', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'User List';
            $data['users'] = null;
            $data['subjudul'] = 'Tambah User';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['button'] = "Tambahkan";
            $data['role'] = $this->User_Model->getRole();
            $this->load->view('templates/header', $data);
            $this->load->view('user/user_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->User_Model->TambahUser();
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('User_List');
        }
    }
    public function edit($id)
    {
        $data['users'] = $this->User_Model->getUserById($id);
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        if ($data['users']['email'] == $this->input->post('email', true)) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]', [
                'is_unique' => 'Email ini sudah ada di Database'
            ]);
        }
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('pic_pt', 'PIC PT', 'required');
        $this->form_validation->set_rules('is_active', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'User List';
            $data['button'] = "Simpan Edit";
            $data['subjudul'] = "Edit User";
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['role'] = $this->User_Model->getRole();
            $this->load->view('templates/header', $data);
            $this->load->view('user/user_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->User_Model->EditUser();
            $this->session->set_flashdata('flash', 'Dirubah');
            redirect('User_List');
        }
    }
}
