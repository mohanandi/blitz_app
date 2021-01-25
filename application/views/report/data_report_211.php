<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Data <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data <?= $subjudul; ?> Reminder <?= $batas; ?>
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
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Input By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_penghubung_visa as $penghubung_visa) :
                            $data_visa = $this->db->get_where('visa_211', ['id_penghubung' => $penghubung_visa['id_penghubung_visa211']])->row_array();
                            $this->db->select(array('id', 'nama_latin', 'passport', 'id_pt'));
                            $this->db->from('tka');
                            $this->db->where('id', $penghubung_visa['id_tka']);
                            $query_tka = $this->db->get();
                            $data_tka = $query_tka->row_array();
                            $this->db->select('nama_pt');
                            $this->db->from('pt');
                            $this->db->where('id', $penghubung_visa['id_pt']);
                            $query_pt = $this->db->get();
                            $data_pt = $query_pt->row_array();
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                                <td class="text-center"><?= $data_tka['passport']; ?></td>
                                <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                                <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_awal']); ?></td>
                                <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_expired']); ?></td>
                                <?php
                                $this->db->select('nama');
                                $this->db->from('user');
                                $this->db->where('id', $data_visa['input_by_id']);
                                $query_input = $this->db->get();
                                $data_input = $query_input->row_array();
                                ?>
                                <td class="text-center"><?= $data_visa['ket']; ?></td>
                                <td class="text-center"><?= date('d-m-Y', $data_visa['tgl_input']); ?></td>
                                <td class="text-center"><?= $data_input['nama']; ?></td>
                                <td class="text-center">
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" href="<?= base_url('Data_Visa/spesifik_visa211/'); ?><?= $penghubung_visa['id_penghubung_visa211']; ?>" title="Detail"><i class="fas fa-pencil-alt"></i></a>
                                            <button class="btn btn-danger btn-sm rounded-0 action-delete" type="button" data-toggle="tooltip" data-placement="top" data-href="<?= base_url('Home/nonaktifkan211/') . $penghubung_visa['id_penghubung_visa211'] . '/' . $batas; ?>" title="Nonaktifkan"><i class="fa fa-ban"></i></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        endforeach;
                        ?>
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
            text: "You Will deactivate this data !",
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