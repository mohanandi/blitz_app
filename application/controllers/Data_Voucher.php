<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Data_Voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Data_Voucher_Model');
        $this->load->model('DataPt_Model');
        $this->load->model('Jenis_Voucher_Model');
        is_logged_in();
    }
    public function index()
    {
        $this->form_validation->set_rules('dari', 'Dari', 'trim|required');
        $this->form_validation->set_rules('sampai', 'Sampai', 'trim|required');
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['data_id_voucher'] = $this->Data_Voucher_Model->getVoucherVisa();
            $data['data_id_voucher_entertaint'] = $this->Data_Voucher_Model->getVoucherEntertaint();
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['judul'] = 'Data Voucher';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/data_voucher', $data);
            $this->load->view('templates/footer');
        } else {
            $dari = strtotime($this->input->post('dari'));
            $sampai = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
            $id_pt = $this->input->post('nama_pt');
            $data['data_id_voucher'] = $this->Data_Voucher_Model->getVoucherVisaFilter($id_pt, $dari, $sampai);
            $data['data_id_voucher_entertaint'] = $this->Data_Voucher_Model->getVoucherEntertaintFilter($id_pt, $dari, $sampai);
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['judul'] = 'Data Voucher';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/data_voucher', $data);
            $this->load->view('templates/footer');
        }
    }
    public function report()
    {
        $data['data_id_voucher'] = $this->Data_Voucher_Model->getVoucherVisa();
        $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
        $data['judul'] = 'Data Voucher';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_voucher/data_voucher_report', $data);
        $this->load->view('templates/footer');
    }
    public function detail($id_voucher)
    {
        $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherVisaById($id_voucher);
        $data['data_pengguna_voucher'] = $this->Data_Voucher_Model->getPenggunaVoucherVisa($id_voucher);
        $data['judul'] = 'Data Voucher';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_voucher/data_vouchervisa_detail', $data);
        $this->load->view('templates/footer');
    }
    public function kategori()
    {
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');
        $this->form_validation->set_rules('nama_client', 'Nama Client', 'trim|required');
        $this->form_validation->set_rules('bill_to', 'Bill To', 'trim|required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
        $this->form_validation->set_rules('mata_uang', 'Mata Uang', 'trim|required');
        if ($this->input->post('kategori') == 1) {
            $this->form_validation->set_rules('jenis_proses', 'Jenis Proses', 'trim|required');
            $this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required');
        } else {
            $this->form_validation->set_rules('lokasi_entertaint', 'Lokasi', 'trim|required');
        }
        $this->form_validation->set_rules('staff', 'Staff OP', 'trim|required');
        $this->form_validation->set_rules('note', 'Note', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'data_jenis_proses' => $this->Data_Voucher_Model->getJenisProses(),
                'data_lokasi' => $this->Data_Voucher_Model->getLokasi()
            );
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['data_voucher'] = null;
            $data['kategori_batas'] = null;
            $data['judul'] = 'Data Voucher';
            $data['subjudul'] = 'Input Voucher';
            $data['button'] = 'Buat Voucher';
            $data['dirubah'] = 'yes';
            $data['data_kategori'] = $this->Data_Voucher_Model->getKategori();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/kategori_form', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->input->post('kategori') == 1) {
                $kode = $this->Data_Voucher_Model->getKodeVoucher();
                $this->Data_Voucher_Model->tambahVoucherVisa($kode);
                $data_voucher = $this->Data_Voucher_Model->getLastKode();
                $id_voucher = $data_voucher['id_voucher'];
                $this->session->set_flashdata('flash', 'Voucher Berhasil Dibuat');
                redirect("Data_Voucher/detail/$id_voucher");
            } else {
                $kode = $this->Data_Voucher_Model->getKodeVoucherEntertaint();
                $this->Data_Voucher_Model->tambahVoucherEntertaint($kode);
                $data_voucher = $this->Data_Voucher_Model->getLastKodeEntertaint();
                $id_voucher = $data_voucher['id_voucher'];
                redirect("Data_Voucher/detail_entertaint/$id_voucher");
            }
        }
    }

    public function detail_entertaint($id_voucher)
    {
        $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherEntertaintById($id_voucher);
        $data['data_pengguna_voucher'] = $this->Data_Voucher_Model->getPenggunaVoucherEntertaint($id_voucher);
        $data['judul'] = 'Data Voucher';
        $data['button'] = 'Buat Voucher';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_voucher/entertaint_detail', $data);
        $this->load->view('templates/footer');
    }
    public function data_visa()
    {
        $data['judul'] = 'Data Voucher';
        $data['button'] = 'Buat Voucher';
        $data['id_pt'] = $this->input->post('nama_pt');
        $data['data_tka'] = $this->Data_Voucher_Model->getTkaIdByPt($this->input->post('nama_pt'));
        $data['nama_client'] = $this->input->post('nama_client');
        $data['id_kategori'] = $this->input->post('kategori');
        $data['id_jenis_proses'] = $this->input->post('jenis_proses');
        $data['lokasi'] = $this->input->post('lokasi');
        $data['mata_uang'] = $this->input->post('mata_uang');
        $data['staff'] = $this->input->post('staff');
        $data['note'] = $this->input->post('note');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('data_voucher/data_visa', $data);
        $this->load->view('templates/footer');
    }
    public function tambah_voucher_entertaint($id_voucher)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim');
        $this->form_validation->set_rules('jenis_proses', 'Jenis Proses', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $data['data_pengguna_voucher'] = null;

        if ($this->form_validation->run() == FALSE) {
            $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherEntertaintById($id_voucher);
            $data['judul'] = 'Data Voucher';
            $data['subjudul'] = 'Tambah Data Voucher';
            $data['button'] = 'Tambahkan Data Voucher';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/entertaint_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Data_Voucher_Model->tambahDataVoucherEntertaint();
            $voucher = $this->Data_Voucher_Model->getVoucherEntertaintById($this->input->post('id_voucher'));
            $total_harga = $voucher['total_harga'] + $this->input->post('harga');
            $jumlah_data = $voucher['jumlah_data'] + 1;
            $this->Data_Voucher_Model->updateDataEntertaint($total_harga, $jumlah_data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect("Data_Voucher/detail_entertaint/$id_voucher");
        }
    }

    public function tambahtkavisa()
    {
        $this->form_validation->set_rules('total', 'Total Harga', 'trim|required');
        $this->form_validation->set_rules('harga[]', 'Harga', 'trim|required');
        $data['id_tka'] = $this->input->post('data_tka[]');

        $id_voucher = $this->input->post('id_voucher');
        $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherVisaById($id_voucher);
        $data['data_pengguna_voucher'] = $this->Data_Voucher_Model->getPenggunaVoucherVisa($id_voucher);
        $data['judul'] = 'Data Voucher';
        $data['button'] = 'Tambahkan Data Voucher';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/visa_form', $data);
            $this->load->view('templates/footer');
        } else {
            $jumlah_data = count($data['data_pengguna_voucher']) + count($this->input->post('harga[]'));
            $this->Data_Voucher_Model->tambahPenggunaVoucherVisa($id_voucher);
            $this->Data_Voucher_Model->updateDataVisa($this->input->post('total'), $jumlah_data, $id_voucher);
            $this->session->set_flashdata('flash', 'Voucher Berhasil Dibuat');
            redirect("Data_Voucher/detail/$id_voucher");
        }
    }
    public function tambah_data_voucher_visa($id_voucher)
    {
        $data['judul'] = 'Data Voucher';
        $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherVisaById($id_voucher);
        $data['data_pengguna_voucher'] = $this->Data_Voucher_Model->getPenggunaVoucherVisa($id_voucher);
        $data['data_tka'] = $this->Data_Voucher_Model->getTkaIdByPt($data['data_voucher']['id_pt']);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/tambah_data_visa_form', $data);
            $this->load->view('templates/footer');
        } else {
            $kode = $this->Data_Voucher_Model->getKodeVoucher();
            $this->Data_Voucher_Model->tambahVoucherVisa($kode);
            $id_voucher = $this->Data_Voucher_Model->getLastKode();
            $id = $id_voucher['id_voucher'];
            $this->Data_Voucher_Model->tambahPenggunaVoucherVisa($id_voucher['id_voucher']);
            $this->session->set_flashdata('flash', 'Voucher Berhasil Dibuat');
            redirect("Data_Voucher/detail/$id");
        }
    }

    public function delete_entertaint($id_voucher)
    {
        $data['id_pengguna'] = $this->Data_Voucher_Model->getTkaEntertaint($id_voucher);
        foreach ($data['id_pengguna'] as $pengguna) :
            $this->Data_Voucher_Model->hapusDataPenggunaEntertaint($pengguna['id_pengguna_voucher_entertaint']);
        endforeach;
        $this->Data_Voucher_Model->hapusVoucherEntertaint($id_voucher);
        $this->session->set_flashdata('flash', 'Voucher Berhasil Dihapus');
        redirect("Data_Voucher");
    }

    public function delete_visa($id_voucher)
    {
        $data['id_pengguna'] = $this->Data_Voucher_Model->getTkaVisa($id_voucher);
        foreach ($data['id_pengguna'] as $pengguna) :
            $this->Data_Voucher_Model->hapusDataPenggunaVisa($pengguna['id_pengguna_voucher']);
        endforeach;
        $this->Data_Voucher_Model->hapusVoucherVisa($id_voucher);
        $this->session->set_flashdata('flash', 'Voucher Berhasil Dihapus');
        redirect("Data_Voucher");
    }

    public function delete_data_entertaint($id_pengguna)
    {
        $data_voucher = $this->Data_Voucher_Model->getIdVoucherEntertaint($id_pengguna);
        $id_voucher = $data_voucher['id_voucher_entertaint'];
        $this->Data_Voucher_Model->hapusDataPenggunaEntertaint($id_pengguna);
        $data = $this->Data_Voucher_Model->getHargaVoucherEntertaint($id_voucher);
        $total_harga = 0;
        foreach ($data as $d) :
            $total_harga += $d['harga'];
        endforeach;
        $jumlah_data = count($data);;
        $this->Data_Voucher_Model->ubahDataEntertaint($total_harga, $jumlah_data, $id_voucher);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect("Data_Voucher/detail_entertaint/$id_voucher");
    }
    public function delete_data_visa($id_pengguna)
    {
        $data_voucher = $this->Data_Voucher_Model->getIdVoucherVisa($id_pengguna);
        $id_voucher = $data_voucher['id_voucher_visa'];
        $this->Data_Voucher_Model->hapusDataPenggunaVisa($id_pengguna);
        $data = $this->Data_Voucher_Model->getHargaVoucherVisa($id_voucher);
        $total_harga = 0;
        foreach ($data as $d) :
            $total_harga += $d['harga'];
        endforeach;
        $jumlah_data = count($data);
        $this->Data_Voucher_Model->updateDataVisa($total_harga, $jumlah_data, $id_voucher);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect("Data_Voucher/detail/$id_voucher");
    }
    public function ubah_data_entertaint($id_pengguna)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim');
        $this->form_validation->set_rules('jenis_proses', 'Jenis Proses', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');

        $data['data_pengguna_voucher'] = $this->Data_Voucher_Model->getPenggunaVoucherEntertaintById($id_pengguna);
        $id_voucher = $data['data_pengguna_voucher']['id_voucher_entertaint'];
        if ($this->form_validation->run() == FALSE) {
            $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherEntertaintById($id_voucher);
            $data['judul'] = 'Data Voucher';
            $data['subjudul'] = 'Edit Data Voucher';
            $data['button'] = 'Simpan Edit Data Voucher';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/entertaint_form', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Data_Voucher_Model->ubahDataPenggunaVoucherEntertaint($id_pengguna);
            $data = $this->Data_Voucher_Model->getHargaVoucherEntertaint($id_voucher);
            $total_harga = 0;
            foreach ($data as $d) :
                $total_harga += $d['harga'];
            endforeach;
            $jumlah_data = count($data);;
            $this->Data_Voucher_Model->ubahDataEntertaint($total_harga, $jumlah_data, $id_voucher);
            $this->session->set_flashdata('flash', 'Dirubah');
            redirect("Data_Voucher/detail_entertaint/$id_voucher");
        }
    }

    public function edit_kategori_visa($id_voucher)
    {
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');
        $this->form_validation->set_rules('nama_client', 'Nama Client', 'trim|required');
        $this->form_validation->set_rules('bill_to', 'Bill To', 'trim|required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
        $this->form_validation->set_rules('mata_uang', 'Mata Uang', 'trim|required');
        if ($this->input->post('kategori') == 1) {
            $this->form_validation->set_rules('jenis_proses', 'Jenis Proses', 'trim|required');
            $this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required');
        } else {
            $this->form_validation->set_rules('lokasi_entertaint', 'Lokasi', 'trim|required');
        }
        $this->form_validation->set_rules('staff', 'Staff OP', 'trim|required');
        $this->form_validation->set_rules('note', 'Note', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'data_jenis_proses' => $this->Data_Voucher_Model->getJenisProses(),
                'data_lokasi' => $this->Data_Voucher_Model->getLokasi()
            );
            $data['pengguna_voucher'] = $this->Data_Voucher_Model->getPenggunaVoucherVisa($id_voucher);
            if ($data['pengguna_voucher'] == null) {
                $data['dirubah'] = 'yes';
            } else {
                $data['dirubah'] = 'no';
            }
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherVisaById($id_voucher);
            $data['judul'] = 'Data Voucher';
            $data['subjudul'] = 'Edit Voucher';
            $data['button'] = 'Edit Voucher';
            $data['kategori_batas'] = 'visa';
            $data['data_kategori'] = $this->Data_Voucher_Model->getKategori();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/kategori_form', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->input->post('dirubah') == 'yes') {
                if ($this->input->post('kategori') == 1) {
                    $this->Data_Voucher_Model->ubahVoucherVisa($id_voucher);
                    $this->session->set_flashdata('flash', 'Voucher Berhasil Diubah');
                    redirect("Data_Voucher/detail/$id_voucher");
                } else {
                    $this->Data_Voucher_Model->hapusVoucherVisa($id_voucher);
                    $kode = $this->Data_Voucher_Model->getKodeVoucherEntertaint();
                    $this->Data_Voucher_Model->tambahVoucherEntertaint($kode);
                    $data_voucher = $this->Data_Voucher_Model->getLastKodeEntertaint();
                    $id_voucher = $data_voucher['id_voucher'];
                    $this->session->set_flashdata('flash', 'Voucher Berhasil Diubah');
                    redirect("Data_Voucher/detail_entertaint/$id_voucher");
                }
            } else {
                $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherVisaById($id_voucher);
                if ($data['data_voucher']['id_jenis_proses'] == $this->input->post('jenis_proses')) {
                    if ($data['data_voucher']['id_lokasi'] == $this->input->post('lokasi')) {
                    } else {
                    }
                } else {
                }
                $this->Data_Voucher_Model->ubahVoucherVisa($id_voucher);
                $this->session->set_flashdata('flash', 'Voucher Berhasil Diubah');
                redirect("Data_Voucher/detail/$id_voucher");
            }
        }
    }

    public function edit_kategori_entertaint($id_voucher)
    {
        $this->form_validation->set_rules('nama_pt', 'Nama Perusahaan', 'trim|required');
        $this->form_validation->set_rules('nama_client', 'Nama Client', 'trim|required');
        $this->form_validation->set_rules('bill_to', 'Bill To', 'trim|required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
        $this->form_validation->set_rules('mata_uang', 'Mata Uang', 'trim|required');
        if ($this->input->post('kategori') == 1) {
            $this->form_validation->set_rules('jenis_proses', 'Jenis Proses', 'trim|required');
            $this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required');
        } else {
            $this->form_validation->set_rules('lokasi_entertaint', 'Lokasi', 'trim|required');
        }
        $this->form_validation->set_rules('staff', 'Staff OP', 'trim|required');
        $this->form_validation->set_rules('note', 'Note', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'data_jenis_proses' => $this->Data_Voucher_Model->getJenisProses(),
                'data_lokasi' => $this->Data_Voucher_Model->getLokasi()
            );
            $data['pengguna_voucher'] = $this->Data_Voucher_Model->getPenggunaVoucherEntertaint($id_voucher);
            if ($data['pengguna_voucher'] == null) {
                $data['dirubah'] = 'yes';
            } else {
                $data['dirubah'] = 'no';
            }
            $data['data_pt'] = $this->DataPt_Model->getAllDataPt();
            $data['data_voucher'] = $this->Data_Voucher_Model->getVoucherEntertaintById($id_voucher);
            $data['judul'] = 'Data Voucher';
            $data['subjudul'] = 'Edit Voucher';
            $data['button'] = 'Edit Voucher';
            $data['kategori_batas'] = 'entertaint';
            $data['data_kategori'] = $this->Data_Voucher_Model->getKategori();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('data_voucher/kategori_form', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->input->post('dirubah') == 'yes') {
                if ($this->input->post('kategori') == 1) {
                    $this->Data_Voucher_Model->hapusVoucherEntertaint($id_voucher);
                    $kode = $this->Data_Voucher_Model->getKodeVoucher();
                    $this->Data_Voucher_Model->tambahVoucherVisa($kode);
                    $data_voucher = $this->Data_Voucher_Model->getLastKode();
                    $id_voucher = $data_voucher['id_voucher'];
                    $this->session->set_flashdata('flash', 'Voucher Berhasil Diubah');
                    redirect("Data_Voucher/detail/$id_voucher");
                } else {
                    $this->Data_Voucher_Model->ubahVoucherEntertaint($id_voucher);
                    $this->session->set_flashdata('flash', 'Voucher Berhasil Diubah');
                    redirect("Data_Voucher/detail_entertaint/$id_voucher");
                }
            } else {
                $this->Data_Voucher_Model->ubahVoucherEntertaint($id_voucher);
                $this->session->set_flashdata('flash', 'Voucher Berhasil Diubah');
                redirect("Data_Voucher/detail_entertaint/$id_voucher");
            }
        }
    }
}
