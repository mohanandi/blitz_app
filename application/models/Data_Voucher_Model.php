<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Voucher_Model extends CI_Model
{
    public function getKategori()
    {
        return $this->db->get('kategori_voucher')->result_array();
    }
    public function getTkaIdByPt($id)
    {
        $this->db->select(array('id', 'passport', 'nama_mandarin', 'nama_latin'));
        $this->db->from('tka');
        $this->db->where('id_pt', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getVoucherVisa()
    {
        $this->db->select('id_voucher');
        $this->db->from('voucher_visa');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getHargaVoucherEntertaint($id_voucher)
    {
        $this->db->select('harga');
        $this->db->from('pengguna_voucher_entertaint');
        $this->db->where('id_voucher_entertaint', $id_voucher);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getHargaVoucherVisa($id_voucher)
    {
        $this->db->select('harga');
        $this->db->from('pengguna_voucher_visa');
        $this->db->where('id_voucher_visa', $id_voucher);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getIdVoucherEntertaint($id_pengguna)
    {
        $this->db->select('id_voucher_entertaint');
        $this->db->from('pengguna_voucher_entertaint');
        $query = $this->db->where('id_pengguna_voucher_entertaint', $id_pengguna);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getVoucherEntertaint()
    {
        $this->db->select('id_voucher');
        $this->db->from('voucher_entertaint');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getTkaEntertaint($id_voucher)
    {
        $this->db->select('id_pengguna_voucher_entertaint');
        $this->db->from('pengguna_voucher_entertaint');
        $query = $this->db->where('id_voucher_entertaint', $id_voucher);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getTkaVisa($id_voucher)
    {
        $this->db->select('id_pengguna_voucher');
        $this->db->from('pengguna_voucher_visa');
        $query = $this->db->where('id_voucher_visa', $id_voucher);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getVoucherVisaFilter($id_pt, $dari, $sampai)
    {
        $this->db->select('id_voucher');
        $this->db->from('voucher_visa');
        if ($id_pt == 'Semua Perusahaan') {
        } else {
            $this->db->where('id_pt', $id_pt);
        }
        $this->db->where('tgl_input >=', $dari);
        $this->db->where('tgl_input <=', $sampai);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getVoucherEntertaintFilter($id_pt, $dari, $sampai)
    {
        $this->db->select('id_voucher');
        $this->db->from('voucher_entertaint');
        if ($id_pt == 'Semua Perusahaan') {
        } else {
            $this->db->where('id_pt', $id_pt);
        }
        $this->db->where('tgl_input >=', $dari);
        $this->db->where('tgl_input <=', $sampai);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getPenggunaVoucherVisa($id_voucher)
    {
        return $this->db->get_where('pengguna_voucher_visa', ['id_voucher_visa' => $id_voucher])->result_array();
        // $this->db->select(array('id_tka', 'harga'));
        // $this->db->from('pengguna_voucher_visa');
        // $this->db->where('id_voucher_visa', $id_voucher);
        // $query = $this->db->get();
        // return $query->result_array();
    }
    public function getPenggunaVoucherEntertaint($id_voucher)
    {
        return $this->db->get_where('pengguna_voucher_entertaint', ['id_voucher_entertaint' => $id_voucher])->result_array();
    }
    public function getPenggunaVoucherEntertaintById($id_pengguna)
    {
        return $this->db->get_where('pengguna_voucher_entertaint', ['id_pengguna_voucher_entertaint' => $id_pengguna])->row_array();
    }
    public function getIdVoucherVisa($id_pengguna)
    {
        return $this->db->get_where('pengguna_voucher_visa', ['id_pengguna_voucher' => $id_pengguna])->row_array();
    }
    public function getVoucherVisaById($id_voucher)
    {
        return $this->db->get_where('voucher_visa', ['id_voucher' => $id_voucher])->row_array();
    }
    public function getVoucherEntertaintById($id_voucher)
    {
        return $this->db->get_where('voucher_entertaint', ['id_voucher' => $id_voucher])->row_array();
    }
    public function getJenisProses()
    {
        return $this->db->get('jenis_proses')->result();
    }

    // Untuk mendapatkan pilihan Jabatan
    public function getLokasi()
    {
        $this->db->join('jenis_proses', 'harga.id_proses = jenis_proses.id_proses');
        return $this->db->get('harga')->result();
    }

    public function tambahVoucherVisa($kode_voucher)
    {
        $data = [
            "kode_voucher" => $kode_voucher,
            "id_pt" => $this->input->post('nama_pt', true),
            "jumlah_data" => 0,
            "nama_client" => $this->input->post('nama_client', true),
            "bill_to" => $this->input->post('bill_to', true),
            "mata_uang" => $this->input->post('mata_uang', true),
            "total_harga" => 0,
            "kategori_id" => $this->input->post('kategori', true),
            "id_jenis_proses" => $this->input->post('jenis_proses', true),
            "id_lokasi" => $this->input->post('lokasi', true),
            "staff" => $this->input->post('staff', true),
            "note" => $this->input->post('note', true),
            "input_by_id" => $this->session->userdata('id'),
            "tgl_input" => time()
        ];
        $this->db->insert('voucher_visa', $data);
    }
    public function tambahDataVoucherEntertaint()
    {
        $data = [
            "id_voucher_entertaint" => $this->input->post('id_voucher', true),
            "nama" => $this->input->post('nama', true),
            "jenis_proses" => $this->input->post('jenis_proses', true),
            "harga" => $this->input->post('harga', true)
        ];
        $this->db->insert('pengguna_voucher_entertaint', $data);
    }

    public function updateDataEntertaint($total_harga, $jumlah_data)
    {
        $data = [
            "total_harga" => $total_harga,
            "jumlah_data" => $jumlah_data
        ];
        $this->db->where('id_voucher', $this->input->post('id_voucher'));
        $this->db->update('voucher_entertaint', $data);
    }
    public function updateDataVisa($total_harga, $jumlah_data, $id_voucher)
    {
        $data = [
            "total_harga" => $total_harga,
            "jumlah_data" => $jumlah_data
        ];
        $this->db->where('id_voucher', $id_voucher);
        $this->db->update('voucher_visa', $data);
    }

    public function ubahDataPenggunaVoucherEntertaint($id_pengguna)
    {
        $data = [
            "nama" => $this->input->post('nama'),
            "jenis_proses" => $this->input->post('jenis_proses'),
            "harga" => $this->input->post('harga')
        ];
        $this->db->where('id_pengguna_voucher_entertaint', $id_pengguna);
        $this->db->update('pengguna_voucher_entertaint', $data);
    }
    public function ubahDataEntertaint($total_harga, $jumlah_data, $id_voucher)
    {
        $data = [
            "total_harga" => $total_harga,
            "jumlah_data" => $jumlah_data
        ];
        $this->db->where('id_voucher', $id_voucher);
        $this->db->update('voucher_entertaint', $data);
    }

    public function tambahVoucherEntertaint($kode_voucher)
    {
        $data = [
            "kode_voucher" => $kode_voucher,
            "id_pt" => $this->input->post('nama_pt', true),
            "jumlah_data" => 0,
            "nama_client" => $this->input->post('nama_client', true),
            "bill_to" => $this->input->post('bill_to', true),
            "mata_uang" => $this->input->post('mata_uang', true),
            "total_harga" => 0,
            "kategori_id" => $this->input->post('kategori', true),
            "lokasi" => $this->input->post('lokasi_entertaint', true),
            "staff" => $this->input->post('staff', true),
            "note" => $this->input->post('note', true),
            "input_by_id" => $this->session->userdata('id'),
            "tgl_input" => time()
        ];
        $this->db->insert('voucher_entertaint', $data);
    }

    public function getKodeVoucher()
    {
        $last = $this->db->order_by('id_voucher', "desc")
            ->select('kode_voucher')
            ->limit(1)
            ->get('voucher_visa')
            ->row_array();
        if ($last) {
            $tanda_tgl = substr($last['kode_voucher'], 9, 6);
            if ($tanda_tgl == date('dmy', time())) {
                $no = substr($last['kode_voucher'], 16);
                $no++;
                $kode = 'VCR/VISA/' . date('dmy', time()) . '/' . $no;
            } else {
                $kode = 'VCR/VISA/' . date('dmy', time()) . '/' . '1';
            }
        } else {
            $kode = 'VCR/VISA/' . date('dmy', time()) . '/' . '1';
        }
        return $kode;
    }
    public function getKodeVoucherEntertaint()
    {
        $last = $this->db->order_by('id_voucher', "desc")
            ->select('kode_voucher')
            ->limit(1)
            ->get('voucher_entertaint')
            ->row_array();
        if ($last) {
            $tanda_tgl = substr($last['kode_voucher'], 15, 6);
            if ($tanda_tgl == date('dmy', time())) {
                $no = substr($last['kode_voucher'], 22);
                $no++;
                $kode = 'VCR/ENTERTAINT/' . date('dmy', time()) . '/' . $no;
            } else {
                $kode = 'VCR/ENTERTAINT/' . date('dmy', time()) . '/' . '1';
            }
        } else {
            $kode = 'VCR/ENTERTAINT/' . date('dmy', time()) . '/' . '1';
        }
        return $kode;
    }
    public function getLastKode()
    {
        $last = $this->db->order_by('id_voucher', "desc")
            ->select('id_voucher')
            ->limit(1)
            ->get('voucher_visa')
            ->row_array();
        return $last;
    }
    public function getLastKodeEntertaint()
    {
        $last = $this->db->order_by('id_voucher', "desc")
            ->select('id_voucher')
            ->limit(1)
            ->get('voucher_entertaint')
            ->row_array();
        return $last;
    }

    public function tambahPenggunaVoucherVisa($id_voucher)
    {
        for ($i = 0; $i < count($this->input->post('data_tka[]')); $i++) {
            $data = [
                "id_voucher_visa" => $id_voucher,
                "id_tka" => $this->input->post("data_tka[$i]", true),
                "harga" => $this->input->post("harga[$i]", true)
            ];
            $this->db->insert('pengguna_voucher_visa', $data);
        }
    }
    public function hapusDataPenggunaEntertaint($id_voucher_pengguna)
    {
        // $this->db->where('id', $id);
        $this->db->delete('pengguna_voucher_entertaint', ['id_pengguna_voucher_entertaint' => $id_voucher_pengguna]);
    }
    public function hapusDataPenggunaVisa($id_voucher_pengguna)
    {
        // $this->db->where('id', $id);
        $this->db->delete('pengguna_voucher_visa', ['id_pengguna_voucher' => $id_voucher_pengguna]);
    }

    public function hapusVoucherVisa($id_voucher)
    {
        // $this->db->where('id', $id);
        $this->db->delete('voucher_visa', ['id_voucher' => $id_voucher]);
    }
    public function hapusVoucherEntertaint($id_voucher)
    {
        // $this->db->where('id', $id);
        $this->db->delete('voucher_entertaint', ['id_voucher' => $id_voucher]);
    }

    public function ubahVoucherVisa($id_voucher)
    {
        $data = [
            "id_pt" => $this->input->post('nama_pt', true),
            "nama_client" => $this->input->post('nama_client', true),
            "bill_to" => $this->input->post('bill_to', true),
            "mata_uang" => $this->input->post('mata_uang', true),
            "id_jenis_proses" => $this->input->post('jenis_proses', true),
            "id_lokasi" => $this->input->post('lokasi', true),
            "staff" => $this->input->post('staff', true),
            "note" => $this->input->post('note', true)
        ];
        $this->db->where('id_voucher', $id_voucher);
        $this->db->update('voucher_visa', $data);
    }

    public function ubahVoucherEntertaint($id_voucher)
    {
        $data = [
            "id_pt" => $this->input->post('nama_pt', true),
            "nama_client" => $this->input->post('nama_client', true),
            "bill_to" => $this->input->post('bill_to', true),
            "mata_uang" => $this->input->post('mata_uang', true),
            "kategori_id" => $this->input->post('kategori', true),
            "lokasi" => $this->input->post('lokasi_entertaint', true),
            "staff" => $this->input->post('staff', true),
            "note" => $this->input->post('note', true)
        ];
        $this->db->where('id_voucher', $id_voucher);
        $this->db->update('voucher_entertaint', $data);
    }
}
