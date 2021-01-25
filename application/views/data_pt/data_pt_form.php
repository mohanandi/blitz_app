<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <?= $subjudul; ?>
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" action="" method="post">
                    <div class="position-relative row form-group">
                        <label for="namapt" class="col-sm-2 col-form-label"><b>Nama PT</b></label>
                        <?php if ($data_pt['id']) : ?>
                            <input name="id_pt" id="id_pt" type="hidden" value="<?= $data_pt['id']; ?>" class=" form-control">
                        <?php else : ?>
                        <?php endif; ?>
                        <div class="col-sm-10">
                            <?php if (set_value('nama_pt')) : ?>
                                <input name="nama_pt" id="nama_pt" value="<?= set_value('nama_pt') ?>" type="text" class="form-control" placeholder="Nama PT">
                            <?php elseif ($data_pt['nama_pt']) : ?>
                                <input name="nama_pt" id="nama_pt" value="<?= $data_pt['nama_pt'] ?>" type="text" class="form-control" placeholder="Nama PT">
                            <?php else : ?>
                                <input name="nama_pt" id="nama_pt" type="text" class="form-control" placeholder="Nama PT">
                            <?php endif; ?>
                            <?= form_error('nama_pt', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="pic" class="col-sm-2 col-form-label"><b>PIC</b></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="pic" name="pic">
                                <?php if (set_value('pic')) :
                                    $data_pic = $this->db->get_where('user', ['id' => set_value('pic')])->row_array();
                                ?>
                                    <option value="<?= set_value('pic'); ?>"> <?= $data_pic['nama']; ?></option>
                                <?php elseif ($data_pt['id_pic']) :
                                    $data_pic = $this->db->get_where('user', ['id' => $data_pt['id_pic']])->row_array();
                                ?>
                                    <option value="<?= $data_pic['id']; ?>"> <?= $data_pic['nama']; ?></option>
                                <?php else : ?>
                                    <option value="">Select PIC</option>
                                <?php endif; ?>
                                <?php foreach ($pic as $pj) : ?>
                                    <option value="<?= $pj['id']; ?>"><?= $pj['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('pic', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="client" class="col-sm-2 col-form-label"><b>Nama Client</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('client')) :  ?>
                                <input name="client" id="client" type="text" value="<?= set_value('client'); ?>" placeholder="Nama Client" class="form-control">
                            <?php elseif ($data_pt['nama_client']) :  ?>
                                <input name="client" id="client" type="text" value="<?= $data_pt['nama_client']; ?>" placeholder="Nama Client" class="form-control">
                            <?php else :  ?>
                                <input name="client" id="client" type="text" placeholder="Nama Client" class="form-control">
                            <?php endif;  ?>
                            <?= form_error('client', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="alamat" class="col-sm-2 col-form-label"><b>Alamat</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('alamat')) :  ?>
                                <input name="alamat" id="alamat" type="text" value="<?= set_value('alamat'); ?>" placeholder="Alamat" class="form-control">
                            <?php elseif ($data_pt['alamat']) :  ?>
                                <input name="alamat" id="alamat" type="text" value="<?= $data_pt['alamat']; ?>" placeholder="Alamat" class="form-control">
                            <?php else :  ?>
                                <input name="alamat" id="alamat" type="text" placeholder="Alamat" class="form-control">
                            <?php endif;  ?>
                            <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="keterangan" class="col-sm-2 col-form-label"><b>Keterangan</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('ket')) :  ?>
                                <input name="ket" id="ket" type="text" value="<?= set_value('ket'); ?>" placeholder="Keterangan" class="form-control">
                            <?php elseif ($data_pt['ket']) :  ?>
                                <input name="ket" id="ket" type="text" value="<?= $data_pt['ket']; ?>" placeholder="Keterangan" class="form-control">
                            <?php else :  ?>
                                <input name="ket" id="ket" type="text" placeholder="Keterangan" class="form-control">
                            <?php endif;  ?>
                            <?= form_error('ket', '<small class="text-danger pl-3">', '</small>'); ?>
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