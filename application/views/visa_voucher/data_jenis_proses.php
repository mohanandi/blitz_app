<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Data <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data Jenis Proses
                <a type="button" href="<?= base_url('Jenis_Voucher/tambah_jenis_proses'); ?>" class="btn-actions-pane-right mb-2 mr-2 btn btn-primary">Tambah Data Jenis Proses</a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis Proses</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_proses as $proses) :
                            $this->db->select('nama');
                            $this->db->from('user');
                            $this->db->where('id', $proses['input_by_id']);
                            $query = $this->db->get();
                            $input_by = $query->row_array();
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center"><?= $proses['nama_proses']; ?></td>
                                <td class="text-center"><?= $input_by['nama']; ?></td>
                                <td class="text-center"><?= date('d-m-Y', $proses['tgl_input']); ?></td>
                                <td class="text-center">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a href="<?= base_url('Jenis_Voucher/edit_proses/' . $proses['id_proses']); ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="<?= base_url('Jenis_Voucher/delete_proses/' . $proses['id_proses']); ?>" title="Delete"><i class="fa fa-trash"></i></button>
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
            <div class="card-header">Data Harga
                <a type="button" href="<?= base_url('Jenis_Voucher/tambah_harga'); ?>" class="btn-actions-pane-right mb-2 mr-2 btn btn-primary">Tambah Data Harga</a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover display">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis Proses</th>
                            <th class="text-center">Lokasi</th>
                            <th class="text-center">Harga (Rp)</th>
                            <th class="text-center">Harga ($)</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_harga as $harga) :
                            $this->db->select('nama_proses');
                            $this->db->from('jenis_proses');
                            $this->db->where('id_proses', $harga['id_proses']);
                            $query = $this->db->get();
                            $jenis_proses = $query->row_array();
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center"><?= $jenis_proses['nama_proses']; ?></td>
                                <td class="text-center"><?= $harga['lokasi']; ?></td>
                                <?php $rupiah = "Rp " . number_format($harga['rupiah'], 2, ',', '.'); ?>
                                <td class="text-center"><?= $rupiah; ?></td>
                                <?php $dollar = "$ " . number_format($harga['dollar'], 2, '.', ','); ?>
                                <td class="text-center"><?= $dollar; ?></td>
                                <td class="text-center">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a href="<?= base_url('Jenis_Voucher/edit_lokasi/' . $harga['id_harga']); ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="<?= base_url('Jenis_Voucher/delete_lokasi/' . $harga['id_harga']); ?>" title="Delete"><i class="fa fa-trash"></i></button>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('table.display').DataTable();
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