<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Data Berhasil <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Profile Perusahaan
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Perusahaan</th>
                            <th class="text-center">PIC</th>
                            <th class="text-center">Nama Client</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                            <td class="text-center"><?= $data_pic['nama']; ?></td>
                            <td class="text-center"><?= $data_pt['nama_client']; ?></td>
                            <td class="text-center"><?= $data_pt['alamat']; ?></td>
                            <td class="text-center"><?= $data_pt['ket']; ?></td>
                            <td class="text-center"><?= $input_by['nama']; ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_pt['tgl_input']); ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('Data_Pt/edit/'); ?><?= $data_pt['id']; ?>" class="badge badge-secondary">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data TKA Perusahaan
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Mandarin</th>
                            <th class="text-center">Nama Latin</th>
                            <th class="text-center">Passport</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_tka as $tka) : ?>
                            <tr>
                                <td class="text-center text-muted"><?= $no; ?></td>
                                <td class="text-center"><?= $tka['nama_mandarin']; ?></td>
                                <td class="text-center"><?= $tka['nama_latin']; ?></td>
                                <td class="text-center"><?= $tka['passport']; ?></td>
                                <td class="text-center"><?= $tka['ket']; ?></td>
                                <?php $user = $this->db->get_where('user', ['id' => $tka['input_by_id']])->row_array(); ?>
                                <td class="text-center"><?= $user['nama']; ?></td>
                                <td class="text-center"><?= date('d-m-Y', $tka['tgl_input']); ?></td>
                                <td class="text-center">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a href="<?= base_url('Data_Tka/edit_jabatan/' . $tka['id']); ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="" title="Delete"><i class="fa fa-trash"></i></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data Visa dan RPTKA Perusahaan
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover display">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Visa</th>
                            <th class="text-center">Jumlah Aktif</th>
                            <th class="text-center">Jumlah Non-Aktif</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_jenis_visa as $jenis_visa) : ?>
                            <tr>
                                <td class="text-center text-muted"><?= $no; ?></td>
                                <td class="text-center"><?= $jenis_visa['visa']; ?></td>
                                <?php if ($jenis_visa['kategori_id'] == 1) :
                                    $this->db->select('id_penghubung_visa312');
                                    $this->db->from('penghubung_visa312');
                                    $this->db->where('id_jenis_visa', $jenis_visa['id']);
                                    $this->db->where('id_pt', $data_pt['id']);
                                    $this->db->where('status', 'Aktif');
                                    $query = $this->db->get();
                                    $data = $query->result_array();
                                    $jumlah_aktif = count($data);
                                ?>
                                    <td class="text-center"><?= $jumlah_aktif; ?></td>
                                    <?php
                                    $this->db->select('id_penghubung_visa312');
                                    $this->db->from('penghubung_visa312');
                                    $this->db->where('id_jenis_visa', $jenis_visa['id']);
                                    $this->db->where('id_pt', $data_pt['id']);
                                    $this->db->where('status !=', 'Aktif');
                                    $query = $this->db->get();
                                    $data = $query->result_array();
                                    $jumlah_non = count($data);
                                    ?>
                                    <td class="text-center"><?= $jumlah_non; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('Data_Visa/visa312/') ?><?= $jenis_visa['id']; ?>" class="badge badge-success">Detail</a>
                                    </td>
                                <?php elseif ($jenis_visa['kategori_id'] == 2) :
                                    $this->db->select('id_penghubung_visa211');
                                    $this->db->from('penghubung_visa211');
                                    $this->db->where('id_jenis_visa', $jenis_visa['id']);
                                    $this->db->where('id_pt', $data_pt['id']);
                                    $this->db->where('status', 'Aktif');
                                    $query = $this->db->get();
                                    $data = $query->result_array();
                                    $jumlah_aktif = count($data);
                                ?>
                                    <td class="text-center"><?= $jumlah_aktif; ?></td>
                                    <?php
                                    $this->db->select('id_penghubung_visa211');
                                    $this->db->from('penghubung_visa211');
                                    $this->db->where('id_jenis_visa', $jenis_visa['id']);
                                    $this->db->where('id_pt', $data_pt['id']);
                                    $this->db->where('status !=', 'Aktif');
                                    $query = $this->db->get();
                                    $data = $query->result_array();
                                    $jumlah_non = count($data);
                                    ?>
                                    <td class="text-center"><?= $jumlah_non; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('Data_Visa/visa211/') ?><?= $jenis_visa['id']; ?>" class="badge badge-success">Detail</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Jumlah Voucher
                <button class="btn-actions-pane-right mb-2 mr-2 btn btn-success" data-toggle="modal" data-target="#exampleModal2">Tambah Voucher</button>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-left" style="font-size: 30px; color: green;"><?= $jumlah_voucher; ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('table.display').DataTable();
    });
</script>