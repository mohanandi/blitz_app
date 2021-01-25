<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Tambah Jenis Proses
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" method="POST">
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Nama Proses</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('nama_proses')) : ?>
                                <input name="nama_proses" id="nama_proses" value="<?= set_value('nama_proses'); ?>" type="text" placeholder="Nama Proses Voucher" class="form-control">
                            <?php elseif ($data_proses['nama_proses']) : ?>
                                <input name="nama_proses" id="nama_proses" value="<?= $data_proses['nama_proses']; ?>" type="text" placeholder="Nama Proses Voucher" class="form-control">
                            <?php else : ?>
                                <input name="nama_proses" id="nama_proses" value="" type="text" placeholder="Nama Proses Voucher" class="form-control">
                            <?php endif; ?>
                            <?= form_error('nama_proses'); ?>
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