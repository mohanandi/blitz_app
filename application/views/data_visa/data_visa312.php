<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <button id="filter" class="btn btn-primary btn-sm rounded-0" type="button">Filter</button>

                <?php if (set_value('sampai') && (set_value('nama_pt'))) : ?>
                    <form class="btn-actions-pane-right mb-2 mr-2" action="<?= base_url('Export/export_visa312'); ?>" method="POST">
                        <input name="dari" id="dari" placeholder="Filter Dari" value="<?= set_value('dari'); ?>" type="hidden" class=" form-control">
                        <input name="sampai" id="sampai" value="<?= set_value('sampai'); ?>" type="hidden" class="form-control">
                        <input name="id_pt" id="id_pt" value="<?= set_value('nama_pt'); ?>" type="hidden" class="form-control">
                        <input name="id_visa" id="id_visa" value="<?= $data_jenis_visa['id']; ?>" type="hidden" class="form-control">
                        <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="EXPORT <?= $subjudul; ?>"><i class="fa fa-download" aria-hidden="true"></i></button>
                    </form>
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
            <div class="card-header"><?= $subjudul; ?>
                <a href="<?= base_url('Data_Visa/filter_tka_visa312/'); ?><?= $data_jenis_visa['id']; ?>" type="button" class="btn-actions-pane-right mb-2 mr-2 btn btn-primary">Tambah Data <?= $subjudul; ?></a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Perusahaan</th>
                            <th class="text-center">No Passport</th>
                            <th class="text-center">Nama Latin</th>
                            <th class="text-center">Tanggal Awal Visa</th>
                            <th class="text-center">Tanggal Expired Visa</th>
                            <th class="text-center">No RPTKA</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (set_value('nama_pt')) :
                            $no = 1;
                            foreach ($data_pengguna_visa as $data_pengguna) :
                                $data_visa = $this->db->get_where('visa_312', ['id_penghubung_visa' => $data_pengguna['id_penghubung_visa312']])->row_array();
                                $this->db->select(array('id', 'nama_latin', 'passport', 'id_pt'));
                                $this->db->from('tka');
                                $this->db->where('id', $data_pengguna['id_tka']);
                                $query_tka = $this->db->get();
                                $data_tka = $query_tka->row_array();
                                $this->db->select('nama_pt');
                                $this->db->from('pt');
                                $this->db->where('id', $data_pengguna['id_pt']);
                                $query_pt = $this->db->get();
                                $data_pt = $query_pt->row_array();
                                if (($data_visa['tgl_input'] >= $dari) and ($data_visa['tgl_input'] <= $sampai)) {
                        ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                                        <td class="text-center"><?= $data_tka['passport']; ?></td>
                                        <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                                        <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_awal']); ?></td>
                                        <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_expired']); ?></td>
                                        <td class="text-center"><?= $data_pengguna['id_rptka']; ?></td>
                                        <td class="text-center"><?= $data_pengguna['id_jabatan']; ?></td>
                                        <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_input']); ?></td>
                                        <td class="text-center"><?= $data_visa['input_by_id']; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('Data_Visa/spesifik_visa312/') . $data_pengguna['id_penghubung_visa312']; ?>" class="badge badge-success">Detail</a>
                                        </td>
                                    </tr>
                                <?php $no++;
                                } else {
                                }
                            endforeach;
                        else :
                            $no = 1;
                            foreach ($data_pengguna_visa as $data_pengguna) :
                                $data_visa = $this->db->get_where('visa_312', ['id_penghubung_visa' => $data_pengguna['id_penghubung_visa312']])->row_array();
                                $this->db->select(array('id', 'nama_latin', 'passport', 'id_pt'));
                                $this->db->from('tka');
                                $this->db->where('id', $data_pengguna['id_tka']);
                                $query_tka = $this->db->get();
                                $data_tka = $query_tka->row_array();
                                $this->db->select('nama_pt');
                                $this->db->from('pt');
                                $this->db->where('id', $data_pengguna['id_pt']);
                                $query_pt = $this->db->get();
                                $data_pt = $query_pt->row_array();
                                $this->db->select('no_rptka');
                                $this->db->from('rptka');
                                $this->db->where('id', $data_pengguna['id_rptka']);
                                $query_rptka = $this->db->get();
                                $data_rptka = $query_rptka->row_array();
                                $this->db->select('jabatan');
                                $this->db->from('jabatan_rptka');
                                $this->db->where('id_jabatan_rptka', $data_pengguna['id_jabatan']);
                                $query_jabatan = $this->db->get();
                                $data_jabatan = $query_jabatan->row_array();
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                                    <td class="text-center"><?= $data_tka['passport']; ?></td>
                                    <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                                    <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_awal']); ?></td>
                                    <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_expired']); ?></td>
                                    <td class="text-center"><?= $data_rptka['no_rptka']; ?></td>
                                    <td class="text-center"><?= $data_jabatan['jabatan']; ?></td>
                                    <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_input']); ?></td>
                                    <td class="text-center"><?= $data_visa['input_by_id']; ?></td>
                                    <td class="text-center">
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" href="<?= base_url('Data_Visa/spesifik_visa312/') . $data_pengguna['id_penghubung_visa312']; ?>" title="Detail"><i class="fas fa-pencil-alt"></i></a>
                                                <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="<?= base_url('Data_Visa/delete_visa312/') . $data_pengguna['id_penghubung_visa312'] ?>" title="Delete"><i class="fa fa-trash"></i></button>
                                            </li>
                                        </ul>
                                        <!-- <a href="<?= base_url('Data_Visa/spesifik_visa312/') . $data_pengguna['id_penghubung_visa312']; ?>" class="badge badge-success">Detail</a> -->
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

<script>
    $('.action-delete').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You Will delete this data !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                window.location.href = $(this).data('href');
            }
        })
    });
</script>