<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><?= $subjudul; ?>
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" method="POST">
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label"><b>Nama</b></label>
                        <div class="col-sm-10">
                            <input type="hidden" value="<?= $data_voucher['id_voucher']; ?>" name="id_voucher" id="id_voucher">
                            <?php if (set_value('nama')) : ?>
                                <input name="nama" id="nama" value="<?= set_value('nama'); ?>" placeholder="Nama" type="text" class="form-control">
                            <?php elseif ($data_pengguna_voucher['nama']) : ?>
                                <input name="nama" id="nama" value="<?= $data_pengguna_voucher['nama']; ?>" placeholder="Nama" type="text" class="form-control">
                            <?php else : ?>
                                <input name="nama" id="nama" value="<?= set_value('nama'); ?>" placeholder="Nama" type="text" class="form-control">
                            <?php endif; ?>
                            <?= form_error('nama') ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Jenis Proses</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('jenis_proses')) : ?>
                                <input name="jenis_proses" id="jenis_proses" value="<?= set_value('jenis_proses'); ?>" placeholder="Input Jenis Proses" type="text" class="form-control">
                            <?php elseif ($data_pengguna_voucher['jenis_proses']) : ?>
                                <input name="jenis_proses" id="jenis_proses" value="<?= $data_pengguna_voucher['jenis_proses']; ?>" placeholder="Input Jenis Proses" type="text" class="form-control">
                            <?php else : ?>
                                <input name="jenis_proses" id="jenis_proses" value="<?= set_value('jenis_proses'); ?>" placeholder="Input Jenis Proses" type="text" class="form-control">
                            <?php endif; ?>
                            <?= form_error('jenis_proses') ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Harga</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('nama')) : ?>
                                <input name="harga" id="harga" value="<?= set_value('harga'); ?>" placeholder="Input Harga" type="number" class="form-control">
                            <?php elseif ($data_pengguna_voucher['harga']) : ?>
                                <input name="harga" id="harga" value="<?= $data_pengguna_voucher['harga']; ?>" placeholder="Input Harga" type="text" class="form-control">
                            <?php else : ?>
                                <input name="harga" id="harga" value="<?= set_value('harga'); ?>" placeholder="Input Harga" type="number" class="form-control">
                            <?php endif; ?>
                            <?= form_error('harga') ?>
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