<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tambah_User extends CI_Controller
{
    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('tambah_user');
        $this->load->view('templates/footer');
    }

}
