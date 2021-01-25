<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Tambah Data Harga
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" method="POST">
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Jenis Proses</b></label>
                        <div class="col-sm-10">
                            <select name="jenis_proses" id="jenis_proses" class="form-control">
                                <?php if (set_value('jenis_proses')) :
                                    $data_jenis_proses = $this->db->get_where('jenis_proses', ['id_proses' => set_value('jenis_proses')])->row_array();
                                ?>
                                    <option value="<?= set_value('jenis_proses'); ?>"> <?= $data_jenis_proses['nama_pt']; ?></option>
                                <?php elseif ($data_lokasi['id_proses']) :
                                    $data_jenis_proses = $this->db->get_where('jenis_proses', ['id_proses' => $data_lokasi['id_proses']])->row_array();
                                ?>
                                    <option value="<?= $data_jenis_proses['id_proses']; ?>"> <?= $data_jenis_proses['nama_proses']; ?></option>
                                <?php else : ?>
                                    <option value="">Select Proses</option>
                                <?php endif; ?>
                                <?php foreach ($data_proses as $proses) : ?>
                                    <option value="<?= $proses['id_proses']; ?>"><?= $proses['nama_proses']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label"><b>Lokasi</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('lokasi')) : ?>
                                <input name="lokasi" id="lokasi" value="<?= set_value('lokasi'); ?>" placeholder="Lokasi" type="text" class="form-control">
                            <?php elseif ($data_lokasi['lokasi']) : ?>
                                <input name="lokasi" id="lokasi" value="<?= $data_lokasi['lokasi']; ?>" placeholder="Lokasi" type="text" class="form-control">
                            <?php else : ?>
                                <input name="lokasi" id="lokasi" value="" placeholder="Lokasi" type="text" class="form-control">
                            <?php endif; ?>
                            <?= form_error('lokasi') ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Harga (Rupiah)</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('rupiah')) : ?>
                                <input name="rupiah" id="rupiah" value="<?= set_value('rupiah'); ?>" placeholder="Rupiah" type="number" class="form-control">
                            <?php elseif ($data_lokasi['rupiah']) : ?>
                                <input name="rupiah" id="rupiah" value="<?= $data_lokasi['rupiah']; ?>" placeholder="Rupiah" type="number" class="form-control">
                            <?php else : ?>
                                <input name="rupiah" id="rupiah" value="" placeholder="Rupiah" type="number" class="form-control">
                            <?php endif; ?>
                            <?= form_error('rupiah') ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="expassport" class="col-sm-2 col-form-label"><b>Harga (Dollar)</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('dollar')) : ?>
                                <input name="dollar" id="dollar" value="<?= set_value('dollar'); ?>" placeholder="Dollar" type="number" class="form-control">
                            <?php elseif ($data_lokasi['dollar']) : ?>
                                <input name="dollar" id="dollar" value="<?= $data_lokasi['dollar']; ?>" placeholder="Dollar" type="number" class="form-control">
                            <?php else : ?>
                                <input name="dollar" id="dollar" value="" placeholder="Dollar" type="number" class="form-control">
                            <?php endif; ?>
                            <?= form_error('dollar') ?>
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