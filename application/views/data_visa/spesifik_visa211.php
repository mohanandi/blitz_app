<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Data <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data TKA
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Mandarin</th>
                            <th class="text-center">Nama Latin</th>
                            <th class="text-center">Passport</th>
                            <th class="text-center">Perusahaan</th>
                            <th class="text-center">Expired Passport</th>
                            <th class="text-center">Tanggal Lahir</th>
                            <th class="text-center">Kewarganegaraan</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $this->db->select('nama_pt');
                            $this->db->from('pt');
                            $this->db->where('id', $data_tka['id_pt']);
                            $query = $this->db->get();
                            $data_pt = $query->row_array();
                            $this->db->select('nama');
                            $this->db->from('user');
                            $this->db->where('id', $data_tka['input_by_id']);
                            $query = $this->db->get();
                            $data_input = $query->row_array();
                            ?>
                            <td class="text-center"><?= $data_tka['nama_mandarin']; ?></td>
                            <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                            <td class="text-center"><?= $data_tka['passport']; ?></td>
                            <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_tka['expired_passport']); ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_tka['tgl_lahir']); ?></td>
                            <td class="text-center"><?= $data_tka['kewarganegaraan']; ?></td>
                            <td class="text-center"><?= $data_tka['ket']; ?></td>
                            <td class="text-center"><?= $data_input['nama']; ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_tka['tgl_input']); ?></td>
                            <td class="text-center">
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                        <a href="" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
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
        <?php
        $this->db->select('visa');
        $this->db->from('jenis_visa');
        $this->db->where('id', $data_penghubung_visa['id_jenis_visa']);
        $query = $this->db->get();
        $jenis_visa = $query->row_array();
        $this->db->select('nama');
        $this->db->from('user');
        $this->db->where('id', $data_tka['input_by_id']);
        $query = $this->db->get();
        $data_input = $query->row_array();
        ?>
        <div class="main-card mb-3 card">
            <div class="card-header">Data visa <?= $jenis_visa['visa']; ?>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-center">Visa</th>
                            <th class="text-center">Tanggal Awal Visa</th>
                            <th class="text-center">Tanggal Expired Visa</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?= $jenis_visa['visa']; ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_awal']); ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_expired']); ?></td>
                            <td class="text-center"><?= $data_penghubung_visa['status']; ?></td>
                            <td class="text-center"><?= $data_visa['ket']; ?></td>
                            <td class="text-center"><?= $data_input['nama']; ?></td>
                            <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_input']); ?></td>
                            <td class="text-center">
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                        <a href="<?= base_url('Data_Visa/edit_data_visa211/') . $data_penghubung_visa['id_penghubung_visa211']; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="" title="Delete"><i class="fa fa-trash"></i></button>
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