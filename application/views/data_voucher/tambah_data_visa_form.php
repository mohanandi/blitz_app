<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data Spesifikasi Voucher <?= $data_voucher['kode_voucher']; ?>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Perusahaan</th>
                            <th class="text-center">Nama Client</th>
                            <th class="text-center">Kategori Voucher</th>
                            <th class="text-center">Jenis Proses</th>
                            <th class="text-center">Lokasi</th>
                            <th class="text-center">Mata_Uang</th>
                            <th class="text-center">Note</th>
                            <th class="text-center">Staff OP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $total = 0;
                            $this->db->select('nama_pt');
                            $this->db->from('pt');
                            $this->db->where('id', $data_voucher['id_pt']);
                            $query_pt = $this->db->get();
                            $data_pt = $query_pt->row_array();
                            $this->db->select('kategori');
                            $this->db->from('kategori_voucher');
                            $this->db->where('id_kategori_voucher', $data_voucher['kategori_id']);
                            $query = $this->db->get();
                            $data_kategori = $query->row_array();
                            $this->db->select('nama_proses');
                            $this->db->from('jenis_proses');
                            $this->db->where('id_proses', $data_voucher['id_jenis_proses']);
                            $query = $this->db->get();
                            $data_jenis_proses = $query->row_array();
                            $this->db->select('lokasi');
                            $this->db->from('harga');
                            $this->db->where('id_harga', $data_voucher['id_lokasi']);
                            $query = $this->db->get();
                            $data_lokasi = $query->row_array();
                            ?>
                            <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                            <td class="text-center"><?= $data_voucher['nama_client']; ?></td>
                            <td class="text-center"><?= $data_kategori['kategori']; ?></td>
                            <td class="text-center"><?= $data_jenis_proses['nama_proses']; ?></td>
                            <td class="text-center"><?= $data_lokasi['lokasi']; ?></td>
                            <td class="text-center"><?= $data_voucher['mata_uang']; ?></td>
                            <td class="text-center"><?= $data_voucher['staff']; ?></td>
                            <td class="text-center"><?= $data_voucher['note']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <form action="<?= base_url('Data_Voucher/tambahtkavisa'); ?>" method="POST" onSubmit="return validate()">
                <div class="card-header"> Pilih Data TKA untuk Voucher
                </div>
                <div class="table-responsive" style="padding: 10px;">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No Passport</th>
                                <th class="text-center">Nama Mandarin</th>
                                <th class="text-center">Nama Latin</th>
                                <th class="text-center">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $array_id_tka = array(0);
                            foreach ($data_pengguna_voucher as $tka) :
                                array_push($array_id_tka, $tka['id_tka']);
                            endforeach;
                            foreach ($data_tka as $tka) :
                                if (array_search($tka['id'], $array_id_tka)) {
                                } else {
                            ?>
                                    <tr id="row<?= $i; ?>" class="dynamic-added">
                                        <td class="text-center"><?= $i; ?></td>
                                        <td class="text-center">
                                            <?= $tka['passport']; ?>
                                        </td>
                                        <td class="text-center"><?= $tka['nama_mandarin']; ?></td>
                                        <td class="text-center"><?= $tka['nama_latin']; ?></td>
                                        <td id="tombol<?= $i; ?>">
                                            <input type="checkbox" name="data_tka[]" id="data_tka[]" value="<?= $tka['id']; ?>">
                                        </td>
                                    </tr>
                            <?php $i++;
                                }
                            endforeach; ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="id_voucher" id="id_voucher" value="<?= $data_voucher['id_voucher']; ?>">
                    <button type="submit" class="btn-actions-pane-right mb-2 mr-2 btn btn-primary">Tambahkan TKA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script language="javascript">
    function validate() {
        var chks = document.getElementsByName('data_tka[]');
        var hasChecked = false;
        for (var i = 0; i < chks.length; i++) {
            if (chks[i].checked) {
                hasChecked = true;
                break;
            }
        }

        if (hasChecked == false) {
            alert("Please select at least one.");
            return false;
        }
        return true;
    }
</script>