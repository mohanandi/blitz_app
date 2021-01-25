<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Visa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Data_Visa_Model');
        $this->load->model('Rptka_Model');
        $this->load->model('Jenis_Visa_Model');
        $this->load->model('DataPt_Model');
        $this->load->model('Tka_Model');
    }
    public function index()
    {
        $data['judul'] = 'Data Visa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisa();
        $this->load->view('templates/header', $data);
        $this->load->view('data_visa/data_visa', $data);
        $this->load->view('templates/footer');
    }
    public function filter_tka_visa312($id_visa)
    {

        $data['judul'] = 'Data Visa';
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->input->post('nama_pt')) {
            if (($data['data_jenis_visa']['id_visa_sebelumnya'] == 1) or ($data['data_jenis_visa']['id_visa_sebelumnya'] == 2)) {
                $data['id_tenaga'] = $this->Tka_Model->getTkaIdByPt($this->input->post('nama_pt'));
                $data['jalan_pintas'] = null;
                $data['check_pt'] = $this->input->post('nama_pt');
            } else {
                $data['visa_sebelumnya'] = $this->Jenis_Visa_Model->getJenisVisaById($data['data_jenis_visa']['id_visa_sebelumnya']);
                $data['id_tenaga'] = $this->Data_Visa_Model->getVisa312Sebelumnya($data['visa_sebelumnya']['id']);
                $data['jalan_pintas'] = 1;
                $data['check_pt'] = $this->input->post('nama_pt');
            }
        } else {
            if (($data['data_jenis_visa']['id_visa_sebelumnya'] == 1) or ($data['data_jenis_visa']['id_visa_sebelumnya'] == 2)) {
                $data['id_tenaga'] = $this->Tka_Model->getTkaIdPt();
                $data['jalan_pintas'] = null;
                $data['check_pt'] = null;
            } else {
                $data['visa_sebelumnya'] = $this->Jenis_Visa_Model->getJenisVisaById($data['data_jenis_visa']['id_visa_sebelumnya']);
                $data['id_tenaga'] = $this->Data_Visa_Model->getVisa312Sebelumnya($data['visa_sebelumnya']['id']);
                $data['jalan_pintas'] = 1;
                $data['check_pt'] = null;
            }
        }
        $this->load->view('templates/header', $data);
        $this->load->view('data_visa/data_visa312_filter', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_visa312()
    {
        $id_tka = $this->input->post('id_tka');
        $data['data_tka'] = $this->Tka_Model->getTkaById($id_tka);
        $data = array(
            'data_rptka' => $this->Rptka_Model->getRptkaByPt($data['data_tka']['id_pt']),
            'data_jabatan' => $this->Rptka_Model->getJabtanPilihan(),
        );
        $this->form_validation->set_rules('no_rptka', 'No RPTKA', 'trim|required');
        $this->form_validation->set_rules('jabatan_rptka', 'Jabatan RPTKA', 'trim|required');
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal Visa', 'trim|required');
        $this->form_validation->set_rules('waktu_visa', 'Jangka Waktu visa (Bulan)', 'trim|required');
        $this->form_validation->set_rules('tgl_expired', 'Tanggal Expired', 'trim|required');
        $this->form_validation->set_rules('no_kitas', 'No KITAS', 'trim|required');
        $this->form_validation->set_rules('no_notifikasi', 'No Notifikasi', 'trim|required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
        $data['data_tka'] = $this->Tka_Model->getTkaById($id_tka);
        $data['ket_visa'] = 'tambah';
        $data['data_visa'] = null;
        $id_tka = $this->input->post('id_tka');
        $id_visa = $this->input->post('id_visa');
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
        $data['subjudul'] = "Tambah Data " . $data['data_jenis_visa']['visa'];
        $data['judul'] = 'Data Visa';
        $data['button'] = 'Tambahkan Data Visa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/data_visa312_form', $data);
            $this->load->view('templates/footer');
        } else {
            if (($data['data_jenis_visa']['id_visa_sebelumnya'] == 1) or ($data['data_jenis_visa']['id_visa_sebelumnya'] == 2)) {
                $id_visa = $this->input->post('id_visa');
                $this->Data_Visa_Model->tambahPenghubungVisa312();
                $id_penghubung = $this->Data_Visa_Model->getPenghubungVisa312();
                $this->Data_Visa_Model->tambahVisa312($id_penghubung['id_penghubung_visa312']);
                $jabatan = $this->Rptka_Model->getJabatanById($this->input->post('jabatan_rptka'));
                $jabatan_terpakai = $jabatan['terpakai'] + 1;
                $this->Rptka_Model->TambahTerpakaiJabatan($jabatan_terpakai);
                $rptka = $this->Rptka_Model->getRptkaById($this->input->post('no_rptka'));
                $terpakai = $rptka['jumlah_terpakai'] + 1;
                $this->Rptka_Model->TambahTerpakaiRptka($terpakai);
                $this->session->set_flashdata('flash', 'Visa Berhasil Ditambahkan');
                redirect("Data_Visa/visa312/$id_visa");
            } else {
                $this->Data_Visa_Model->tambahPenghubungVisa312();
                $id_penghubung_sebelumnya = $this->Data_Visa_Model->getPenghubungVisa312sebelumnya($data['data_jenis_visa']['id_visa_sebelumnya'], $id_tka);
                $this->Data_Visa_Model->updatePenghubungVisa312($id_penghubung_sebelumnya['id_penghubung_visa312']);
                $id_penghubung = $this->Data_Visa_Model->getPenghubungVisa312();
                $this->Data_Visa_Model->tambahVisa312($id_penghubung['id_penghubung_visa312']);
                $jabatan = $this->Rptka_Model->getJabatanById($this->input->post('jabatan_rptka'));
                $jabatan_terpakai = $jabatan['terpakai'] + 1;
                $this->Rptka_Model->TambahTerpakaiJabatan($jabatan_terpakai);
                $rptka = $this->Rptka_Model->getRptkaById($this->input->post('no_rptka'));
                $terpakai = $rptka['jumlah_terpakai'] + 1;
                $this->Rptka_Model->TambahTerpakaiRptka($terpakai);
                $this->session->set_flashdata('flash', 'Visa Berhasil Ditambahkan');
                redirect("Data_Visa/visa312/$id_visa");
            }
        }
    }

    public function visa211($id_visa)
    {
        $this->form_validation->set_rules('dari', 'Dari', 'trim|required');
        $this->form_validation->set_rules('sampai', 'Sampai', 'trim|required');
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Data Visa';
            $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
            $data['data_pengguna_visa'] = $this->Data_Visa_Model->getAllvisa211($id_visa);
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['subjudul'] = $data['data_jenis_visa']['visa'];
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/data_visa211', $data);
            $this->load->view('templates/footer');
        } else {
            $data['dari'] = strtotime($this->input->post('dari'));
            $data['sampai'] = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
            $id_pt = $this->input->post('nama_pt');
            $data['judul'] = 'Data Visa';
            $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
            $data['data_pengguna_visa'] = $this->Data_Visa_Model->getAllVisa211Filter($id_visa, $id_pt);
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['subjudul'] = $data['data_jenis_visa']['visa'];
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/data_visa211', $data);
            $this->load->view('templates/footer');
        }
    }
    public function visa_all()
    {
        $this->form_validation->set_rules('dari', 'Dari', 'trim|required');
        $this->form_validation->set_rules('sampai', 'Sampai', 'trim|required');
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');
        $this->form_validation->set_rules('jenis_visa', 'Jenis Visa', 'trim|required');
        $data['data_jenis_visa'] = $this->Data_Visa_Model->getAllJenisVisa();
        $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Data Visa';
            $id_pt = 'Semua Perusahaan';
            $data['data_pengguna_visa211'] = $this->Data_Visa_Model->getAllPenghubungVisa211($id_pt);
            $data['data_pengguna_visa312'] = $this->Data_Visa_Model->getAllPenghubungVisa312($id_pt);
            $data['subjudul_211'] = 'Visa Non-RPTKA';
            $data['subjudul_312'] = 'Visa (RPTKA)';
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/visa_all', $data);
            $this->load->view('templates/footer');
        } else {
            $data['dari'] = strtotime($this->input->post('dari'));
            $data['sampai'] = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
            $id_visa = $this->input->post('jenis_visa');
            $id_pt = $this->input->post('nama_pt');
            $data['judul'] = 'Data Visa';
            if ($id_visa == 'All Visa') {
                $data['data_pengguna_visa211'] = $this->Data_Visa_Model->getAllPenghubungVisa211($id_pt);
                $data['data_pengguna_visa312'] = $this->Data_Visa_Model->getAllPenghubungVisa312($id_pt);
                $data['subjudul_211'] = 'Visa Non-RPTKA';
                $data['subjudul_312'] = 'Visa (RPTKA)';
                $this->load->view('templates/header', $data);
                $this->load->view('data_visa/visa_all', $data);
                $this->load->view('templates/footer');
            } else {
                $data['jenis_visa_pilihan'] = $this->Data_Visa_Model->getJenisVisaById($id_visa);
                if ($data['jenis_visa_pilihan']['kategori_id'] == 1) {
                    $data['subjudul'] = $data['jenis_visa_pilihan']['visa'];
                    $data['data_pengguna_visa312'] = $this->Data_Visa_Model->getAllVisa312Filter($id_visa, $id_pt);
                    $this->load->view('templates/header', $data);
                    $this->load->view('data_visa/visa_all_filter312', $data);
                    $this->load->view('templates/footer');
                } else {
                    $data['subjudul'] = $data['jenis_visa_pilihan']['visa'];
                    $data['data_pengguna_visa211'] = $this->Data_Visa_Model->getAllVisa211Filter($id_visa, $id_pt);
                    var_dump($this->input->post());
                    var_dump($data['data_pengguna_visa211']);
                    $this->load->view('templates/header', $data);
                    $this->load->view('data_visa/visa_all_filter211', $data);
                    $this->load->view('templates/footer');
                }
            }
        }
    }

    public function delete_visa211($id_penghubung)
    {
        $data_visa = $this->Data_Visa_Model->getDataPenghubungvisa211($id_penghubung);
        $id_visa = $data_visa['id_jenis_visa'];
        $this->Data_Visa_Model->DeleteVisa211($id_penghubung);
        $this->session->set_flashdata('flash', 'Visa Berhasil Dihapus');
        redirect("Data_Visa/visa211/$id_visa");
    }
    public function delete_visa312($id_penghubung)
    {
        $data_visa = $this->Data_Visa_Model->getDataPenghubungvisa312($id_penghubung);
        $id_visa = $data_visa['id_jenis_visa'];
        $jabatan = $this->Rptka_Model->getJabatanById($data_visa['id_jabatan']);
        $jabatan_terpakai = $jabatan['terpakai'] - 1;
        $this->Rptka_Model->editJabatanRptkaVisa($data_visa['id_jabatan'], $jabatan_terpakai);
        $rptka = $this->Rptka_Model->getRptkaById($data_visa['id_rptka']);
        $terpakai = $rptka['jumlah_terpakai'] - 1;
        $this->Rptka_Model->editTerpakaiRptka($data_visa['id_rptka'], $terpakai);
        $this->Data_Visa_Model->DeleteVisa312($id_penghubung);
        $this->session->set_flashdata('flash', 'Visa Berhasil Dihapus');
        redirect("Data_Visa/visa312/$id_visa");
    }

    public function visa312($id_visa)
    {
        $this->form_validation->set_rules('dari', 'Dari', 'trim|required');
        $this->form_validation->set_rules('sampai', 'Sampai', 'trim|required');
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');
        $data['judul'] = 'Data Visa';
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->form_validation->run() == FALSE) {
            $data['data_pengguna_visa'] = $this->Data_Visa_Model->getAllVisa312($id_visa);
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/data_visa312', $data);
            $this->load->view('templates/footer');
        } else {
            $data['dari'] = strtotime($this->input->post('dari'));
            $data['sampai'] = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
            $id_pt = $this->input->post('nama_pt');
            $data['data_pengguna_visa'] = $this->Data_Visa_Model->getAllVisa312Filter($id_visa, $id_pt);
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/data_visa312', $data);
            $this->load->view('templates/footer');
        }
    }

    public function filter_tka_visa211($id_visa)
    {

        $data['judul'] = 'Data Visa';
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->input->post('nama_pt')) {
            if (($data['data_jenis_visa']['id_visa_sebelumnya'] == 1) or ($data['data_jenis_visa']['id_visa_sebelumnya'] == 2)) {
                $data['id_tenaga'] = $this->Tka_Model->getTkaIdByPt($this->input->post('nama_pt'));
                $data['jalan_pintas'] = null;
                $data['check_pt'] = $this->input->post('nama_pt');
            } else {
                $data['visa_sebelumnya'] = $this->Jenis_Visa_Model->getJenisVisaById($data['data_jenis_visa']['id_visa_sebelumnya']);
                $data['id_tenaga'] = $this->Data_Visa_Model->getVisa211Sebelumnya($data['visa_sebelumnya']['id']);
                $data['jalan_pintas'] = 1;
                $data['check_pt'] = $this->input->post('nama_pt');
            }
        } else {
            if (($data['data_jenis_visa']['id_visa_sebelumnya'] == 1) or ($data['data_jenis_visa']['id_visa_sebelumnya'] == 2)) {
                $data['id_tenaga'] = $this->Tka_Model->getTkaIdPt();
                $data['jalan_pintas'] = null;
                $data['check_pt'] = null;
            } else {
                $data['visa_sebelumnya'] = $this->Jenis_Visa_Model->getJenisVisaById($data['data_jenis_visa']['id_visa_sebelumnya']);
                $data['id_tenaga'] = $this->Data_Visa_Model->getVisa211Sebelumnya($data['visa_sebelumnya']['id']);
                $data['jalan_pintas'] = 1;
                $data['check_pt'] = null;
            }
        }
        $this->load->view('templates/header', $data);
        $this->load->view('data_visa/data_visa211_filter', $data);
        $this->load->view('templates/footer');
    }
    public function edit_visa211($id_visa)
    {
        $data['judul'] = 'Data Visa';
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
        $data['subjudul'] = $data['data_jenis_visa']['visa'];
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_visa/data_visa211_form', $data);
        $this->load->view('templates/footer');
    }
    public function spesifik_visa211($id_penghubung_visa)
    {
        $data['data_penghubung_visa'] = $this->Data_Visa_Model->getvisa211($id_penghubung_visa);
        $data['data_tka'] = $this->Data_Visa_Model->getTka($data['data_penghubung_visa']['id_tka']);
        $data['data_visa'] = $this->Data_Visa_Model->getdatavisa211($id_penghubung_visa);
        $data['judul'] = 'Data Visa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_visa/spesifik_visa211', $data);
        $this->load->view('templates/footer');
    }
    public function spesifik_visa312($id_penghubung_visa)
    {
        $data['data_penghubung_visa'] = $this->Data_Visa_Model->getvisa312($id_penghubung_visa);
        $data['data_tka'] = $this->Data_Visa_Model->getTka($data['data_penghubung_visa']['id_tka']);
        $data['data_visa'] = $this->Data_Visa_Model->getdatavisa312($id_penghubung_visa);
        $data['judul'] = 'Data Visa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_visa/spesifik_visa312', $data);
        $this->load->view('templates/footer');
    }
    public function tambah_visa211()
    {
        $this->form_validation->set_rules('tgl_awal', 'Nama Mandarin', 'required');
        $this->form_validation->set_rules('tgl_expired', 'Nama Latin', 'required');
        $this->form_validation->set_rules('ket', 'Kewarganegaraan', 'trim|required');
        $id_tka = $this->input->post('id_tka');
        $id_visa = $this->input->post('id_visa');
        $data['ket_visa'] = 'tambah';
        $data['data_visa'] = null;
        $data['data_tka'] = $this->Tka_Model->getTkaById($id_tka);
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
        $data['subjudul'] = "Tambah Data " . $data['data_jenis_visa']['visa'];
        $data['judul'] = 'Data Visa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['button'] = 'Tambahkan Data Visa';
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/data_visa211_form', $data);
            $this->load->view('templates/footer');
        } else {
            if (($data['data_jenis_visa']['id_visa_sebelumnya'] == 1) or ($data['data_jenis_visa']['id_visa_sebelumnya'] == 2)) {
                $this->Data_Visa_Model->tambahPenghubungVisa211();
                $id_penghubung = $this->Data_Visa_Model->getPenghubungVisa211();
                $this->Data_Visa_Model->tambahVisa211($id_penghubung['id_penghubung_visa211']);
                $this->session->set_flashdata('flash', 'Visa Berhasil Ditambahkan');
                redirect("Data_Visa/visa211/$id_visa");
            } else {
                $this->Data_Visa_Model->tambahPenghubungVisa211();
                $id_penghubung = $this->Data_Visa_Model->getPenghubungVisa211();
                $id_penghubung_sebelumnya = $this->Data_Visa_Model->getPenghubungVisa211sebelumnya($data['data_jenis_visa']['id_visa_sebelumnya'], $id_tka);
                $this->Data_Visa_Model->updatePenghubungVisa211($id_penghubung_sebelumnya['id_penghubung_visa211']);
                $this->Data_Visa_Model->tambahVisa211($id_penghubung['id_penghubung_visa211']);
                $this->session->set_flashdata('flash', 'Visa Berhasil Ditambahkan');
                redirect("Data_Visa/visa211/$id_visa");
            }
        }
    }
    public function edit_data_visa211($id_penghubung)
    {
        $data['ket_visa'] = 'edit';
        $data['data_visa'] = $this->Data_Visa_Model->getdatavisa211($id_penghubung);
        $data['data_penghubung'] = $this->Data_Visa_Model->getDataPenghubungvisa211($id_penghubung);
        $data['data_tka'] = $this->Tka_Model->getTkaById($data['data_penghubung']['id_tka']);
        $id_visa = $data['data_penghubung']['id_jenis_visa'];
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($id_visa);
        $data['subjudul'] = "Edit Data " . $data['data_jenis_visa']['visa'];
        $data['judul'] = 'Data Visa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['button'] = 'Simpan Edit Data Visa';
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal', 'required');
        $this->form_validation->set_rules('tgl_expired', 'Tanggal Expired', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/data_visa211_form', $data);
            $this->load->view('templates/footer');
        } else {
            $id_data_visa = $data['data_visa']['id'];
            $this->Data_Visa_Model->editVisa211($id_data_visa);
            $this->session->set_flashdata('flash', 'Visa Berhasil Diubah');
            redirect("Data_Visa/spesifik_visa211/$id_penghubung");
        }
    }

    public function edit_data_visa312($id_penghubung)
    {
        $data['data_penghubung'] = $this->Data_Visa_Model->getDataPenghubungvisa312($id_penghubung);
        $id_pt = $data['data_penghubung']['id_pt'];
        $data = array(
            'data_rptka' => $this->Rptka_Model->getRptkaByPt($id_pt),
            'data_jabatan' => $this->Rptka_Model->getJabtanPilihan(),
        );
        $this->form_validation->set_rules('no_rptka', 'No RPTKA', 'trim|required');
        $this->form_validation->set_rules('jabatan_rptka', 'Jabatan RPTKA', 'trim|required');
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal Visa', 'trim|required');
        $this->form_validation->set_rules('waktu_visa', 'Jangka Waktu visa (Bulan)', 'trim|required');
        $this->form_validation->set_rules('tgl_expired', 'Tanggal Expired', 'trim|required');
        $this->form_validation->set_rules('no_kitas', 'No KITAS', 'trim|required');
        $this->form_validation->set_rules('no_notifikasi', 'No Notifikasi', 'trim|required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
        $data['ket_visa'] = 'edit';
        $data['data_penghubung'] = $this->Data_Visa_Model->getDataPenghubungvisa312($id_penghubung);
        $data['data_visa'] = $this->Data_Visa_Model->getdatavisa312($id_penghubung);
        $data['data_tka'] = $this->Tka_Model->getTkaById($data['data_penghubung']['id_tka']);
        $data['data_jenis_visa'] = $this->Jenis_Visa_Model->getJenisVisaById($data['data_penghubung']['id_jenis_visa']);
        $data['subjudul'] = "Edit Data " . $data['data_jenis_visa']['visa'];
        $data['judul'] = 'Data Visa';
        $data['button'] = 'Simpan Edit Data Visa';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('data_visa/data_visa312_form', $data);
            $this->load->view('templates/footer');
        } else {
            $jabatan = $this->Rptka_Model->getJabatanById($this->input->post('jabatan_rptka'));
            $jabatan_terpakai = $jabatan['terpakai'] + 1;
            $this->Rptka_Model->editJabatanRptkaVisa($this->input->post('jabatan_rptka'), $jabatan_terpakai);
            $jabatan_kurang = $this->Rptka_Model->getJabatanById($data['data_penghubung']['id_jabatan']);
            $jabatan_dikurang = $jabatan_kurang['terpakai'] - 1;
            $this->Rptka_Model->editJabatanRptkaVisa($data['data_penghubung']['id_jabatan'], $jabatan_dikurang);
            $rptka_kurang = $this->Rptka_Model->getRptkaById($data['data_penghubung']['id_rptka']);
            $dikurang = $rptka_kurang['jumlah_terpakai'] - 1;
            $this->Rptka_Model->editTerpakaiRptka($data['data_penghubung']['id_rptka'], $dikurang);
            $rptka = $this->Rptka_Model->getRptkaById($this->input->post('no_rptka'));
            $terpakai = $rptka['jumlah_terpakai'] + 1;
            $this->Rptka_Model->editTerpakaiRptka($this->input->post('no_rptka'), $terpakai);
            $this->Data_Visa_Model->editRptkaPenghubungVisa312($id_penghubung);
            $this->Data_Visa_Model->editVisa312($id_penghubung);
            $this->session->set_flashdata('flash', 'Visa Berhasil Diubah');
            redirect("Data_Visa/spesifik_visa312/$id_penghubung");
        }
    }
}
