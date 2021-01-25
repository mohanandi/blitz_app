<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends CI_Model
{

    public function getRole()
    {
        return $this->db->get('role')->result_array();
    }
    public function getUserById($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }
    public function getPic()
    {
        return $this->db->get_where('user', ['pic_pt' => 'Aktif'])->result_array();
    }
    public function getAllUser()
    {
        $query = "SELECT `user`.*, `role`.`role`
        FROM `user` JOIN `role`
        ON `user`.`role_id` = `role`.`id`
      ";
        return $this->db->query($query)->result_array();
    }

    public function lastLogin($id)
    {
        $data = [
            "last_login" => time()
        ];
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }
    public function TambahUser()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "email" => $this->input->post('email', true),
            "password" => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            "image" => 'default.jpg',
            "role_id" => $this->input->post('role_id', true),
            "pic_pt" => $this->input->post('pic_pt', true),
            "is_active" => $this->input->post('is_active', true),
            "date_created" => time(),
            "last_login" => 0
        ];
        $this->db->insert('user', $data);
    }
    public function EditUser()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "email" => $this->input->post('email', true),
            "role_id" => $this->input->post('role_id', true),
            "pic_pt" => $this->input->post('pic_pt', true),
            "is_active" => $this->input->post('is_active', true),
        ];
        $this->db->where('id', $this->input->post('id_user'));
        $this->db->update('user', $data);
    }
}
