<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><?= $subjudul; ?>
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" method="POST">
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Nama PT</b></label>
                        <?php if ($data_rptka['id']) : ?>
                            <input name="id_rptka" id="id_rptka" type="hidden" value="<?= $data_rptka['id']; ?>" class="form-control">
                        <?php else : ?>
                        <?php endif; ?>
                        <div class="col-sm-10">
                            <select class="form-control" id="nama_pt" name="nama_pt">
                                <?php if (set_value('nama_pt')) :
                                    $data_pt = $this->db->get_where('pt', ['id' => set_value('nama_pt')])->row_array();
                                ?>
                                    <option value="<?= set_value('nama_pt'); ?>"> <?= $data_pt['nama_pt']; ?></option>
                                <?php elseif ($data_rptka['id_pt']) :
                                    $data_pt = $this->db->get_where('pt', ['id' => $data_rptka['id_pt']])->row_array();
                                ?>
                                    <option value="<?= $data_pt['id']; ?>"> <?= $data_pt['nama_pt']; ?></option>
                                <?php else : ?>
                                    <option value="">Select PT</option>
                                <?php endif; ?>
                                <?php foreach ($pt as $p) : ?>
                                    <option value="<?= $p['id']; ?>"><?= $p['nama_pt']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label"><b>No RPTKA</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('no_rptka')) : ?>
                                <input name="no_rptka" id="no_rptka" type="text" value="<?= set_value('no_rptka'); ?>" class="form-control">
                            <?php elseif ($data_rptka['no_rptka']) : ?>
                                <input name="no_rptka" id="no_rptka" type="text" value="<?= $data_rptka['no_rptka']; ?>" class="form-control">
                            <?php else : ?>
                                <input name="no_rptka" id="no_rptka" type="text" value="<?= set_value('no_rptka'); ?>" class="form-control">
                            <?php endif; ?>
                            <?= form_error('no_rptka'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Tanggal Terbit</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('tgl_terbit')) : ?>
                                <input name="tgl_terbit" id="tgl_terbit" type="date" placeholder="Tanggal Terbit" value="<?= set_value('tgl_terbit'); ?>" class="form-control">
                            <?php elseif ($data_rptka['tgl_terbit']) : ?>
                                <input name="tgl_terbit" id="tgl_terbit" type="date" placeholder="Tanggal Terbit" value="<?= date('Y-m-d', $data_rptka['tgl_terbit']); ?>" class="form-control">
                            <?php else : ?>
                                <input name="tgl_terbit" id="tgl_terbit" type="date" placeholder="Tanggal Terbit" value="<?= set_value('tgl_terbit'); ?>" class="form-control">
                            <?php endif; ?>
                            <?= form_error('tgl_terbit'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="expassport" class="col-sm-2 col-form-label"><b>Tanggal Expired</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('tgl_expired')) : ?>
                                <input name="tgl_expired" id="tgl_expired" type="date" placeholder="Tanggal Expired" value="<?= set_value('tgl_expired'); ?>" class="form-control">
                            <?php elseif ($data_rptka['tgl_expired']) : ?>
                                <input name="tgl_expired" id="tgl_expired" type="date" placeholder="Tanggal Expired" value="<?= date('Y-m-d', $data_rptka['tgl_expired']); ?>" class="form-control">
                            <?php else : ?>
                                <input name="tgl_expired" id="tgl_expired" type="date" placeholder="Tanggal Expired" value="<?= set_value('tgl_expired'); ?>" class="form-control">
                            <?php endif; ?>
                            <?= form_error('tgl_expired'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="ttl" class="col-sm-2 col-form-label"><b>Jumlah Pengguna RPTKA</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('jumlah_pengguna')) : ?>
                                <input name="jumlah_pengguna" id="jumlah_pengguna" type="number" placeholder="Jumlah Pengguna RPTKA" value="<?= set_value('jumlah_pengguna'); ?>" class="form-control">
                            <?php elseif ($data_rptka['jumlah_rptka']) : ?>
                                <input name="jumlah_pengguna" id="jumlah_pengguna" type="number" placeholder="Jumlah Pengguna RPTKA" value="<?= $data_rptka['jumlah_rptka']; ?>" class="form-control">
                            <?php else : ?>
                                <input name="jumlah_pengguna" id="jumlah_pengguna" type="number" placeholder="Jumlah Pengguna RPTKA" value="<?= set_value('jumlah_pengguna'); ?>" class="form-control">
                            <?php endif; ?>
                            <?= form_error('jumlah_pengguna'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Keterangan" class="col-sm-2 col-form-label"><b>Keterangan</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('ket')) : ?>
                                <input name="ket" id="ket" type="text" value="<?= set_value('ket'); ?>" placeholder="Keterangan" class="form-control">
                            <?php elseif ($data_rptka['ket']) : ?>
                                <input name="ket" id="ket" type="text" value="<?= $data_rptka['ket']; ?>" placeholder="Keterangan" class="form-control">
                            <?php else : ?>
                                <input name="ket" id="ket" type="text" value="<?= set_value('ket'); ?>" placeholder="Keterangan" class="form-control">
                            <?php endif; ?>
                            <?= form_error('ket'); ?>
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