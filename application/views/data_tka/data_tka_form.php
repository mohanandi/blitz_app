<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><?= $subjudul; ?>
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" action="" method="POST">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleEmail11" class=""><b>Nama Mandarin</b></label>
                                <?php if (set_value('nama_mandarin')) : ?>
                                    <input name="nama_mandarin" id="nama_mandarin" placeholder="Nama Mandarin" type="text" value="<?= set_value('nama_mandarin'); ?>" class=" form-control">
                                <?php elseif ($tka['nama_mandarin']) : ?>
                                    <input name="nama_mandarin" id="nama_mandarin" placeholder="Nama Mandarin" type="text" value="<?= $tka['nama_mandarin']; ?>" class=" form-control">
                                <?php else : ?>
                                    <input name="nama_mandarin" id="nama_mandarin" placeholder="Nama Mandarin" type="text" class=" form-control">
                                <?php endif; ?>

                                <?php if ($tka['id']) : ?>
                                    <input name="id_tka" id="id_tka" type="hidden" value="<?= $tka['id']; ?>" class=" form-control">
                                <?php else : ?>
                                <?php endif; ?>
                                <?= form_error('nama_mandarin'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="examplePassword11" class=""><b>Nama Latin</b></label>
                                <?php if (set_value('nama_latin')) : ?>
                                    <input name="nama_latin" id="nama_latin" placeholder="Nama Latin" type="text" value="<?= set_value('nama_latin'); ?>" class=" form-control">
                                <?php elseif ($tka['nama_latin']) : ?>
                                    <input name="nama_latin" id="nama_latin" placeholder="Nama Latin" type="text" value="<?= $tka['nama_latin']; ?>" class=" form-control">
                                <?php else : ?>
                                    <input name="nama_latin" id="nama_latin" placeholder="Nama Latin" type="text" class=" form-control">
                                <?php endif; ?>
                                <?= form_error('nama_latin'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleEmail11" class=""><b>Kewarganegaraan</b></label>
                                <?php if (set_value('kewarganegaraan')) : ?>
                                    <input name="kewarganegaraan" id="kewarganegaraan" placeholder="Kewarganegaraan" type="text" value="<?= set_value('kewarganegaraan'); ?>" class=" form-control">
                                <?php elseif ($tka['kewarganegaraan']) : ?>
                                    <input name="kewarganegaraan" id="kewarganegaraan" placeholder="Kewarganegaraan" type="text" value="<?= $tka['kewarganegaraan']; ?>" class=" form-control">
                                <?php else : ?>
                                    <input name="kewarganegaraan" id="kewarganegaraan" placeholder="Kewarganegaraan" type="text" class=" form-control">
                                <?php endif; ?>
                                <?= form_error('kewarganegaraan'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="examplePassword11" class=""><b>Tanggal Lahir</b></label>
                                <?php if (set_value('tgl_lahir')) : ?>
                                    <input name="tgl_lahir" id="tgl_lahir" value="<?= set_value('tgl_lahir'); ?>" type="date" class="form-control">
                                <?php elseif ($tka['tgl_lahir']) : ?>
                                    <input name="tgl_lahir" id="tgl_lahir" value="<?= date('Y-m-d', $tka['tgl_lahir']); ?>" type="date" class="form-control">
                                <?php else : ?>
                                    <input name="tgl_lahir" id="tgl_lahir" type="date" class="form-control">
                                <?php endif; ?>
                                <?= form_error('tgl_lahir'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleEmail11" class=""><b>Passport</b></label>
                                <?php if (set_value('passport')) : ?>
                                    <input name="passport" id="passport" value="<?= set_value('passport'); ?>" placeholder="No Passport" type="text" class="form-control">
                                <?php elseif ($tka['passport']) : ?>
                                    <input name="passport" id="passport" value="<?= $tka['passport']; ?>" placeholder="No Passport" type="text" class="form-control">
                                <?php else : ?>
                                    <input name="passport" id="passport" placeholder="No Passport" type="text" class="form-control">
                                <?php endif; ?>
                                <?= form_error('passport'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="examplePassword11" class=""><b>Expired Passport</b></label>
                                <?php if (set_value('exp_passport')) : ?>
                                    <input name="exp_passport" value="<?= set_value('exp_passport'); ?>" id="exp_passport" type="date" class="form-control">
                                <?php elseif ($tka['expired_passport']) : ?>
                                    <input name="exp_passport" value="<?= date('Y-m-d', $tka['expired_passport']); ?>" id="exp_passport" type="date" class="form-control">
                                <?php else : ?>
                                    <input name="exp_passport" id="exp_passport" type="date" class="form-control">
                                <?php endif; ?>
                                <?= form_error('exp_passport'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleAddress" class=""><b>Nama PT</b></label>
                        <select class="form-control" id="nama_pt" name="nama_pt">
                            <?php if (set_value('nama_pt')) :
                                $data_pt = $this->db->get_where('pt', ['id' => set_value('nama_pt')])->row_array();
                            ?>
                                <option value="<?= set_value('nama_pt'); ?>"> <?= $data_pt['nama_pt']; ?></option>
                            <?php elseif ($tka['id_pt']) :
                                $data_pt = $this->db->get_where('pt', ['id' => $tka['id_pt']])->row_array();
                            ?>
                                <option value="<?= $data_pt['id']; ?>"> <?= $data_pt['nama_pt']; ?></option>
                            <?php else : ?>
                                <option value="">Select PT</option>
                            <?php endif; ?>
                            <?php foreach ($pt as $p) : ?>
                                <option value="<?= $p['id']; ?>"><?= $p['nama_pt']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('nama_pt'); ?>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleAddress" class=""><b>Keterangan</b></label>
                        <?php if (set_value('ket')) : ?>
                            <input name="ket" id="ket" value="<?= set_value('ket'); ?>" placeholder="Keterangan" type="text" class="form-control">
                        <?php elseif ($tka['ket']) : ?>
                            <input name="ket" id="ket" value="<?= $tka['ket']; ?>" placeholder="Keterangan" type="text" class="form-control">
                        <?php else : ?>
                            <input name="ket" id="ket" placeholder="Keterangan" type="text" class="form-control">
                        <?php endif; ?>
                        <?= form_error('ket'); ?>
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