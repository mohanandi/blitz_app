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
                        <?php $no = 1;
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
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>