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
            <div class="card-header">Data Voucher
            </div>
            <form action="" method="POST">
                <div class="table-responsive" style="padding: 10px;">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No Passport</th>
                                <th class="text-center">Nama Mandarin</th>
                                <th class="text-center">Nama Latin</th>
                                <th class="text-center">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            for ($i = 0; $i < count($id_tka); $i++) :
                                $this->db->select(array('id', 'passport', 'nama_mandarin', 'nama_latin'));
                                $this->db->from('tka');
                                $this->db->where('id', $id_tka[$i]);
                                $query = $this->db->get();
                                $data_tka = $query->row_array();
                                if ($data_voucher['mata_uang'] == ('Rupiah')) {
                                    $this->db->select('rupiah');
                                    $this->db->from('harga');
                                    $this->db->where('id_harga', $data_voucher['id_lokasi']);
                                    $query_harga = $this->db->get();
                                    $data_harga = $query_harga->row_array();
                                    $harga = $data_harga['rupiah'];
                                    $satuan = "Rp " . number_format($data_harga['rupiah'], 2, ',', '.');
                                    $total += $data_harga['rupiah'];
                                } else {
                                    $this->db->select('dollar');
                                    $this->db->from('harga');
                                    $this->db->where('id_harga', $data_voucher['id_lokasi']);
                                    $query_harga = $this->db->get();
                                    $data_harga = $query_harga->row_array();
                                    $harga = $data_harga['dollar'];
                                    $satuan = "$ " . number_format($data_harga['dollar'], 2, '.', ',');
                                    $total += $data_harga['dollar'];
                                }
                            ?>
                                <tr id="row<?= $i; ?>" class="dynamic-added">
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center">
                                        <?= $data_tka['passport']; ?>
                                    </td>
                                    <td class="text-center"><?= $data_tka['nama_mandarin']; ?></td>
                                    <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                                    <input type="hidden" name="data_tka[]" id="data_tka[]" value="<?= $id_tka[$i]; ?>">
                                    <td class="text-center">
                                        <input type="hidden" class="form-control text-center" name="harga[]" id="harga[]" value="<?= $harga; ?>" readonly>
                                        <input type="text" class="form-control text-center" name="satuan[]" id="satuan[]" value="<?= $satuan; ?>" readonly>
                                    </td>
                                </tr>
                            <?php $no++;
                            endfor;
                            foreach ($data_pengguna_voucher as $pengguna_voucher) :
                                $this->db->select(array('id', 'passport', 'nama_mandarin', 'nama_latin'));
                                $this->db->from('tka');
                                $this->db->where('id', $pengguna_voucher['id_tka']);
                                $query = $this->db->get();
                                $data_tka_lama = $query->row_array();
                                if ($data_voucher['mata_uang'] == ('Rupiah')) {
                                    $satuan = "Rp " . number_format($pengguna_voucher['harga'], 2, ',', '.');
                                    $total += $pengguna_voucher['harga'];
                                } else {
                                    $satuan = "$ " . number_format($pengguna_voucher['harga'], 2, '.', ',');
                                    $total += $pengguna_voucher['harga'];
                                }
                            ?>
                                <tr class="dynamic-added">
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center">
                                        <?= $data_tka['passport']; ?>
                                    </td>
                                    <td class="text-center"><?= $data_tka_lama['nama_mandarin']; ?></td>
                                    <td class="text-center"><?= $data_tka_lama['nama_latin']; ?></td>
                                    <td class="text-center">
                                        <?= $satuan; ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            endforeach; ?>

                            <tr>
                                <td class="text-center" colspan="4"> Total </td>
                                <td class="text-center">
                                    <?php if ($data_voucher['mata_uang'] == "Rupiah") {
                                        $total_harga = "Rp " . number_format($total, 2, ',', '.');
                                    } else {
                                        $total_harga = "$ " . number_format($total, 2, '.', ',');
                                    } ?>
                                    <?= $total_harga; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="id_voucher" id="id_voucher" value="<?= $data_voucher['id_voucher']; ?>">
                    <input type="hidden" name="total" id="total" value="<?= $total; ?>">
                    <button type="submit" class="btn-actions-pane-right mb-2 mr-2 btn btn-primary"><?= $button; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>