<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Home_Model');
    }

    public function index()
    {
        // $data = $this->Home_Model->getData(9);
        // $jumlah_visa_minggu = array();
        // var_dump($data);
        // echo "<br>";
        // echo date('d-m-Y', time() + (60 * 60 * 24 * 7));
        $data['jumlah_rptka'] = $this->Home_Model->jumlahRptka();
        $data['jumlah_tka'] = $this->Home_Model->jumlahTka();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['jumlah_pt'] = $this->Home_Model->jumlahPt();
        $data['jumlah_voucher'] = $this->Home_Model->jumlahVoucher();
        $data['data_visa'] = $this->Home_Model->getDataJenisVisa();
        // foreach ($data['data_visa']['id'] as $visa) :
        //     $jumlah = $this->Home_Model->getData($visa['id']);
        //     array_push($jumlah, $jumlah_visa_minggu);
        // endforeach;
        // var_dump($jumlah_visa_minggu);
        $data['judul'] = "Reminder Schedule";
        $this->load->view('templates/header', $data);
        $this->load->view('report/home', $data);
        $this->load->view('templates/footer');
    }
    public function perusahaan()
    {
        // $data = $this->Home_Model->getData(9);
        // $jumlah_visa_minggu = array();
        // var_dump($data);
        // echo "<br>";
        // echo date('d-m-Y', time() + (60 * 60 * 24 * 7));
        $this->form_validation->set_rules('dari', 'Dari', 'trim|required');
        $this->form_validation->set_rules('sampai', 'Sampai', 'trim|required');
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['jumlah_rptka'] = $this->Home_Model->jumlahRptka();
            $data['jumlah_tka'] = $this->Home_Model->jumlahTka();
            $data['jumlah_pt'] = $this->Home_Model->jumlahPt();
            $data['jumlah_voucher'] = $this->Home_Model->jumlahVoucher();
            $data['data_visa'] = $this->Home_Model->getDataJenisVisa();
            $data['data_pt'] = $this->Home_Model->getPt();
        } else {
            $data['jumlah_rptka'] = $this->Home_Model->jumlahRptka(strtotime($this->input->post('dari')), strtotime($this->input->post('sampai')), $this->input->post('nama_pt'));
            $data['jumlah_tka'] = $this->Home_Model->jumlahTka();
            $data['jumlah_pt'] = $this->Home_Model->jumlahPt();
            $data['jumlah_voucher'] = $this->Home_Model->jumlahVoucher();
            $data['data_visa'] = $this->Home_Model->getDataJenisVisa();
            if ($this->input->post('nama_pt') == 'Semua Perusahaan') {
                $data['data_pt'] = $this->Home_Model->getPt();
            } else {
                $data['data_pt'] = $this->Home_Model->getPt();
            }
        }
        // foreach ($data['data_visa']['id'] as $visa) :
        //     $jumlah = $this->Home_Model->getData($visa['id']);
        //     array_push($jumlah, $jumlah_visa_minggu);
        // endforeach;
        // var_dump($jumlah_visa_minggu);
        $data['judul'] = "Report By Perusahaan";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('report/report', $data);
        $this->load->view('templates/footer');
    }
    public function proses()
    {
        // $data = $this->Home_Model->getData(9);
        // $jumlah_visa_minggu = array();
        // var_dump($data);
        // echo "<br>";
        // echo date('d-m-Y', time() + (60 * 60 * 24 * 7));
        $this->form_validation->set_rules('dari', 'Dari', 'trim|required');
        $this->form_validation->set_rules('sampai', 'Sampai', 'trim|required');
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['jumlah_rptka'] = $this->Home_Model->jumlahRptka();
            $data['jumlah_tka'] = $this->Home_Model->jumlahTka();
            $data['jumlah_pt'] = $this->Home_Model->jumlahPt();
            $data['jumlah_voucher'] = $this->Home_Model->jumlahVoucher();
            $data['data_visa'] = $this->Home_Model->getDataJenisVisa();
            $data['data_pt'] = $this->Home_Model->getPt();
        } else {
        }
        // foreach ($data['data_visa']['id'] as $visa) :
        //     $jumlah = $this->Home_Model->getData($visa['id']);
        //     array_push($jumlah, $jumlah_visa_minggu);
        // endforeach;
        // var_dump($jumlah_visa_minggu);
        $data['judul'] = "Report By Proccess";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('report/report', $data);
        $this->load->view('templates/footer');
    }

    public function expired($id_visa)
    {
        $data['judul'] = "Reminder Schedule";
        $data['data_jenis_visa'] = $this->Home_Model->getJenisVisa($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['batas'] = "Expired";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($data['data_jenis_visa']['kategori_id'] == 1) {
            $data['data_penghubung_visa'] = $this->Home_Model->getExpiredVisa312($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_312', $data);
            $this->load->view('templates/footer');
        } else {
            // $data['data_penghubung_visa'] = $this->Home_Model->getPenghubungVisa211($id_visa);
            $data['data_penghubung_visa'] = $this->Home_Model->getExpiredData($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_211', $data);
            $this->load->view('templates/footer');
        }
    }
    public function seminggu($id_visa)
    {
        $data['judul'] = "Reminder Schedule";
        $data['data_jenis_visa'] = $this->Home_Model->getJenisVisa($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['batas'] = "Seminggu";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($data['data_jenis_visa']['kategori_id'] == 1) {
            $data['data_penghubung_visa'] = $this->Home_Model->getSemingguVisa312($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_312', $data);
            $this->load->view('templates/footer');
        } else {
            // $data['data_penghubung_visa'] = $this->Home_Model->getPenghubungVisa211($id_visa);
            $data['data_penghubung_visa'] = $this->Home_Model->getSemingguData($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_211', $data);
            $this->load->view('templates/footer');
        }
    }
    public function duaminggu($id_visa)
    {
        $data['judul'] = "Reminder Schedule";
        $data['data_jenis_visa'] = $this->Home_Model->getJenisVisa($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['batas'] = "Dua Minggu";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($data['data_jenis_visa']['kategori_id'] == 1) {
            $data['data_penghubung_visa'] = $this->Home_Model->getDuamingguVisa312($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_312', $data);
            $this->load->view('templates/footer');
        } else {
            $data['data_penghubung_visa'] = $this->Home_Model->getDuamingguData($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_211', $data);
            $this->load->view('templates/footer');
        }
    }
    public function tigaminggu($id_visa)
    {
        $data['judul'] = "Reminder Schedule";
        $data['data_jenis_visa'] = $this->Home_Model->getJenisVisa($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['batas'] = "Tiga Minggu";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($data['data_jenis_visa']['kategori_id'] == 1) {
            $data['data_penghubung_visa'] = $this->Home_Model->getTigamingguVisa312($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_312', $data);
            $this->load->view('templates/footer');
        } else {
            $data['data_penghubung_visa'] = $this->Home_Model->getTigamingguData($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_211', $data);
            $this->load->view('templates/footer');
        }
    }
    public function sebulan($id_visa)
    {
        $data['judul'] = "Reminder Schedule";
        $data['data_jenis_visa'] = $this->Home_Model->getJenisVisa($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['batas'] = "Sebulan";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($data['data_jenis_visa']['kategori_id'] == 1) {
            $data['data_penghubung_visa'] = $this->Home_Model->getSebulanVisa312($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_312', $data);
            $this->load->view('templates/footer');
        } else {
            $data['data_penghubung_visa'] = $this->Home_Model->getTSebulanData($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('report/data_report_211', $data);
            $this->load->view('templates/footer');
        }
    }

    public function nonaktifkan211($id_penghubung, $batas)
    {
        $data_penghubung = $this->Home_Model->getPenghubungVisa211ById($id_penghubung);
        $id_visa = $data_penghubung['id_jenis_visa'];
        $this->Home_Model->nonaktif211($id_penghubung);
        $this->session->set_flashdata('flash', 'Visa Telah Dinonaktifkan');
        if ($batas == 'Expired') {
            redirect("Home/expired/$id_visa");
        } elseif ($batas == 'Seminggu') {
            redirect("Home/seminggu/$id_visa");
        } elseif ($batas == 'Dua Minggu') {
            redirect("Home/duaminggu/$id_visa");
        } elseif ($batas == 'Tiga Minggu') {
            redirect("Home/tigaminggu/$id_visa");
        } elseif ($batas == 'Sebulan') {
            redirect("Home/sebulan/$id_visa");
        }
    }
    public function nonaktifkan312($id_penghubung, $batas)
    {
        $data_penghubung = $this->Home_Model->getPenghubungVisa312ById($id_penghubung);
        $id_visa = $data_penghubung['id_jenis_visa'];
        $this->Home_Model->nonaktif312($id_penghubung);
        $this->session->set_flashdata('flash', 'Visa Telah Dinonaktifkan');
        if ($batas == 'Expired') {
            redirect("Home/expired/$id_visa");
        } elseif ($batas == 'Seminggu') {
            redirect("Home/seminggu/$id_visa");
        } elseif ($batas == 'Dua Minggu') {
            redirect("Home/duaminggu/$id_visa");
        } elseif ($batas == 'Tiga Minggu') {
            redirect("Home/tigaminggu/$id_visa");
        } elseif ($batas == 'Sebulan') {
            redirect("Home/sebulan/$id_visa");
        }
    }
}
