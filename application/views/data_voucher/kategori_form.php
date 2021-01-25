<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><?= $subjudul; ?>
            </div>
            <?php if ($dirubah == 'yes') {
                $require = '';
            } else {
                $require = 'readonly';
            } ?>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" method="POST">
                    <input type="hidden" id="dirubah" name="dirubah" value="<?= $dirubah; ?>">
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Nama Perusahaan</b></label>
                        <div class="col-sm-10">
                            <select name="nama_pt" id="nama_pt" class="form-control" <?= $require; ?>>
                                <?php if (set_value('nama_pt')) :
                                    $pt_pilihan = $this->db->select('nama_pt')->get_where('pt', ['id' => set_value('nama_pt')])->row_array();
                                ?>
                                    <option value="<?= set_value('nama_pt'); ?>"><?= $pt_pilihan['nama_pt']; ?></option>
                                <?php elseif ($data_voucher['id_pt']) :
                                    $pt_pilihan = $this->db->select('nama_pt')->get_where('pt', ['id' => $data_voucher['id_pt']])->row_array();
                                ?>
                                    <option value="<?= $data_voucher['id_pt']; ?>"><?= $pt_pilihan['nama_pt']; ?></option>
                                <?php else : ?>
                                    <option value="">Select Perusahaan</option>
                                <?php endif; ?>
                                <?php if ($dirubah == 'yes') {
                                    foreach ($data_pt as $pt) : ?>
                                        <option value="<?= $pt['id']; ?>"><?= $pt['nama_pt']; ?></option>
                                <?php endforeach;
                                } else {
                                } ?>

                            </select>
                            <?= form_error('nama_pt'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Nama Client</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('nama_client')) : ?>
                                <input type="text" name="nama_client" id="nama_client" placeholder="Nama Client" class="form-control" value="<?= set_value('nama_client'); ?>">
                            <?php elseif ($data_voucher['nama_client']) : ?>
                                <input type="text" name="nama_client" id="nama_client" placeholder="Nama Client" class="form-control" value="<?= $data_voucher['nama_client']; ?>">
                            <?php else : ?>
                                <input type="text" name="nama_client" id="nama_client" placeholder="Nama Client" class="form-control">
                            <?php endif; ?>
                            <?= form_error('nama_client'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Bill To</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('bill_to')) : ?>
                                <input type="text" name="bill_to" id="bill_to" placeholder="Bill To" class="form-control" value="<?= set_value('bill_to'); ?>">
                            <?php elseif ($data_voucher['bill_to']) : ?>
                                <input type="text" name="bill_to" id="bill_to" placeholder="Bill To" class="form-control" value="<?= $data_voucher['bill_to']; ?>">
                            <?php else : ?>
                                <input type="text" name="bill_to" id="bill_to" placeholder="Bill To" class="form-control">
                            <?php endif; ?>
                            <?= form_error('bill_to'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label"><b>Kategori</b></label>
                        <div class="col-sm-10">
                            <select name="kategori" id="kategori" class="form-control" <?= $require; ?>>
                                <?php if (set_value('kategori')) :
                                    $kategori_pilihan = $this->db->select('kategori')->get_where('kategori_voucher', ['id_kategori_voucher' => set_value('kategori')])->row_array();
                                ?>
                                    <option value="<?= set_value('kategori'); ?>"><?= $kategori_pilihan['kategori']; ?></option>
                                <?php elseif ($data_voucher['kategori_id']) :
                                    $kategori_pilihan = $this->db->select('kategori')->get_where('kategori_voucher', ['id_kategori_voucher' => $data_voucher['kategori_id']])->row_array();
                                ?>
                                    <option value="<?= $data_voucher['kategori_id']; ?>"><?= $kategori_pilihan['kategori']; ?></option>
                                <?php else : ?>
                                    <option value="">Select Kategori</option>
                                <?php endif; ?>
                                <?php if ($dirubah == 'yes') {
                                    foreach ($data_kategori as $kategori) : ?>
                                        <option value="<?= $kategori['id_kategori_voucher']; ?>"><?= $kategori['kategori']; ?></option>
                                <?php endforeach;
                                } else {
                                } ?>

                            </select>
                            <?= form_error('kategori'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group" id="kategori_select">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Jenis Proses</b></label>
                        <div class="col-sm-10">
                            <select name="jenis_proses" id="jenis_proses" class="form-control">
                                <?php if (set_value('jenis_proses')) :
                                    $proses_pilihan = $this->db->select('nama_proses')->get_where('jenis_proses', ['id_proses' => set_value('jenis_proses')])->row_array();
                                ?>
                                    <option value="<?= set_value('jenis_proses'); ?>"><?= $proses_pilihan['nama_proses']; ?></option>
                                <?php elseif ($kategori_batas == 'visa') :
                                    $proses_pilihan = $this->db->select('nama_proses')->get_where('jenis_proses', ['id_proses' => $data_voucher['id_jenis_proses']])->row_array();
                                ?>
                                    <option value="<?= $data_voucher['id_jenis_proses']; ?>"><?= $proses_pilihan['nama_proses']; ?></option>
                                <?php else : ?>
                                    <option value="">Select Jenis Proses</option>
                                <?php endif; ?>
                                <?php foreach ($data_jenis_proses as $proses) : ?>
                                    <option value="<?= $proses->id_proses; ?>"><?= $proses->nama_proses; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('jenis_proses'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group" id="kategori_select2">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Lokasi</b></label>
                        <div class="col-sm-10">
                            <select name="lokasi" id="lokasi" class="form-control">
                                <?php if (set_value('lokasi')) :
                                    $lokasi_pilihan = $this->db->select('lokasi')->get_where('harga', ['id_harga' => set_value('lokasi')])->row_array();
                                ?>
                                    <option value="<?= set_value('lokasi'); ?>"><?= $lokasi_pilihan['lokasi']; ?></option>
                                <?php elseif ($kategori_batas == 'visa') :
                                    $lokasi_pilihan = $this->db->select('lokasi')->get_where('harga', ['id_harga' => $data_voucher['id_lokasi']])->row_array();
                                ?>
                                    <option value="<?= $data_voucher['id_lokasi']; ?>"><?= $lokasi_pilihan['lokasi']; ?></option>
                                <?php else : ?>
                                    <option value="">Select Lokasi</option>
                                <?php endif; ?>
                                <?php foreach ($data_lokasi as $lokasi) : ?>
                                    <option class="<?= $lokasi->id_proses ?>" value="<?= $lokasi->id_harga; ?>"><?= $lokasi->lokasi; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('lokasi'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group" id="kategori3">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Lokasi</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('lokasi_entertaint')) : ?>
                                <input type="text" id="lokasi_entertaint" name="lokasi_entertaint" placeholder="Input Lokasi" class="form-control" value="<?= set_value('lokasi_entertaint'); ?>">
                            <?php elseif ($kategori_batas == 'entertaint') : ?>
                                <input type="text" id="lokasi_entertaint" name="lokasi_entertaint" placeholder="Input Lokasi" class="form-control" value="<?= $data_voucher['lokasi']; ?>">
                            <?php else : ?>
                                <input type="text" id="lokasi_entertaint" name="lokasi_entertaint" placeholder="Input Lokasi" class="form-control" value="<?= set_value('lokasi_entertaint'); ?>">
                            <?php endif; ?>
                            <?= form_error('lokasi_entertaint'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Mata Uang</b></label>
                        <div class="col-sm-10">
                            <select name="mata_uang" id="mata_uang" class="form-control">
                                <?php if (set_value('mata_uang')) : ?>
                                    <option value="<?= set_value('mata_uang'); ?>"><?= set_value('mata_uang'); ?></option>
                                <?php elseif ($data_voucher['mata_uang']) : ?>
                                    <option value="<?= $data_voucher['mata_uang']; ?>"><?= $data_voucher['mata_uang']; ?></option>
                                <?php else : ?>
                                    <option value="">Select Mata Uang</option>
                                <?php endif; ?>
                                <option value="Dollar">Dollar</option>
                                <option value="Rupiah">Rupiah</option>
                            </select>
                            <?= form_error('mata_uang'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Staff OP</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('nama_client')) : ?>
                                <input type="text" id="staff" name="staff" placeholder="Staff Operattion" class="form-control" value="<?= set_value('staff'); ?>">
                            <?php elseif ($data_voucher['staff']) : ?>
                                <input type="text" id="staff" name="staff" placeholder="Staff Operattion" class="form-control" value="<?= $data_voucher['staff']; ?>">
                            <?php else : ?>
                                <input type="text" id="staff" name="staff" placeholder="Staff Operattion" class="form-control" value="">
                            <?php endif; ?>
                            <?= form_error('staff'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Note</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('nama_client')) : ?>
                                <input type="text" id="note" name="note" placeholder="Note" class="form-control" value="<?= set_value('note'); ?>">
                            <?php elseif ($data_voucher['note']) : ?>
                                <input type="text" id="note" name="note" placeholder="Note" class="form-control" value="<?= $data_voucher['note']; ?>">
                            <?php else : ?>
                                <input type="text" id="note" name="note" placeholder="Note" class="form-control">
                            <?php endif; ?>
                            <?= form_error('note'); ?>
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
    $("#lokasi").chained("#jenis_proses");
    $(document).ready(function() {
        var kategori_selected = $("#kategori").val();
        if (kategori_selected == '1') {
            $("#kategori_select").show();
            $("#kategori_select2").show();
            $("#kategori3").hide();
        } else {
            $("#kategori_select").hide();
            $("#kategori_select2").hide();
            $("#kategori3").show();
        }
        // $("#kategori_select").hide();
        // $("#kategori_select2").hide();
    });


    $('#kategori').change(function() {
        var kategori_selected = $("#kategori").val();
        if (kategori_selected == '1') {
            $("#kategori_select").show();
            $("#kategori_select2").show();
            $("#kategori3").hide();
        } else {
            $("#kategori_select").hide();
            $("#kategori_select2").hide();
            $("#kategori3").show();
        }
    });
</script>