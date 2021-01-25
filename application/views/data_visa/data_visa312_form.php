<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data TKA
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Mandarin</th>
                            <th class="text-center">Nama Latin</th>
                            <th class="text-center">Nama PT</th>
                            <th class="text-center">Passport</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">input By</th>
                            <th class="text-center">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?= $data_tka['nama_mandarin']; ?></td>
                            <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                            <?php $data_pt = $this->db->get_where('pt', ['id' => $data_tka['id_pt']])->row_array(); ?>
                            <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                            <td class="text-center"><?= $data_tka['passport']; ?></td>
                            <td class="text-center"><?= $data_tka['ket']; ?></td>
                            <?php $data_user = $this->db->get_where('user', ['id' => $data_tka['input_by_id']])->row_array(); ?>
                            <td class="text-center"><?= $data_user['nama']; ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_tka['tgl_input']); ?></td>
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
            <div class="card-header"><?= $subjudul; ?>
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form method="POST">
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label">Visa</label>
                        <?php if ($ket_visa == 'tambah') : ?>
                            <input name="id_tka" id="id_tka" value="<?= $data_tka['id']; ?>" type="hidden" class="form-control">
                            <input name="id_visa" id="id_visa" value="<?= $data_jenis_visa['id']; ?>" type="hidden" class="form-control">
                            <input name="id_pt" id="id_pt" value="<?= $data_tka['id_pt']; ?>" type="hidden" class="form-control">
                        <?php else : ?>
                        <?php endif; ?>
                        <div class="col-sm-10">
                            <input name="nama_visa" id="nama_visa" value="<?= $data_jenis_visa['visa']; ?>" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label">No RPTKA</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="no_rptka" id="no_rptka">
                                <?php if (set_value('no_rptka')) :
                                    $pilihan_rptka = $this->db->get_where('rptka', ['id' => set_value('no_rptka')])->row_array(); ?>
                                    <option value="<?= $pilihan_rptka['id']; ?>"><?= $pilihan_rptka['no_rptka']; ?></option>
                                <?php elseif ($data_penghubung['id_rptka']) :
                                    $pilihan_rptka = $this->db->get_where('rptka', ['id' => $data_penghubung['id_rptka']])->row_array(); ?>
                                    <option value="<?= $pilihan_rptka['id']; ?>"><?= $pilihan_rptka['no_rptka']; ?></option>
                                <?php else : ?>
                                    <option value="">Select No RPTKA</option>
                                <?php endif; ?>
                                <?php foreach ($data_rptka as $rptka) :
                                    $sisa = $rptka->jumlah_rptka - $rptka->jumlah_terpakai;
                                    if ($sisa == 0) :
                                    else : ?>
                                        <option value="<?= $rptka->id; ?>"><?= $rptka->no_rptka; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label">Jabatan RPTKA</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jabatan_rptka" id="jabatan_rptka">
                                <?php if (set_value('jabatan_rptka')) :
                                    $pilihan_jabatan = $this->db->get_where('jabatan_rptka', ['id_jabatan_rptka' => set_value('jabatan_rptka')])->row_array(); ?>
                                    <option value="<?= $pilihan_jabatan['id_jabatan_rptka']; ?>"><?= $pilihan_jabatan['jabatan']; ?></option>
                                <?php elseif ($data_penghubung['id_jabatan']) :
                                    $pilihan_jabatan = $this->db->get_where('jabatan_rptka', ['id_jabatan_rptka' => $data_penghubung['id_jabatan']])->row_array(); ?>
                                    <option value="<?= $pilihan_jabatan['id_jabatan_rptka']; ?>"><?= $pilihan_jabatan['jabatan']; ?></option>
                                <?php else : ?>
                                    <option value="">Select Jabatan</option>
                                <?php endif; ?>
                                <?php foreach ($data_jabatan as $jabatan) :
                                    $sisa = $jabatan->jumlah - $jabatan->terpakai;
                                    if ($sisa == 0) :
                                    else : ?>
                                        <option class="<?= $jabatan->id_rptka ?>" value="<?= $jabatan->id_jabatan_rptka; ?>"><?= $jabatan->jabatan; ?></option>
                                    <?php endif; ?>
                                    ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label">Tanggal Awal Visa</label>
                        <div class="col-sm-10">
                            <?php if (set_value('tgl_awal')) : ?>
                                <input name="tgl_awal" id="tgl_awal" type="date" value="<?= set_value('tgl_awal'); ?>" class="form-control" required>
                            <?php elseif ($data_visa['tgl_awal']) : ?>
                                <input name="tgl_awal" id="tgl_awal" type="date" value="<?= date('Y-m-d', $data_visa['tgl_awal']); ?>" class="form-control" required>
                            <?php else : ?>
                                <input name="tgl_awal" id="tgl_awal" type="date" class="form-control" required>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label">Jangka Waktu Visa (Bulan)</label>
                        <div class="col-sm-10">
                            <?php if (set_value('waktu_visa')) : ?>
                                <input name="waktu_visa" id="waktu_visa" type="number" placeholder="Jangka Waktu Visa" value="<?= set_value('waktu_visa'); ?>" class="form-control" required>
                            <?php elseif ($data_visa['waktu_visa']) : ?>
                                <input name="waktu_visa" id="waktu_visa" type="number" placeholder="Jangka Waktu Visa" value="<?= $data_visa['waktu_visa']; ?>" class="form-control" required>
                            <?php else : ?>
                                <input name="waktu_visa" id="waktu_visa" type="number" placeholder="Jangka Waktu Visa" class="form-control" required>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label">No KITAS</label>
                        <div class="col-sm-10">
                            <?php if (set_value('no_kitas')) : ?>
                                <input name="no_kitas" id="no_kitas" type="text" placeholder="No KITAS" value="<?= set_value('no_kitas'); ?>" class="form-control" required>
                            <?php elseif ($data_visa['no_kitas']) : ?>
                                <input name="no_kitas" id="no_kitas" type="text" placeholder="No KITAS" value="<?= $data_visa['no_kitas']; ?>" class="form-control" required>
                            <?php else : ?>
                                <input name="no_kitas" id="no_kitas" type="text" placeholder="No KITAS" class="form-control" required>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label">Tanggal Expired Visa</label>
                        <div class="col-sm-10">
                            <?php if (set_value('tgl_expired')) : ?>
                                <input name="tgl_expired" id="tgl_expired" type="date" value="<?= set_value('tgl_expired'); ?>" class="form-control" required>
                            <?php elseif ($data_visa['tgl_expired']) : ?>
                                <input name="tgl_expired" id="tgl_expired" type="date" value="<?= date('Y-m-d', $data_visa['tgl_expired']); ?>" class="form-control" required>
                            <?php else : ?>
                                <input name="tgl_expired" id="tgl_expired" type="date" class="form-control" required>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="passport" class="col-sm-2 col-form-label">No Notifikasi</label>
                        <div class="col-sm-10">
                            <?php if (set_value('no_notifikasi')) : ?>
                                <input name="no_notifikasi" id="no_notifikasi" type="text" placeholder="No Notifikasi" value="<?= set_value('no_notifikasi'); ?>" class="form-control" required>
                            <?php elseif ($data_visa['no_notifikasi']) : ?>
                                <input name="no_notifikasi" id="no_notifikasi" type="text" placeholder="No Notifikasi" value="<?= $data_visa['no_notifikasi']; ?>" class="form-control" required>
                            <?php else : ?>
                                <input name="no_notifikasi" id="no_notifikasi" type="text" placeholder="No Notifikasi" class="form-control" required>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <?php if (set_value('ket')) : ?>
                                <input name="ket" id="ket" type="text" placeholder="Keterangan" value="<?= set_value('ket'); ?>" class="form-control" required>
                            <?php elseif ($data_visa['ket']) : ?>
                                <input name="ket" id="ket" type="text" placeholder="Keterangan" value="<?= $data_visa['ket']; ?>" class="form-control" required>
                            <?php else : ?>
                                <input name="ket" id="ket" type="text" placeholder="Keterangan" class="form-control" required>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="position-relative row form-check">
                        <div class="right">
                            <button type="submit" class="btn btn-success"><?= $button; ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jquery-1.10.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.chained.min.js') ?>"></script>
<script>
    $("#jabatan_rptka").chained("#no_rptka");
</script>