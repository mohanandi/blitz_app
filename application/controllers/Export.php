<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller
{
    public function export_voucher()
    {
        $dari = strtotime($this->input->post('dari'));
        $sampai = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
        $id_pt = $this->input->post('id_pt');

        $this->db->select('*');
        $this->db->from('voucher_visa');
        if ($id_pt == 'Semua Perusahaan') {
        } else {
            $this->db->where('id_pt', $id_pt);
        }
        $this->db->where('tgl_input >=', $dari);
        $this->db->where('tgl_input <=', $sampai);
        $query = $this->db->get();
        $data_voucher_visa = $query->result_array();

        $this->db->select('*');
        $this->db->from('voucher_entertaint');
        if ($id_pt == 'Semua Perusahaan') {
        } else {
            $this->db->where('id_pt', $id_pt);
        }
        $this->db->where('tgl_input >=', $dari);
        $this->db->where('tgl_input <=', $sampai);
        $query = $this->db->get();
        $data_voucher_entertaint = $query->result_array();

        $judul = "Report Voucher " . date('d-m-Y', $dari) . " - " . date('d-m-Y', $sampai);

        $spreadsheet = new Spreadsheet;

        // Settingan awal fil excel
        $spreadsheet->getProperties()->setCreator('')
            ->setLastModifiedBy('')
            ->setTitle("Voucher Other")
            ->setSubject("Voucher Other")
            ->setDescription("Report Voucher Other")
            ->setKeywords("Voucher Other");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        );

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "REPORT VOUCHER"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B3', "KODE VOUCHER"); // Set kolom B3 dengan tulisan "NIS"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C3', "NAMA PERUSAHAAN"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D3', "MATA UANG"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E3', "JUMLAH DATA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F3', "NAMA PENGGUNA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G3', "PASSPORT"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H3', "JENIS PROSES"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I3', "HARGA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('J3', "TOTAL HARGA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('K3', "TANGGAL INPUT VOUCHER"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);

        // Set height baris ke 1, 2 dan 3
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        $no = 1;
        foreach ($data_voucher_visa as $voucher_visa) :

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $voucher_visa['kode_voucher']);
            $data_pt = $this->db->get_where('pt', ['id' => $voucher_visa['id_pt']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data_pt['nama_pt']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $voucher_visa['mata_uang']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $voucher_visa['jumlah_data']);
            $data_pengguna_voucher_visa = $this->db->get_where('pengguna_voucher_visa', ['id_voucher_visa' => $voucher_visa['id_voucher']])->result_array();
            $numrow_data = $numrow;
            $contoh = 0;
            foreach ($data_pengguna_voucher_visa as $pengguna_voucher_visa) :
                $data_tka = $this->db->get_where('tka', ['id' => $pengguna_voucher_visa['id_tka']])->row_array();
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow_data, $data_tka['nama_latin']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $numrow_data, $data_tka['passport']);
                $jenis_proses = $this->db->get_where('jenis_proses', ['id_proses' => $voucher_visa['id_jenis_proses']])->row_array();
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $numrow_data, $jenis_proses['nama_proses']);
                if ($voucher_visa['mata_uang'] == "Rupiah") {
                    $result = "Rp " . number_format($pengguna_voucher_visa['harga'], 2, ',', '.');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $numrow_data, $result);
                } else {
                    $result = "$ " . number_format($pengguna_voucher_visa['harga'], 2, '.', ',');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $numrow_data, $result);
                }
                $numrow_data++;
                $contoh++;
            endforeach;


            if ($voucher_visa['mata_uang'] == "Rupiah") {
                $result = "Rp " . number_format($voucher_visa['total_harga'], 2, ',', '.');

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $result);
            } else {
                $result = "$ " . number_format($voucher_visa['total_harga'], 2, '.', ',');

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $result);
            }

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $numrow, date('d-m-Y', $voucher_visa['tgl_input']));


            if ($voucher_visa['jumlah_data'] == 0) {
                $angka_merge = $numrow + 1;
                $spreadsheet->getActiveSheet()->getStyle('A' . $numrow . ':A' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('B' . $numrow . ':B' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('C' . $numrow . ':C' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('D' . $numrow . ':D' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('E' . $numrow . ':E' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('F' . $numrow . ':F' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('G' . $numrow . ':G' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('H' . $numrow . ':H' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('I' . $numrow . ':I' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('J' . $numrow . ':J' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('K' . $numrow . ':K' . $angka_merge)->applyFromArray($style_row);
                $numrow++;
            } else {
                $angka_merge = $voucher_visa['jumlah_data'] + $numrow - 1;
                $spreadsheet->getActiveSheet()->getStyle('A' . $numrow . ':A' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('A' . $numrow . ':A' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('B' . $numrow . ':B' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('B' . $numrow . ':B' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('C' . $numrow . ':C' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('C' . $numrow . ':C' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('D' . $numrow . ':D' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('D' . $numrow . ':D' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('E' . $numrow . ':E' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('E' . $numrow . ':E' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('F' . $numrow . ':F' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('G' . $numrow . ':G' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('H' . $numrow . ':H' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('H' . $numrow . ':H' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('I' . $numrow . ':I' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('J' . $numrow . ':J' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('K' . $numrow . ':K' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('K' . $numrow . ':K' . $angka_merge);
            }
            $numrow = $numrow + $contoh;
            $no++;
        endforeach;

        foreach ($data_voucher_entertaint as $voucher_entertaint) :
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $voucher_entertaint['kode_voucher']);
            $data_pt = $this->db->get_where('pt', ['id' => $voucher_entertaint['id_pt']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data_pt['nama_pt']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $voucher_entertaint['mata_uang']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $voucher_entertaint['jumlah_data']);
            $data_pengguna_voucher_entertaint = $this->db->get_where('pengguna_voucher_entertaint', ['id_voucher_entertaint' => $voucher_entertaint['id_voucher']])->result_array();
            $numrow_data = $numrow;
            $contoh = 0;
            foreach ($data_pengguna_voucher_entertaint as $pengguna_voucher_entertaint) :
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow_data, $pengguna_voucher_entertaint['nama']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $numrow_data, '');
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $numrow_data, $pengguna_voucher_entertaint['jenis_proses']);
                if ($voucher_entertaint['mata_uang'] == "Rupiah") {
                    $result = "Rp " . number_format($pengguna_voucher_entertaint['harga'], 2, ',', '.');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $numrow_data, $result);
                } else {
                    $result = "$ " . number_format($pengguna_voucher_entertaint['harga'], 2, '.', ',');

                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $numrow_data, $result);
                }
                $numrow_data++;
                $contoh++;
            endforeach;


            if ($voucher_entertaint['mata_uang'] == "Rupiah") {
                $result = "Rp " . number_format($voucher_entertaint['total_harga'], 2, ',', '.');

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $result);
            } else {
                $result = "$ " . number_format($voucher_entertaint['total_harga'], 2, '.', ',');

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $result);
            }

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $numrow, date('d-m-Y', $voucher_entertaint['tgl_input']));

            if ($voucher_entertaint['jumlah_data'] == 0) {
                $angka_merge = $numrow + 1;
                $spreadsheet->getActiveSheet()->getStyle('A' . $numrow . ':A' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('B' . $numrow . ':B' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('C' . $numrow . ':C' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('D' . $numrow . ':D' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('E' . $numrow . ':E' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('F' . $numrow . ':F' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('G' . $numrow . ':G' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('H' . $numrow . ':H' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('I' . $numrow . ':I' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('J' . $numrow . ':J' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('K' . $numrow . ':K' . $angka_merge)->applyFromArray($style_row);
                $numrow++;
            } else {
                $angka_merge = $voucher_entertaint['jumlah_data'] + $numrow - 1;
                $spreadsheet->getActiveSheet()->getStyle('A' . $numrow . ':A' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('A' . $numrow . ':A' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('B' . $numrow . ':B' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('B' . $numrow . ':B' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('C' . $numrow . ':C' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('C' . $numrow . ':C' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('D' . $numrow . ':D' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('D' . $numrow . ':D' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('E' . $numrow . ':E' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('E' . $numrow . ':E' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('F' . $numrow . ':F' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('G' . $numrow . ':G' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('H' . $numrow . ':H' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('H' . $numrow . ':H' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('I' . $numrow . ':I' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('J' . $numrow . ':J' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('J' . $numrow . ':J' . $angka_merge);
                $spreadsheet->getActiveSheet()->getStyle('K' . $numrow . ':K' . $angka_merge)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->mergeCells('K' . $numrow . ':K' . $angka_merge);
            }
            $numrow = $numrow + $contoh; // Tambah 1 setiap kali looping
            $no++;
        endforeach;

        // Set width kolom
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(24); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom D

        // Set orientasi kertas jadi LANDSCAPE
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $spreadsheet->getActiveSheet(0)->setTitle("Laporan Data Transaksi");
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
        header('Cache-Control: max-age=0');

        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'My Data');

        $writer->save('php://output');
    }
    public function export_vouchervisa($id_voucher)
    {
        $data_voucher = $this->db->get_where('voucher_visa', ['id_voucher' => $id_voucher])->row_array();
        $judul = "Voucher " . $data_voucher['kode_voucher'];
        $data_pt = $this->db->get_where('pt', ['id' => $data_voucher['id_pt']])->row_array();
        $jenis_proses = $this->db->get_where('jenis_proses', ['id_proses' => $data_voucher['id_jenis_proses']])->row_array();
        $data_pengguna_voucher = $this->db->get_where('pengguna_voucher_visa', ['id_voucher_visa' => $data_voucher['id_voucher']])->result_array();
        $lokasi = $this->db->get_where('harga', ['id_harga' => $data_voucher['id_lokasi']])->row_array();

        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        );
        $style_cols = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        );

        $spreadsheet = new Spreadsheet;

        $spreadsheet->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Voucher")
            ->setSubject("Voucher")
            ->setDescription("Laporan Voucher")
            ->setKeywords("Data voucher");


        $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $objDrawing->setName('Blitzindoutama');
        $objDrawing->setDescription('Blitzindoutama');
        $objDrawing->setPath('assets/images/blog.png');
        $objDrawing->setCoordinates('B1');
        $objDrawing->setWorksheet($spreadsheet->getActiveSheet());
        $objDrawing->setWidth(170)->setHeight(170);


        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "PT. BLITZINDO UTAMA"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A1:F4'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk 
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Set text center untuk 

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', "FORM PROSES"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A5:F5'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A5')->getFont()->setSize(14); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk 

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A6', $data_voucher['kode_voucher']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A6:F6'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setSize(14); // Set font size 14 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        // Field Lokasi dan Staff OP
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A8', "NAMA PERUSAHAAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A8:B8'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A8:B8')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C8', $data_pt['nama_pt']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('C8:D8'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C8:D8')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E8', "BILL TO"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('E8')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F8', $data_voucher['bill_to']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('F8')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A9', "NAMA CLIENT"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A9:B9'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A9:B9')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C9', $data_voucher['nama_client']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('C9:D9'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C9:D9')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A10', "TANGGAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A10:B10'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A10:B10')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C10', date('d-m-Y', $data_voucher['tgl_input'])); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('C10:D10'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C10:D10')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E9', "LOKASI"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('E9')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F9', $lokasi['lokasi']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('F9')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E10', "STAFF OP"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('E10')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F10', $data_voucher['staff']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('F10')->applyFromArray($style_cols);


        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A12', "NO");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B12', "NAMA");
        $spreadsheet->getActiveSheet()->mergeCells('B12:C12');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D12', "NO PASSPORT");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E12', "JENIS PROSES");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F12', "JUMLAH");

        $spreadsheet->getActiveSheet()->getStyle('A12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('B12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('C12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F12')->applyFromArray($style_col);

        $no = 1;
        $numrow = 13;
        foreach ($data_pengguna_voucher as $pengguna_voucher) :
            $data_tka = $this->db->get_where('tka', ['id' => $pengguna_voucher['id_tka']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data_tka['nama_mandarin']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data_tka['nama_latin']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data_tka['passport']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $jenis_proses['nama_proses']);
            if ($data_voucher['mata_uang'] == 'Rupiah') {
                $harga = "Rp " . number_format($pengguna_voucher['harga'], 2, ',', '.');
            } else {
                $harga = "$ " . number_format($pengguna_voucher['harga'], 2, '.', ',');
            }
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $harga);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $spreadsheet->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

            $spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        endforeach;

        if ($no < 20) {
            $sisa = 20 - $no;
            for ($i = 0; $i <= $sisa; $i++) {
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, "$no");
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, "");
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, "");
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, "");
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, "");
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "");

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $spreadsheet->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

                $spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
                $numrow++;
                $no++;
            }
        } else {
        }

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A33', "TOTAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A33:E33'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A33:E33')->applyFromArray($style_col);

        if ($data_voucher['mata_uang'] == "Rupiah") {
            $cetak_total = "Rp " . number_format($data_voucher['total_harga'], 2, ',', '.');
        } else {
            $cetak_total = "$ " . number_format($data_voucher['total_harga'], 2, '.', ',');
        }

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F33', $cetak_total); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('F33')->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A35', "APPLY BY");
        $spreadsheet->getActiveSheet()->mergeCells('A35:B36'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A35:B36')->applyFromArray($style_col);

        $user = $this->db->get_where('user', ['id' => $data_voucher['input_by_id']])->row_array();
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C35', $user['nama']);
        $spreadsheet->getActiveSheet()->mergeCells('C35:F36'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C35:F36')->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A37', "HEAD DPT");
        $spreadsheet->getActiveSheet()->mergeCells('A37:B38'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A37:B38')->applyFromArray($style_col);

        $spreadsheet->getActiveSheet()->mergeCells('C37:F38'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C37:F38')->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A40', "NOTE	:");
        $spreadsheet->getActiveSheet()->mergeCells('A40:B40'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A40')->getFont()->setBold(TRUE);
        $spreadsheet->getActiveSheet()->getStyle('A40')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A41', $data_voucher['note']);
        $spreadsheet->getActiveSheet()->mergeCells('A41:F45'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A41:F45')->applyFromArray($style_col);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom F

        // Set orientasi kertas jadi LANDSCAPE
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

        // Set judul file excel nya
        $spreadsheet->getActiveSheet(0)->setTitle("Laporan Data Transaksi");
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
        header('Cache-Control: max-age=0');

        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'My Data');

        $writer->save('php://output');
    }
    public function export_voucher_entertaint($id_voucher)
    {
        $data_voucher = $this->db->get_where('voucher_entertaint', ['id_voucher' => $id_voucher])->row_array();
        $judul = "Voucher " . $data_voucher['kode_voucher'];
        $data_pt = $this->db->get_where('pt', ['id' => $data_voucher['id_pt']])->row_array();
        $data_pengguna_voucher = $this->db->get_where('pengguna_voucher_entertaint', ['id_voucher_entertaint' => $data_voucher['id_voucher']])->result_array();

        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        );
        $style_cols = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        );

        $spreadsheet = new Spreadsheet;

        $spreadsheet->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Voucher")
            ->setSubject("Voucher")
            ->setDescription("Laporan Voucher")
            ->setKeywords("Data voucher");


        $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $objDrawing->setName('Blitzindoutama');
        $objDrawing->setDescription('Blitzindoutama');
        $objDrawing->setPath('assets/images/blog.png');
        $objDrawing->setCoordinates('B1');
        $objDrawing->setWorksheet($spreadsheet->getActiveSheet());
        $objDrawing->setWidth(170)->setHeight(170);


        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "PT. BLITZINDO UTAMA"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A1:F4'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk 
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Set text center untuk 

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', "FORM PROSES"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A5:F5'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A5')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A5')->getFont()->setSize(14); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk 

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A6', $data_voucher['kode_voucher']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A6:F6'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A6')->getFont()->setSize(14); // Set font size 14 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


        // Field Lokasi dan Staff OP
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A8', "NAMA PERUSAHAAN"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A8:B8'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A8:B8')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C8', $data_pt['nama_pt']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('C8:D8'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C8:D8')->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E8', "BILL TO"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('E8')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F8', $data_voucher['bill_to']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A9', "NAMA CLIENT"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A9:B9'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A9:B9')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C9', $data_voucher['nama_client']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('C9:D9'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C9:D9')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A10', "TANGGAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A10:B10'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A10:B10')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C10', date('d-m-Y', $data_voucher['tgl_input'])); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('C10:D10'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C10:D10')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E9', "LOKASI"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('E9')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F9', $data_voucher['lokasi']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('F9')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E10', "STAFF OP"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('E10')->applyFromArray($style_cols);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F10', $data_voucher['staff']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('F10')->applyFromArray($style_cols);


        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A12', "NO");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B12', "NAMA");
        $spreadsheet->getActiveSheet()->mergeCells('B12:C12');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D12', "JENIS PROSES");
        $spreadsheet->getActiveSheet()->mergeCells('D12:E12');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F12', "JUMLAH");

        $spreadsheet->getActiveSheet()->getStyle('A12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('B12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('C12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E12')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F12')->applyFromArray($style_col);

        $no = 1;
        $numrow = 13;
        foreach ($data_pengguna_voucher as $pengguna_voucher) :
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $pengguna_voucher['nama']);
            $spreadsheet->getActiveSheet()->mergeCells('B' . $numrow . ':C' . $numrow);
            $spreadsheet->getActiveSheet()->getStyle('B' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $pengguna_voucher['jenis_proses']);
            if ($data_voucher['mata_uang'] == 'Rupiah') {
                $harga = "Rp " . number_format($pengguna_voucher['harga'], 2, ',', '.');
            } else {
                $harga = "$ " . number_format($pengguna_voucher['harga'], 2, '.', ',');
            }
            $spreadsheet->getActiveSheet()->mergeCells('D' . $numrow . ':E' . $numrow);
            $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $harga);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $spreadsheet->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

            $spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        endforeach;

        if ($no < 20) {
            $sisa = 20 - $no;
            for ($i = 0; $i <= $sisa; $i++) {
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, "$no");
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, "");
                $spreadsheet->getActiveSheet()->mergeCells('B' . $numrow . ':C' . $numrow);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, "");
                $spreadsheet->getActiveSheet()->mergeCells('D' . $numrow . ':E' . $numrow);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "");

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $spreadsheet->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $spreadsheet->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

                $spreadsheet->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
                $numrow++;
                $no++;
            }
        } else {
        }

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A33', "TOTAL"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A33:E33'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A33:E33')->applyFromArray($style_col);

        if ($data_voucher['mata_uang'] == "Rupiah") {
            $cetak_total = "Rp " . number_format($data_voucher['total_harga'], 2, ',', '.');
        } else {
            $cetak_total = "$ " . number_format($data_voucher['total_harga'], 2, '.', ',');
        }

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F33', $cetak_total); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->getStyle('F33')->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A35', "APPLY BY");
        $spreadsheet->getActiveSheet()->mergeCells('A35:B36'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A35:B36')->applyFromArray($style_col);
        $user = $this->db->get_where('user', ['id' => $data_voucher['input_by_id']])->row_array();
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C35', $user['nama']);
        $spreadsheet->getActiveSheet()->mergeCells('C35:F36'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C35:F36')->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A37', "HEAD DPT");
        $spreadsheet->getActiveSheet()->mergeCells('A37:B38'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A37:B38')->applyFromArray($style_col);

        $spreadsheet->getActiveSheet()->mergeCells('C37:F38'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('C37:F38')->applyFromArray($style_col);

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A40', "NOTE	:");
        $spreadsheet->getActiveSheet()->mergeCells('A40:B40'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A40')->getFont()->setBold(TRUE);
        $spreadsheet->getActiveSheet()->getStyle('A40')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A41', $data_voucher['note']);
        $spreadsheet->getActiveSheet()->mergeCells('A41:F45'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A41:F45')->applyFromArray($style_col);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom F

        // Set orientasi kertas jadi LANDSCAPE
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

        // Set judul file excel nya
        $spreadsheet->getActiveSheet(0)->setTitle("Laporan Data Transaksi");
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
        header('Cache-Control: max-age=0');

        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'My Data');

        $writer->save('php://output');
    }
    public function export_rptka($id_rptka)
    {
        $data_rptka = $this->db->get_where('rptka', ['id' => $id_rptka])->row_array();
        $judul = "RPTKA " . $data_rptka['no_rptka'];
        $data_pt = $this->db->get_where('pt', ['id' => $data_rptka['id_pt']])->row_array();
        $data_jabatan_rptka = $this->db->get_where('jabatan_rptka', ['id_rptka' => $id_rptka])->result_array();
        $data_pengguna_rptka = $this->db->get_where('penghubung_visa312', ['id_rptka' => $id_rptka, 'id_pt' => $data_rptka['id_pt']])->result_array();

        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        );

        $style_row = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        );

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B1', "DATA RPTKA" . $data_pt['nama_pt']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('B1:N1'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B2', "NO RPTKA" . $data_rptka['no_rptka']); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('B2:N2'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C3', "NAMA MANDARIN"); // Set kolom B3 dengan tulisan "NIS"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E3', "PASSPORT"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F3', "KEWARGANEGARAAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G3', "EXPIRED PASSPORT"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H3', "JENIS VISA"); // Set kolom E3 dengan tulisan "TELEPON"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I3', "JABATAN"); // Set kolom F3 dengan tulisan "ALAMAT"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('J3', "JANGKA WAKTU VISA (BULAN)"); // Set kolom F3 dengan tulisan "ALAMAT"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('K3', "TANGGAL TERBIT VISA"); // Set kolom F3 dengan tulisan "ALAMAT"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('L3', "NO KITAS"); // Set kolom F3 dengan tulisan "ALAMAT"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('M3', "NO NOTIFIKASI"); // Set kolom F3 dengan tulisan "ALAMAT"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('N3', "KADALUARSA KITAS"); // Set kolom F3 dengan tulisan "ALAMAT"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('O3', "KETERANGAN"); // Set kolom F3 dengan tulisan "ALAMAT"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('P3', "STATUS"); // Set kolom F3 dengan tulisan "ALAMAT"


        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);

        // Set height baris ke 1, 2 dan 3
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        $no = 1;
        $numrow = 4;
        foreach ($data_pengguna_rptka as $pengguna_rptka) {
            $data_tka = $this->db->get_where('tka', ['id' => $pengguna_rptka['id_tka']])->row_array();
            $data_visa = $this->db->get_where('visa_312', ['id_penghubung_visa' => $pengguna_rptka['id_penghubung_visa312']])->row_array();
            $data_jenis_visa = $this->db->get_where('jenis_visa', ['id' => $pengguna_rptka['id_jenis_visa']])->row_array();
            $data_jabatan = $this->db->get_where('jabatan_rptka', ['id_jabatan_rptka' => $pengguna_rptka['id_jabatan']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data_tka['nama_mandarin']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data_tka['nama_latin']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data_tka['passport']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data_tka['kewarganegaraan']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $numrow, date('d-m-Y', $data_tka['expired_passport']));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_jenis_visa['visa']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_jabatan['jabatan']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_visa['waktu_visa']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $numrow, date('d-m-Y', $data_visa['tgl_awal']));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data_visa['no_kitas']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data_visa['no_notifikasi']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('N' . $numrow, date('d-m-Y', $data_visa['tgl_expired']));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data_visa['ket']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $pengguna_rptka['status']);

            $spreadsheet->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $spreadsheet->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);

            $numrow++;
            $no++;
        }

        $numrow += 2;
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, "NO"); // Set kolom A3 dengan tulisan "NO"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, "JABATAN"); // Set kolom B3 dengan tulisan "NIS"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, "JUMLAH"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, "TERPAKAI"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "SISA"); // Set kolom E3 dengan tulisan "TELEPON"

        $spreadsheet->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_col);
        $terpakai = 0;
        $numrow++;
        foreach ($data_jabatan_rptka as $jabatan_rptka) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $jabatan_rptka['jabatan']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $jabatan_rptka['jumlah']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $jabatan_rptka['terpakai']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $jabatan_rptka['jumlah'] - $jabatan_rptka['terpakai']);
            $terpakai += $jabatan_rptka['terpakai'];
            $spreadsheet->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_col);
            $spreadsheet->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_col);
            $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_col);
            $spreadsheet->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_col);
            $spreadsheet->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_col);
            $numrow++;
        }

        $numrow++;

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, "TOTAL"); // Set kolom A3 dengan tulisan "NO"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data_rptka['jumlah_rptka']); // Set kolom B3 dengan tulisan "NIS"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $terpakai); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data_rptka['jumlah_rptka'] - $terpakai); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        $spreadsheet->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_col);

        // Set width kolom
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5); // Set width kolom A
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom B
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom C
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom E

        // Set orientasi kertas jadi LANDSCAPE
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
        header('Cache-Control: max-age=0');

        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Data RPTKA');

        // Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object

        $writer->save('php://output');
    }

    public function export_visa211()
    {
        $dari = strtotime($this->input->post('dari'));
        $id_visa = $this->input->post('id_visa');
        $sampai = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
        $id_pt = $this->input->post('id_pt');

        $this->db->select('*');
        $this->db->from('jenis_visa');
        $this->db->where('id', $id_visa);
        $query = $this->db->get();
        $jenis_visa = $query->row_array();

        $nama_visa = $jenis_visa['visa'];

        $this->db->select('*');
        $this->db->from('penghubung_visa211');
        if ($id_pt == 'Semua Perusahaan') {
        } else {
            $this->db->where('id_pt', $id_pt);
        }
        $this->db->where('id_jenis_visa', $id_visa);
        $query_penghubung = $this->db->get();
        $data_penghubung_visa = $query_penghubung->result_array();

        $judul = "Report Visa " . $nama_visa;

        $spreadsheet = new Spreadsheet;

        // Settingan awal fil excel
        $spreadsheet->getProperties()->setCreator('')
            ->setLastModifiedBy('')
            ->setTitle("Visa")
            ->setSubject("Visa")
            ->setDescription("Visa")
            ->setKeywords("Visa");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "REPORT VISA $nama_visa"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B3', "NAMA PERUSAHAAN"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom B3 dengan tulisan "NIS"
        $spreadsheet->getActiveSheet()->mergeCells('C3:D3');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E3', "PASSPORT"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F3', "TANGGAL LAHIR"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G3', "VISA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H3', "TANGGAL AWAL VISA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I3', "TANGGAL EXPIRED VISA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('J3', "STATUS"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('K3', "KETERANGAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('L3', "TANGGAL INPUT"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('M3', "INPUT BY"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);

        // Set height baris ke 1, 2 dan 3
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        $no = 1;
        foreach ($data_penghubung_visa as $penghubung_visa) :
            $this->db->select('*');
            $this->db->from('tka');
            $this->db->where('id', $penghubung_visa['id_tka']);
            $query = $this->db->get();
            $data_tka = $query->row_array();
            $data_pt = $this->db->get_where('pt', ['id' => $penghubung_visa['id_pt']])->row_array();
            $data_visa = $this->db->get_where('visa_211', ['id_penghubung' => $penghubung_visa['id_penghubung_visa211']])->row_array();
            $data_input_by = $this->db->get_where('user', ['id' => $data_visa['input_by_id']])->row_array();
            if (($data_visa['tgl_input'] >= $dari) and ($data_visa['tgl_input'] <= $sampai)) {
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data_pt['nama_pt']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data_tka['nama_mandarin']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data_tka['nama_latin']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data_tka['passport']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, date('d-m-Y', $data_tka['tgl_lahir']));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $nama_visa);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $numrow, date('d-m-Y', $data_visa['tgl_awal']));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $numrow, date('d-m-Y', $data_visa['tgl_expired']));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $penghubung_visa['status']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data_visa['ket']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('L' . $numrow, date('d-m-Y', $data_visa['tgl_input']));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data_input_by['nama']);
                $no++;
                $numrow++;
            } else {
            }

        endforeach;

        // Set width kolom
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(24); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20); // Set width kolom D

        // Set orientasi kertas jadi LANDSCAPE
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $spreadsheet->getActiveSheet(0)->setTitle("Data Visa");
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
        header('Cache-Control: max-age=0');

        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'My Data');

        $writer->save('php://output');
    }
    public function export_visa312()
    {
        $dari = strtotime($this->input->post('dari'));
        $id_visa = $this->input->post('id_visa');
        $sampai = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
        $id_pt = $this->input->post('id_pt');

        $this->db->select('*');
        $this->db->from('jenis_visa');
        $this->db->where('id', $id_visa);
        $query = $this->db->get();
        $jenis_visa = $query->row_array();

        $nama_visa = $jenis_visa['visa'];

        $this->db->select('*');
        $this->db->from('penghubung_visa312');
        if ($id_pt == 'Semua Perusahaan') {
        } else {
            $this->db->where('id_pt', $id_pt);
        }
        $this->db->where('id_jenis_visa', $id_visa);
        $query_penghubung = $this->db->get();
        $data_penghubung_visa = $query_penghubung->result_array();

        $judul = "Report Visa " . $nama_visa;

        $spreadsheet = new Spreadsheet;

        // Settingan awal fil excel
        $spreadsheet->getProperties()->setCreator('')
            ->setLastModifiedBy('')
            ->setTitle("Visa")
            ->setSubject("Visa")
            ->setDescription("Visa")
            ->setKeywords("Visa");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "REPORT VISA $nama_visa"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A1:R1'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B3', "NAMA PERUSAHAAN"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom B3 dengan tulisan "NIS"
        $spreadsheet->getActiveSheet()->mergeCells('C3:D3');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E3', "PASSPORT"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F3', "TANGGAL LAHIR"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G3', "VISA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H3', "NO RPTKA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I3', "JABATAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('J3', "TANGGAL AWAL VISA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('K3', "MONTH"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('L3', "NO KITAS"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('M3', "TANGGAL EXPIRED VISA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('N3', "NO NOTIFIKASI"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('O3', "STATUS"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('P3', "KETERANGAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('Q3', "TANGGAL INPUT"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('R3', "INPUT BY"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);

        // Set height baris ke 1, 2 dan 3
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        $no = 1;
        foreach ($data_penghubung_visa as $penghubung_visa) :
            $this->db->select('*');
            $this->db->from('tka');
            $this->db->where('id', $penghubung_visa['id_tka']);
            $query = $this->db->get();
            $data_tka = $query->row_array();
            $this->db->select('no_rptka');
            $this->db->from('rptka');
            $this->db->where('id', $penghubung_visa['id_rptka']);
            $query_rptka = $this->db->get();
            $data_rptka = $query_rptka->row_array();
            $this->db->select('jabatan');
            $this->db->from('jabatan_rptka');
            $this->db->where('id_jabatan_rptka', $penghubung_visa['id_jabatan']);
            $query_jabatan = $this->db->get();
            $data_jabatan = $query_jabatan->row_array();
            $data_pt = $this->db->get_where('pt', ['id' => $penghubung_visa['id_pt']])->row_array();
            $data_visa = $this->db->get_where('visa_312', ['id_penghubung_visa' => $penghubung_visa['id_penghubung_visa312']])->row_array();
            $data_input_by = $this->db->get_where('user', ['id' => $data_visa['input_by_id']])->row_array();
            if (($data_visa['tgl_input'] >= $dari) and ($data_visa['tgl_input'] <= $sampai)) {
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data_pt['nama_pt']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data_tka['nama_mandarin']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data_tka['nama_latin']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data_tka['passport']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, date('d-m-Y', $data_tka['tgl_lahir']));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $nama_visa);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_rptka['no_rptka']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_jabatan['jabatan']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $numrow, date('d-m-Y', $data_visa['tgl_awal']));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data_visa['waktu_visa']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data_visa['no_kitas']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('M' . $numrow, date('d-m-Y', $data_visa['tgl_expired']));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data_visa['no_notifikasi']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $penghubung_visa['status']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data_visa['ket']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, date('d-m-Y', $data_visa['tgl_input']));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data_input_by['nama']);
                $no++;
                $numrow++;
            } else {
            }

        endforeach;

        // Set width kolom
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(24); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Set width kolom D

        // Set orientasi kertas jadi LANDSCAPE
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $spreadsheet->getActiveSheet(0)->setTitle("Data Visa");
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
        header('Cache-Control: max-age=0');

        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'My Data');

        $writer->save('php://output');
    }

    public function export_rptka_all()
    {
        $dari = strtotime($this->input->post('dari'));
        $sampai = strtotime($this->input->post('sampai')) + (60 * 60 * 24);
        $id_pt = $this->input->post('id_pt');

        $this->db->select('*');
        $this->db->from('rptka');
        if ($id_pt == 'Semua Perusahaan') {
            $this->db->where('tgl_input >=', $dari);
            $this->db->where('tgl_input <=', $sampai);
        } else {
            $this->db->where('id_pt', $id_pt);
            $this->db->where('tgl_input >=', $dari);
            $this->db->where('tgl_input <=', $sampai);
        }
        $query = $this->db->get();
        $data_rptka = $query->result_array();

        $judul = "Report RPTKAs";

        $spreadsheet = new Spreadsheet;

        // Settingan awal fil excel
        $spreadsheet->getProperties()->setCreator('')
            ->setLastModifiedBy('')
            ->setTitle("RPTKA")
            ->setSubject("RPTKA")
            ->setDescription("RPTKA")
            ->setKeywords("RPTKA");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "REPORT RPTKA"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $spreadsheet->getActiveSheet()->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai F1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B3', "NAMA PERUSAHAAN"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C3', "NO RPTKA"); // Set kolom B3 dengan tulisan "NIS"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D3', "TANGGAL TERBIT"); // Set kolom C3 dengan tulisan "NAMA"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E3', "TANGGAL EXPIRED"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F3', "JUMLAH RPTKA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G3', "RPTKA TERPAKAI"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H3', "KETERANGAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I3', "TANGGAL INPUT"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('J3', "INPUT BY"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $spreadsheet->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);

        // Set height baris ke 1, 2 dan 3
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        $no = 1;
        foreach ($data_rptka as $rptka) :
            $data_pt = $this->db->select('nama_pt')->get_where('pt', ['id' => $rptka['id_pt']])->row_array();
            $data_user = $this->db->select('nama')->get_where('user', ['id' => $rptka['input_by_id']])->row_array();
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data_pt['nama_pt']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $rptka['no_rptka']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $numrow, date('d-m-Y', $rptka['tgl_terbit']));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $numrow, date('d-m-Y', $rptka['tgl_expired']));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $rptka['jumlah_rptka']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $rptka['jumlah_terpakai']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $rptka['ket']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_user['nama']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $numrow, date('d-m-Y', $rptka['tgl_input']));
            $no++;
            $numrow++;
        endforeach;

        // Set width kolom
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Set width kolom D
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(24); // Set width kolom D

        // Set orientasi kertas jadi LANDSCAPE
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $spreadsheet->getActiveSheet(0)->setTitle("Data RPTKA");
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $judul . '.xlsx');
        header('Cache-Control: max-age=0');

        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'My Data');

        $writer->save('php://output');
    }
}
