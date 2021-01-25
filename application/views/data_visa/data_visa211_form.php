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
                            <input name="id_pt" id="id_pt" value="<?= $data_tka['id_pt']; ?>" type="hidden" class="form-control">
                            <input name="id_visa" id="id_visa" value="<?= $data_jenis_visa['id']; ?>" type="hidden" class="form-control">
                        <?php else : ?>
                        <?php endif; ?>
                        <div class="col-sm-10">
                            <input name="nama_visa" id="nama_visa" value="<?= $data_jenis_visa['visa']; ?>" type="text" class="form-control" readonly>
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
                        <label for="passport" class="col-sm-2 col-form-label">Tanggal Expired Visa</label>
                        <div class="col-sm-10">
                            <?php if (set_value('tgl_expired')) : ?>
                                <input name="tgl_expired" id="tgl_expired" value="<?= set_value('tgl_expired'); ?>" type="date" class="form-control" required>
                            <?php elseif ($data_visa['tgl_expired']) : ?>
                                <input name="tgl_expired" id="tgl_expired" value="<?= date('Y-m-d', $data_visa['tgl_expired']); ?>" type="date" class="form-control" required>
                            <?php else : ?>
                                <input name="tgl_expired" id="tgl_expired" type="date" class="form-control" required>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <?php if (set_value('ket')) : ?>
                                <input name="ket" id="ket" type="text" value="<?= set_value('ket'); ?>" placeholder="Keterangan" class="form-control" required>
                            <?php elseif ($data_visa['ket']) : ?>
                                <input name="ket" id="ket" type="text" value="<?= $data_visa['ket']; ?>" placeholder="Keterangan" class="form-control" required>
                            <?php else : ?>
                                <input name="ket" id="ket" type="text" value="" placeholder="Keterangan" class="form-control" required>
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