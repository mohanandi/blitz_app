<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
    }

    public function index()
    {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['judul'] = "Login";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }
    public function forgot_password()
    {
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['judul'] = "Forgot Password";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => "Aktif"])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please chech your email to reser your password!</div>');
                redirect('auth/forgot_password');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not regitered or activated!</div>');
                redirect('auth/forgot_password');
            }
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://srv64.niagahoster.com',
            'smtp_user' => 'system@blitzindoutama.com',
            'smtp_pass' => 'blitzindoutama',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);
        // $filename = 'assets/images/emaillogo.png';
        // $this->email->attach($filename);

        $this->email->from('system@blitzindoutama.com', 'Blitzindo');
        $this->email->to($this->input->post('email'));

        if ($type == 'forgot') {
            $this->email->subject('[Blitzindo Utama] Password Reset Request for Blitzindo Utama');
            // $cid = $this->email->attachment_cid($filename);
            // $this->email->message('<img src="cid:' . $cid . '" alt="logoblitz"');
            $this->email->message('We heard that you lost your password. Sorry about that! <br><br>  But don’t worry! You can use the following link to reset your password: <br> <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a> <br><br> Best Regrads, <br> Blitzindo Utama Team <br><br><br>   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
            <HTML><HEAD><TITLE>Email Signature</TITLE>
            <META content="text/html; charset=utf-8" http-equiv="Content-Type">
            </HEAD>
            <BODY style="font-size: 10pt; font-family: Arial, sans-serif;">
            
            <table style="width: 515px; font-size: 10pt; font-family: Arial, sans-serif;"  cellspacing="0" cellpadding="0">
              <tbody>
              <tr>
                <td style="font-size: 14pt;  color:#000e58; font-family: Arial, sans-serif; width: 514px; padding-bottom: 10px; vertical-align:top;" colspan="2" valign="top">  <strong><span style="font-size: 14pt; font-family: Arial, sans-serif; color:#fcb01c;">Blitzindo Utama</span></strong><br>  <span style="font-size: 10pt; font-family: Arial, sans-serif; color:#000000;">Handling expatriate legality in Indonesia.</span></td>
              </tr>
              <tr><td style="font-size: 10pt; border-top: 1px solid; border-top-color: #fcb01c; color:#363636; font-family: Arial, sans-serif;  padding-top: 10px; vertical-align:top;" colspan="2" valign="top">
                 <span style="font-size: 10pt; font-family: Arial, sans-serif; color:#363636"><strong>PT. Blitzindo Utama</strong><br></span> 
                 <span style="font-size: 10pt; font-family: Arial, sans-serif; color:#363636">Mega Glodok Kemayoran Blok E 18 Jl. Angkasa Kav. B6, Kemayoran, Jakarta Pusat<br></span>
                 <span style="font-size: 10pt; font-family: Arial, sans-serif; color:#363636">10616, Indonesia<br></span>
                 
                 
                 <span style="font-size: 10pt; font-family: Arial, sans-serif; color:#363636;">email: system@blitzindoutama.com<br></span>								</td>
              </tr>  
              <tr>
                <td style="font-size: 10pt; padding-bottom: 10px; padding-top: 10px; vertical-align:top;"  valign="top"><strong>	<a href="http://www.blitzindoutama.com" target="_blank" rel="noopener" style="text-decoration:none;"><span style="color:#000e58; font-family: Arial, sans-serif;"><span style="font-size: 10pt; font-family: Arial, sans-serif; color:#fcb01c;">www.blitzindoutama.com</span></span></a></strong></td>
                <td style="font-size: 10pt; font-family: Arial, sans-serif; padding-bottom: 10px; padding-top: 10px; vertical-align:top; text-align:right;"  valign="top" align="right">
                 </td>	 	 	
              </tr>
              <tr>
                <td style="font-size: 10pt; font-family: Arial, sans-serif; padding-bottom: 10px; padding-top: 10px; vertical-align:top;" colspan="2" valign="top">	
                 <a href="https://www.codetwo.com/email-signatures/" target="_blank" rel="noopener">
                  <img alt="Banner" style="width:514px; height:auto; border:0;" src="https://drive.google.com/uc?export=download&amp;id=1z_GSL9LwkbG3mRj8rZO0EeKtnTDjyKvS" width="514" border="0">
                 </a>	 </td>
              </tr>
              <tr>
                <td style="font-size: 9pt; color:#363636; font-family: Arial, sans-serif; padding-top: 10px; vertical-align:top;" colspan="2"  valign="top">      
                 <div style="color:#363636; font-size: 9pt; font-family: Arial, sans-serif; text-align:justify; width:514px;"  align="justify">The content of this message is confidential. If you have received it by mistake, please inform us by an email reply and then delete the message. It is forbidden to copy, forward, or in any way reveal the contents of this message to anyone. The integrity and security of this email cannot be guaranteed over the Internet. Therefore, the sender will not be held liable for any damage caused by the message.</div></td>
              </tr>
              </tbody>
             </table>
            </BODY></HTML>
            
            
            ');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function resetpassword()
    {
        $email  = $this->input->get('email');
        $token  = $this->input->get('token');
        $user   = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Failed! Wrong Token.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Failed! Wrong Email.</div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[8]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[8]|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['judul'] = "Change Password";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change_password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please login.</div>');
            redirect('auth');
        }
    }
    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['is_active'] == "Aktif") {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->User_Model->lastLogin($user['id']);
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('Home');
                    } else {
                        redirect('Home');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email has not been activated!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered!</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth');
    }
}
