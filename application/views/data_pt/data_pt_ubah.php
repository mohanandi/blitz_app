<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Edit Data PT
            </div>

            <div class="table-responsive" style="padding: 20px;">

                <form class="" action="<?= base_url('Data_Pt/ubah'); ?>" method="post">
                    <input type="hidden" name="id" value="<?= $pt['id']; ?>">
                    <div class="position-relative row form-group"><label for="namapt" class="col-sm-2 col-form-label">Nama PT</label>
                        <div class="col-sm-10">
                            <input name="namapt" id="namapt" type="text" class="form-control" value="<?= $pt['nama_pt'] ?>">

                            <?= form_error('namapt', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="pic" class="col-sm-2 col-form-label">PIC</label>
                        <div class="col-sm-10">
                            <input name="pic" id="pic" type="text" class="form-control" value="<?= $pt['pic'] ?>">
                            <?= form_error('pic', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="client" class="col-sm-2 col-form-label">Nama Client</label>
                        <div class="col-sm-10">
                            <input name="client" id="client" type="text" class="form-control" value="<?= $pt['nama_client'] ?>">
                            <?= form_error('client', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input name="alamat" id="alamat" type="text" class="form-control" value="<?= $pt['alamat'] ?>">
                            <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input name="keterangan" id="keterangan" type="text" class="form-control" value="<?= $pt['keterangan'] ?>">
                            <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="position-relative row form-check">
                        <div class="right">
                            <button type="submit" name="ubah" class="btn btn-success">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>