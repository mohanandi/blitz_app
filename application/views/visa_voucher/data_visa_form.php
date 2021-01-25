<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><?= $subjudul; ?>
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" method="POST">
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label">Nama Visa</label>
                        <div class="col-sm-10">
                            <?php if (set_value('nama_visa')) : ?>
                                <input name="nama_visa" id="nama_visa" value="<?= set_value('nama_visa'); ?>" placeholder="Nama Visa" type="text" class="form-control">
                            <?php elseif ($jenis_visa_detail['visa']) : ?>
                                <input name="nama_visa" id="nama_visa" value="<?= $jenis_visa_detail['visa']; ?>" placeholder="Nama Visa" type="text" class="form-control">
                            <?php else : ?>
                                <input name="nama_visa" id="nama_visa" placeholder="Nama Visa" type="text" class="form-control">
                            <?php endif; ?>

                            <?php if ($jenis_visa_detail['id']) : ?>
                                <input name="id_visa" id="id_visa" type="hidden" value="<?= $jenis_visa_detail['id']; ?>" class=" form-control">
                            <?php else : ?>
                            <?php endif; ?>
                            <?= form_error('nama_visa'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label">Status RPTKA</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="status_rptka" name="status_rptka">
                                <?php if (set_value('status_rptka')) :
                                    $kategori_select = $this->db->get_where('kategori_visa', ['id_kategori' => set_value('status_rptka')])->row_array();
                                ?>
                                    <option value="<?= set_value('status_rptka'); ?>"> <?= $kategori_select['status']; ?></option>
                                <?php elseif ($jenis_visa_detail['kategori_id']) :
                                    $kategori_select = $this->db->get_where('kategori_visa', ['id_kategori' => $jenis_visa_detail['kategori_id']])->row_array();
                                ?>
                                    <option value="<?= $kategori_select['id_kategori']; ?>"> <?= $kategori_select['status']; ?></option>
                                <?php else : ?>
                                    <option value="" selected>Select Status RPTKA</option>
                                <?php endif; ?>
                                <?php foreach ($data_kategori as $kategori) : ?>
                                    <option value="<?= $kategori->id_kategori; ?>"><?= $kategori->status; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('status_rptka'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="passport" class="col-sm-2 col-form-label">Syarat Pengisian Sebelumnya</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="visa_sebelumnya" name="visa_sebelumnya">
                                <?php if (set_value('visa_sebelumnya')) :
                                    $jenis_select = $this->db->get_where('jenis_visa', ['id' => set_value('visa_sebelumnya')])->row_array();
                                ?>
                                    <?= var_dump($jenis_select); ?>
                                    <option value="<?= set_value('visa_sebelumnya'); ?>"> <?= $jenis_select['visa']; ?></option>
                                <?php elseif ($jenis_visa_detail['id_visa_sebelumnya']) :
                                    $jenis_select = $this->db->get_where('jenis_visa', ['id' => $jenis_visa_detail['id_visa_sebelumnya']])->row_array();
                                ?>
                                    <option value="<?= $jenis_select['id']; ?>"> <?= $jenis_select['visa']; ?></option>
                                <?php else : ?>
                                    <option value="">Select Syarat Visa Sebelumnya</option>
                                <?php endif; ?>
                                <?php foreach ($data_jenis_visa as $jenis_visa) : ?>
                                    <option class="<?= $jenis_visa->kategori_id ?>" value="<?= $jenis_visa->id; ?>"><?= $jenis_visa->visa; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('visa_sebelumnya'); ?>
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
    $("#visa_sebelumnya").chained("#status_rptka");
</script>