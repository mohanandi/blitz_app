<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <button id="filter" class="btn btn-primary btn-sm rounded-0" type="button">Filter</button>

                <?php if (set_value('sampai') && (set_value('nama_pt'))) : ?>
                    <!-- <form class="btn-actions-pane-right mb-2 mr-2" action="<?= base_url('Export/export_visa211'); ?>" method="POST">
                        <input name="dari" id="dari" placeholder="Filter Dari" value="<?= set_value('dari'); ?>" type="hidden" class=" form-control">
                        <input name="sampai" id="sampai" value="<?= set_value('sampai'); ?>" type="hidden" class="form-control">
                        <input name="id_pt" id="id_pt" value="<?= set_value('nama_pt'); ?>" type="hidden" class="form-control">
                        <input name="id_visa" id="id_visa" value="<?= $data_jenis_visa['id']; ?>" type="hidden" class="form-control">
                        <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="Export <?= $data_jenis_visa['visa']; ?>"><i class="fa fa-download" aria-hidden="true"></i></button>
                    </form> -->
                <?php endif; ?>
            </div>
            <div class="table-responsive" id="filter_box" style="padding: 20px;">
                <form class="" action="" method="POST">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleEmail11" class=""><b>Dari</b></label>
                                <input name="dari" id="dari" placeholder="Filter Dari" value="<?= set_value('dari'); ?>" type="date" class=" form-control" required>
                                <?= form_error('dari'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="examplePassword11" class=""><b>Sampai</b></label>
                                <input name="sampai" id="sampai" value="<?= set_value('sampai'); ?>" type="date" class="form-control" required>
                                <?= form_error('sampai'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleAddress" class=""><b>Nama Perusahaan</b></label>
                        <select class="form-control" id="nama_pt" name="nama_pt">
                            <?php if (set_value('nama_pt')) :
                                if (set_value('nama_pt') == 'Semua Perusahaan') : ?>
                                    <option value="<?= set_value('nama_pt'); ?>"> <?= set_value('nama_pt'); ?></option>
                                <?php else :
                                    $perusahaan = $this->db->get_where('pt', ['id' => set_value('nama_pt')])->row_array();
                                ?>
                                    <option value="<?= set_value('nama_pt'); ?>"> <?= $perusahaan['nama_pt']; ?></option>
                                <?php endif;
                            else : ?>
                                <option value="">Select Perusahaan</option>
                            <?php endif; ?>
                            <option value="Semua Perusahaan">Semua Perusahaan</option>
                            <?php foreach ($data_pt as $pt) : ?>
                                <option value="<?= $pt['id']; ?>"><?= $pt['nama_pt']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('nama_pt'); ?>
                    </div>
                    <div class="position-relative row form-check">
                        <div class="right">
                            <button type="submit" class="btn btn-success">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data RPTKA
                <a type="button" href="<?= base_url('Data_Rptka/tambah'); ?>" class="btn-actions-pane-right mb-2 mr-2 btn btn-primary">Tambah RPTKA</a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama PT</th>
                            <th class="text-center">Nomor RPTKA</th>
                            <th class="text-center">Tanggal Terbit</th>
                            <th class="text-center">Tanggal Expired</th>
                            <th class="text-center">Jumlah RPTKA</th>
                            <th class="text-center">RPTKA Terpakai</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (set_value('nama_pt')) :
                            $no = 1;
                            foreach ($data_rptka as $rptka) :
                                if (($rptka['tgl_input'] >= $dari) and ($rptka['tgl_input'] <= $sampai)) { ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <?php $data_pt = $this->db->select('nama_pt')->get_where('pt', ['id' => $rptka['id_pt']])->row_array(); ?>
                                        <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                                        <td class="text-center"><?= $rptka['no_rptka']; ?></td>
                                        <td class="text-center"><?= date('d-m-Y', $rptka['tgl_terbit']); ?></td>
                                        <td class="text-center"><?= date('d-m-Y', $rptka['tgl_expired']); ?></td>
                                        <td class="text-center"><?= $rptka['jumlah_rptka']; ?></td>
                                        <td class="text-center"><?= $rptka['jumlah_terpakai']; ?></td>
                                        <td class="text-center"><?= $rptka['ket']; ?></td>
                                        <?php $data_user = $this->db->select('nama')->get_where('user', ['id' => $rptka['input_by_id']])->row_array(); ?>
                                        <td class="text-center"><?= $data_user['nama']; ?></td>
                                        <td class="text-center"><?= date('d-m-Y', $rptka['tgl_input']); ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('Data_Rptka/detail/') ?><?= $rptka['id']; ?>" class="badge badge-success">Detail</a>
                                        </td>
                                    </tr>
                                <?php $no++;
                                } else {
                                } ?>
                            <?php
                            endforeach;
                        else :
                            $no = 1;
                            foreach ($data_rptka as $rptka) : ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <?php $data_pt = $this->db->select('nama_pt')->get_where('pt', ['id' => $rptka['id_pt']])->row_array(); ?>
                                    <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                                    <td class="text-center"><?= $rptka['no_rptka']; ?></td>
                                    <td class="text-center"><?= date('d-m-Y', $rptka['tgl_terbit']); ?></td>
                                    <td class="text-center"><?= date('d-m-Y', $rptka['tgl_expired']); ?></td>
                                    <td class="text-center"><?= $rptka['jumlah_rptka']; ?></td>
                                    <td class="text-center"><?= $rptka['jumlah_terpakai']; ?></td>
                                    <td class="text-center"><?= $rptka['ket']; ?></td>
                                    <?php $data_user = $this->db->select('nama')->get_where('user', ['id' => $rptka['input_by_id']])->row_array(); ?>
                                    <td class="text-center"><?= $data_user['nama']; ?></td>
                                    <td class="text-center"><?= date('d-m-Y', $rptka['tgl_input']); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('Data_Rptka/detail/') ?><?= $rptka['id']; ?>" class="badge badge-success">Detail</a>
                                    </td>
                                </tr>
                        <?php $no++;
                            endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#filter_box").hide();
    });
    $('#filter').click(function() {
        $("#filter_box").toggle();
    });
</script>