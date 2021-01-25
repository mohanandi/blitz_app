<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_Model extends CI_Model
{
    public function jumlahRptka($dari = null, $standard_sampai = null, $id_pt = null)
    {
        if ($id_pt == null) {
            $this->db->select('id');
            $this->db->from('rptka');
            $query = $this->db->get();
            return $query->num_rows();
        } elseif ($id_pt = 'Semua Perusahaan') {
            $sampai = $standard_sampai + (60 * 60 * 24);
            $this->db->select('id');
            $this->db->from('rptka');
            $this->db->where('tgl_input >=', $dari);
            $this->db->where('tgl_input <=', $sampai);
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            $sampai = $standard_sampai + (60 * 60 * 24);
            $this->db->select('id');
            $this->db->from('rptka');
            $this->db->where('tgl_input >=', $dari);
            $this->db->where('tgl_input <=', $sampai);
            $this->db->where('id_pt', $id_pt);
            $query = $this->db->get();
            return $query->num_rows();
        }
    }
    public function getDataJenisVisa()
    {
        $this->db->order_by('visa', 'ASC');
        $this->db->select('*');
        $this->db->from('jenis_visa');
        $this->db->where('id !=', 1);
        $this->db->where('id !=', 2);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getPt()
    {
        $this->db->order_by('nama_pt', 'ASC');
        $this->db->select(array('id', 'nama_pt'));
        $this->db->from('pt');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getData($id_visa)
    {
        $query = $this->db->from('penghubung_visa211')
            ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
            ->where('penghubung_visa211.id_jenis_visa', $id_visa)
            ->where('penghubung_visa211.status', 'Aktif')
            ->where('visa_211.tgl_expired >=', time())
            ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 7)))
            ->get()
            ->num_rows();
        return $query;
        // $this->db->select('*');
        // $this->db->from('anggota');
        // $this->db->join('simpanan', 'anggota.id_anggota = simpanan.id_anggota', 'LEFT');
        // $this->db->join('unit', 'anggota.id_unit = unit.id_unit', 'LEFT');
        // $query = $this->db->get();
    }
    public function getExpiredData($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa211', 'id_tka', 'id_pt'))
            ->from('penghubung_visa211')
            ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
            ->where('penghubung_visa211.id_jenis_visa', $id_visa)
            ->where('penghubung_visa211.status', 'Aktif')
            ->where('visa_211.tgl_expired <', time())
            ->get()
            ->result_array();
        return $query;
    }
    public function getSemingguData($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa211', 'id_tka', 'id_pt'))
            ->from('penghubung_visa211')
            ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
            ->where('penghubung_visa211.id_jenis_visa', $id_visa)
            ->where('penghubung_visa211.status', 'Aktif')
            ->where('visa_211.tgl_expired >=', time())
            ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 7)))
            ->get()
            ->result_array();
        return $query;
    }
    public function getDuamingguData($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa211', 'id_tka', 'id_pt'))
            ->from('penghubung_visa211')
            ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
            ->where('penghubung_visa211.id_jenis_visa', $id_visa)
            ->where('penghubung_visa211.status', 'Aktif')
            ->where('visa_211.tgl_expired >=', time())
            ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 14)))
            ->get()
            ->result_array();
        return $query;
    }
    public function getTigamingguData($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa211', 'id_tka', 'id_pt'))
            ->from('penghubung_visa211')
            ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
            ->where('penghubung_visa211.id_jenis_visa', $id_visa)
            ->where('penghubung_visa211.status', 'Aktif')
            ->where('visa_211.tgl_expired >=', time())
            ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 21)))
            ->get()
            ->result_array();
        return $query;
    }
    public function getTSebulanData($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa211', 'id_tka', 'id_pt'))
            ->from('penghubung_visa211')
            ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
            ->where('penghubung_visa211.id_jenis_visa', $id_visa)
            ->where('penghubung_visa211.status', 'Aktif')
            ->where('visa_211.tgl_expired >=', time())
            ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 30)))
            ->get()
            ->result_array();
        return $query;
    }

    public function getExpiredVisa312($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa312', 'id_tka', 'id_pt', 'id_rptka', 'id_jabatan', 'status'))
            ->from('penghubung_visa312')
            ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
            ->where('penghubung_visa312.id_jenis_visa', $id_visa)
            ->where('penghubung_visa312.status', 'Aktif')
            ->where('visa_312.tgl_expired <', time())
            ->get()
            ->result_array();
        return $query;
    }
    public function getSemingguVisa312($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa312', 'id_tka', 'id_pt', 'id_rptka', 'id_jabatan', 'status'))
            ->from('penghubung_visa312')
            ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
            ->where('penghubung_visa312.id_jenis_visa', $id_visa)
            ->where('penghubung_visa312.status', 'Aktif')
            ->where('visa_312.tgl_expired >=', time())
            ->where('visa_312.tgl_expired <=', (time() + (60 * 60 * 24 * 7)))
            ->get()
            ->result_array();
        return $query;
    }
    public function getDuamingguVisa312($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa312', 'id_tka', 'id_pt', 'id_rptka', 'id_jabatan', 'status'))
            ->from('penghubung_visa312')
            ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
            ->where('penghubung_visa312.id_jenis_visa', $id_visa)
            ->where('penghubung_visa312.status', 'Aktif')
            ->where('visa_312.tgl_expired >=', time())
            ->where('visa_312.tgl_expired <=', (time() + (60 * 60 * 24 * 14)))
            ->get()
            ->result_array();
        return $query;
    }
    public function getTigamingguVisa312($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa312', 'id_tka', 'id_pt', 'id_rptka', 'id_jabatan', 'status'))
            ->from('penghubung_visa312')
            ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
            ->where('penghubung_visa312.id_jenis_visa', $id_visa)
            ->where('penghubung_visa312.status', 'Aktif')
            ->where('visa_312.tgl_expired >=', time())
            ->where('visa_312.tgl_expired <=', (time() + (60 * 60 * 24 * 14)))
            ->get()
            ->result_array();
        return $query;
    }
    public function getSebulanVisa312($id_visa)
    {
        $query = $this->db->select(array('id_penghubung_visa312', 'id_tka', 'id_pt', 'id_rptka', 'id_jabatan', 'status'))
            ->from('penghubung_visa312')
            ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
            ->where('penghubung_visa312.id_jenis_visa', $id_visa)
            ->where('penghubung_visa312.status', 'Aktif')
            ->where('visa_312.tgl_expired >=', time())
            ->where('visa_312.tgl_expired <=', (time() + (60 * 60 * 24 * 14)))
            ->get()
            ->result_array();
        return $query;
    }
    public function jumlahTka()
    {
        $this->db->select('id');
        $this->db->from('tka');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function jumlahPt()
    {
        $this->db->select('id');
        $this->db->from('pt');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function jumlahVoucher()
    {
        $this->db->select('id_voucher');
        $this->db->from('voucher_visa');
        $query = $this->db->get();
        $voucher_visa = $query->num_rows();
        $this->db->select('id_voucher');
        $this->db->from('voucher_entertaint');
        $query = $this->db->get();
        $voucher_entertaint = $query->num_rows();
        $total_voucher = $voucher_visa + $voucher_entertaint;
        return $total_voucher;
    }

    public function getJenisProses()
    {
        return $this->db->get('jenis_proses')->result();
    }
    public function getJenisVisa($id_visa)
    {
        return $this->db->get_where('jenis_visa', ['id' => $id_visa])->row_array();
    }
    public function getPenghubungVisa211($id_visa)
    {
        return $this->db->get_where('penghubung_visa211', ['id_jenis_visa' => $id_visa, 'status' => 'Aktif'])->result_array();
    }
    public function getPenghubungVisa312($id_visa)
    {
        return $this->db->get_where('penghubung_visa312', ['id_jenis_visa' => $id_visa, 'status' => 'Aktif'])->result_array();
    }

    // Untuk mendapatkan pilihan Jabatan
    public function getLokasi()
    {
        $this->db->join('jenis_proses', 'harga.id_proses = jenis_proses.id_proses');
        return $this->db->get('harga')->result();
    }
    public function getPenghubungVisa211ById($id_penghubung)
    {
        return $this->db->get_where('penghubung_visa211', ['id_penghubung_visa211' => $id_penghubung])->row_array();
    }
    public function getPenghubungVisa312ById($id_penghubung)
    {
        return $this->db->get_where('penghubung_visa312', ['id_penghubung_visa312' => $id_penghubung])->row_array();
    }

    public function nonaktif211($id_penghubung)
    {
        $data = [
            "status" => 'Non-Aktif'
        ];
        $this->db->where('id_penghubung_visa211', $id_penghubung);
        $this->db->update('penghubung_visa211', $data);
    }
    public function nonaktif312($id_penghubung)
    {
        $data = [
            "status" => 'Non-Aktif'
        ];
        $this->db->where('id_penghubung_visa312', $id_penghubung);
        $this->db->update('penghubung_visa312', $data);
    }
}
