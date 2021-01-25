<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Data Voucher Berhasil <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data Spesifikasi Voucher <?= $data_voucher['kode_voucher']; ?>
                <a class="btn-actions-pane-right mb-2 mr-2 btn btn-primary" href="<?= base_url('Export/export_voucher_entertaint/' . $data_voucher['id_voucher']); ?>" type="button" type="button" data-toggle="tooltip" data-placement="top" title="Export"><i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="atas">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Perusahaan</th>
                            <th class="text-center">Nama Client</th>
                            <th class="text-center">Bill To</th>
                            <th class="text-center">Kategori Voucher</th>
                            <th class="text-center">Mata Uang</th>
                            <th class="text-center">Lokasi</th>
                            <th class="text-center">Staff OP</th>
                            <th class="text-center">Note</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            if ($data_voucher['mata_uang'] == 'Rupiah') {
                                $total_harga = "Rp " . number_format($data_voucher['total_harga'], 2, ',', '.');
                            } elseif ($data_voucher['mata_uang'] == 'Dollar') {
                                $total_harga = "$ " . number_format($data_voucher['total_harga'], 2, '.', ',');
                            }
                            $id_voucher = $data_voucher['id_voucher'];
                            $this->db->select('nama_pt');
                            $this->db->from('pt');
                            $this->db->where('id', $data_voucher['id_pt']);
                            $query_pt = $this->db->get();
                            $data_pt = $query_pt->row_array();
                            $this->db->select('kategori');
                            $this->db->from('kategori_voucher');
                            $this->db->where('id_kategori_voucher', $data_voucher['kategori_id']);
                            $query = $this->db->get();
                            $data_kategori = $query->row_array();
                            ?>
                            <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                            <td class="text-center"><?= $data_voucher['nama_client']; ?></td>
                            <td class="text-center"><?= $data_voucher['bill_to']; ?></td>
                            <td class="text-center"><?= $data_kategori['kategori']; ?></td>
                            <td class="text-center"><?= $data_voucher['mata_uang']; ?></td>
                            <td class="text-center"><?= $data_voucher['lokasi']; ?></td>
                            <td class="text-center"><?= $data_voucher['staff']; ?></td>
                            <td class="text-center"><?= $data_voucher['note']; ?></td>
                            <td class="text-center">
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                        <a href="<?= base_url('Data_Voucher/edit_kategori_entertaint/'); ?><?= $id_voucher; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
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
            <div class="card-header">Data Voucher
                <a class="btn-actions-pane-right mb-2 mr-2 btn btn-primary" href="<?= base_url("Data_Voucher/tambah_voucher_entertaint/$id_voucher"); ?>" type="button">Tambah Data Voucher</a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jenis Proses</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_pengguna_voucher as $pengguna_voucher) :
                            if ($data_voucher['mata_uang'] == 'Rupiah') {
                                $harga = "Rp " . number_format($pengguna_voucher['harga'], 2, ',', '.');
                            } elseif ($data_voucher['mata_uang'] == 'Dollar') {
                                $harga = "$ " . number_format($pengguna_voucher['harga'], 2, '.', ',');
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center"><?= $pengguna_voucher['nama']; ?></td>
                                <td class="text-center"><?= $pengguna_voucher['jenis_proses']; ?></td>
                                <td class="text-center"><?= $harga; ?></td>
                                <td class="text-center">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a href="<?= base_url('Data_Voucher/ubah_data_entertaint/' . $pengguna_voucher['id_pengguna_voucher_entertaint']); ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="<?= base_url('Data_Voucher/delete_data_entertaint/' . $pengguna_voucher['id_pengguna_voucher_entertaint']); ?>" title="Delete"><i class="fa fa-trash"></i></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php $no++;
                        endforeach; ?>
                        <tr>
                            <td class="text-center" colspan="4"><b>Total</b></td>
                            <td class="text-center" colspan="2"><?= $total_harga; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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