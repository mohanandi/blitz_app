<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Data <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data RPTKA
                <a class="btn-actions-pane-right mb-2 mr-2 btn btn-primary" href="<?= base_url('Export/export_rptka/' . $data_rptka['id']); ?>" type="button" type="button" data-toggle="tooltip" data-placement="top" title="Export"><i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Perusahaan</th>
                            <th class="text-center">Nomor RPTKA</th>
                            <th class="text-center">Tanggal Terbit</th>
                            <th class="text-center">Tanggal Expired</th>
                            <th class="text-center">Jumlah RPTKA</th>
                            <th class="text-center">RPTKA Terpakai</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $this->db->select('nama_pt');
                            $this->db->from('pt');
                            $this->db->where('id', $data_rptka['id_pt']);
                            $query = $this->db->get();
                            $data_pt = $query->row_array();
                            ?>
                            <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                            <td class="text-center"><?= $data_rptka['no_rptka']; ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_rptka['tgl_terbit']); ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_rptka['tgl_expired']); ?></td>
                            <td class="text-center"><?= $data_rptka['jumlah_rptka']; ?></td>
                            <td class="text-center"><?= $data_rptka['jumlah_terpakai']; ?></td>
                            <td class="text-center"><?= $data_rptka['ket']; ?></td>
                            <td class="text-center">
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                        <a href="<?= base_url('Data_Rptka/edit/'); ?><?= $data_rptka['id']; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    </li>
                                </ul>
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
            <div class="card-header">Data Jabatan RPTKA
                <a type="button" class="btn-actions-pane-right mb-2 mr-2 btn btn-primary" type="submit" href="<?= base_url('Data_Rptka/tambah_jabatan/'); ?><?= $data_rptka['id']; ?>">Tambah Jabatan RPTKA</a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Jabatan</th>
                            <th class="text-center">Jumlah Jabatan </th>
                            <th class="text-center">Jumlah Jabatan Terpakai</th>
                            <th class="text-center">Jumlah jabatan Sisa</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        if ($data_jabatan) :
                            foreach ($data_jabatan as $jabatan) : ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><?= $jabatan['jabatan']; ?></td>
                                    <td class="text-center"><?= $jabatan['jumlah']; ?></td>
                                    <td class="text-center"><?= $jabatan['terpakai']; ?></td>
                                    <td class="text-center"><?= $jabatan['jumlah'] - $jabatan['terpakai']; ?></td>
                                    <td class="text-center">
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a href="<?= base_url('Data_Rptka/edit_jabatan/' . $jabatan['id_jabatan_rptka']); ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="" title="Delete"><i class="fa fa-trash"></i></button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php $no++;
                            endforeach;
                        else : ?>
                            <tr>
                                <td class="text-center" colspan="5">Data Jabatan Belum Ditambahkan</td>
                            </tr>
                        <?php endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data Pengguna RPTKA
            </div>
            <div class="table-responsive" style="padding: 10px; font-size:11.5px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama PT</th>
                            <th class="text-center">No Passport</th>
                            <th class="text-center">Nama Latin</th>
                            <th class="text-center">Visa</th>
                            <th class="text-center">Tanggal Awal Visa</th>
                            <th class="text-center">Tanggal Expired Visa</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_pengguna as $pengguna) :
                            $this->db->select('nama_pt');
                            $this->db->from('pt');
                            $this->db->where('id', $pengguna['id_pt']);
                            $query_pt = $this->db->get();
                            $data_pt = $query_pt->row_array();
                            $this->db->select(array('nama_latin', 'passport'));
                            $this->db->from('tka');
                            $this->db->where('id', $pengguna['id_tka']);
                            $query_tka = $this->db->get();
                            $data_tka = $query_tka->row_array();
                            $this->db->select('visa');
                            $this->db->from('jenis_visa');
                            $this->db->where('id', $pengguna['id_jenis_visa']);
                            $query_jenis_visa = $this->db->get();
                            $data_jenis_visa = $query_jenis_visa->row_array();
                            $this->db->select(array('tgl_awal', 'tgl_expired'));
                            $this->db->from('visa_312');
                            $this->db->where('id_penghubung_visa', $pengguna['id_penghubung_visa312']);
                            $query_visa = $this->db->get();
                            $data_visa = $query_visa->row_array();
                            $this->db->select('jabatan');
                            $this->db->from('jabatan_rptka');
                            $this->db->where('id_jabatan_rptka', $pengguna['id_jabatan']);
                            $query_pengguna_jabatan = $this->db->get();
                            $data_pengguna_jabatan = $query_pengguna_jabatan->row_array();
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                                <td class="text-center"><?= $data_tka['passport']; ?></td>
                                <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                                <td class="text-center"><?= $data_jenis_visa['visa']; ?></td>
                                <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_awal']); ?></td>
                                <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_expired']); ?></td>
                                <td class="text-center"><?= $data_pengguna_jabatan['jabatan']; ?></td>
                                <td class="text-center">
                                    <a href="" class="badge badge-success">Detail</a>
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