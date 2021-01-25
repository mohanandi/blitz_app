<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data Spesifikasi Voucher
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
                            <th class="text-center">Mata Uang</th>
                            <th class="text-center">Staff OP</th>
                            <th class="text-center">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $this->db->select('nama_pt');
                            $this->db->from('pt');
                            $this->db->where('id', $id_pt);
                            $query_pt = $this->db->get();
                            $data_pt = $query_pt->row_array();
                            $this->db->select('kategori');
                            $this->db->from('kategori_voucher');
                            $this->db->where('id_kategori_voucher', $id_kategori);
                            $query = $this->db->get();
                            $data_kategori = $query->row_array();
                            $this->db->select('nama_proses');
                            $this->db->from('jenis_proses');
                            $this->db->where('id_proses', $id_jenis_proses);
                            $query = $this->db->get();
                            $data_jenis_proses = $query->row_array();
                            $this->db->select('lokasi');
                            $this->db->from('harga');
                            $this->db->where('id_harga', $lokasi);
                            $query = $this->db->get();
                            $data_lokasi = $query->row_array();
                            ?>
                            <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                            <td class="text-center"><?= $nama_client; ?></td>
                            <td class="text-center"><?= $data_kategori['kategori']; ?></td>
                            <td class="text-center"><?= $data_jenis_proses['nama_proses']; ?></td>
                            <td class="text-center"><?= $data_lokasi['lokasi']; ?></td>
                            <td class="text-center"><?= $mata_uang; ?></td>
                            <td class="text-center"><?= $staff; ?></td>
                            <td class="text-center"><?= $note; ?></td>
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
            <form action="<?= base_url('Data_Voucher/tambahvouchervisa'); ?>" method="POST" onSubmit="return validate()">
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
                            foreach ($data_tka as $tka) : ?>
                                <tr id="row<?= $i; ?>" class="dynamic-added">
                                    <td class="text-center"><?= $i; ?></td>
                                    <td class="text-center">
                                        <?= $tka['passport']; ?>
                                    </td>
                                    <td class="text-center"><?= $tka['nama_mandarin']; ?></td>
                                    <td class="text-center"><?= $tka['nama_latin']; ?></td>
                                    <td id="tombol<?= $i; ?>">
                                        <input type="checkbox" name="data_tka[]" id="data_tka[]" value="<?= $tka['id']; ?>">
                                        <input type="hidden" name="nama_pt" id="nama_pt" value="<?= $id_pt ?>">
                                        <input type="hidden" name="kategori" id="kategori" value="<?= $id_kategori; ?>">
                                        <input type="hidden" name="jenis_proses" id="jenis_proses" value="<?= $id_jenis_proses; ?>">
                                        <input type="hidden" name="nama_client" id="nama_client" value="<?= $nama_client; ?>">
                                        <input type="hidden" name="lokasi" id="lokasi" value="<?= $lokasi; ?>">
                                        <input type="hidden" name="staff" id="staff" value="<?= $staff; ?>">
                                        <input type="hidden" name="note" id="note" value="<?= $note; ?>">
                                        <input type="hidden" name="mata_uang" id="mata_uang" value="<?= $mata_uang; ?>">
                                    </td>
                                </tr>
                            <?php $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
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