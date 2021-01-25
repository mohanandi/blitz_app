<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_Model extends CI_Model
{

    public function check($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }
    public function getUserById($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }
}
