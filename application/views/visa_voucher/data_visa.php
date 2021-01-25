<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Jenis Visa Berhasil <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data Jenis Visa
                <a class="btn-actions-pane-right mb-2 mr-2 btn btn-primary" href="<?= base_url('Jenis_Visa/tambah'); ?>" type="button">Tambah Visa</a>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Visa</th>
                            <th class="text-center">Status RPTKA</th>
                            <th class="text-center">Syarat Visa Sebelumnya</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_jenis_visa as $jenis_visa) :
                            if (($jenis_visa['id'] == '1') or ($jenis_visa['id'] == '2')) :
                            else :
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><?= $jenis_visa['visa']; ?></td>
                                    <?php $jenis_select = $this->db->get_where('kategori_visa', ['id_kategori' => $jenis_visa['kategori_id']])->row_array(); ?>
                                    <td class="text-center"><?= $jenis_select['status']; ?></td>
                                    <?php $jenis_select = $this->db->get_where('jenis_visa', ['id' => $jenis_visa['id_visa_sebelumnya']])->row_array(); ?>
                                    <td class="text-center"><?= $jenis_select['visa']; ?></td>
                                    <?php $jenis_select = $this->db->get_where('user', ['id' => $jenis_visa['input_by_id']])->row_array(); ?>
                                    <td class="text-center"><?= $jenis_select['nama']; ?></td>
                                    <td class="text-center"><?= date('d-m-Y', $jenis_visa['tgl_input']); ?></td>
                                    <td class="text-center">
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a href="<?= base_url('Jenis_Visa/edit/'); ?><?= $jenis_visa['id']; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="<?= base_url('Jenis_Visa/hapus/'); ?><?= $jenis_visa['id']; ?>" title="Delete"><i class="fa fa-trash"></i></button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                        <?php
                            endif;
                            $no++;
                        endforeach; ?>
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