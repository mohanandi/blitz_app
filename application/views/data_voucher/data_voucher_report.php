<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Data <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Filter
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" action="" method="POST">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleEmail11" class=""><b>Dari</b></label>
                                <input name="kewarganegaraan" id="kewarganegaraan" placeholder="Kewarganegaraan" type="date" class=" form-control">
                                <?= form_error('kewarganegaraan'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="examplePassword11" class=""><b>Sampai</b></label>
                                <input name="tgl_lahir" id="tgl_lahir" type="date" class="form-control">
                                <?= form_error('tgl_lahir'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleAddress" class=""><b>Nama Perusahaan</b></label>
                        <select class="form-control" id="nama_pt" name="nama_pt">
                            <option value="">Select Perusahaan</option>
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
            <div class="card-header">
                <form action="<?= base_url('Export/export_voucher'); ?>" method="POST">
                    <input type="hidden">
                    <button class="btn-actions-pane-right mb-2 mr-2 btn btn-primary" type="submit">Export</button>
                </form>
                <span class="btn-actions-pane-right mb-2 mr-2">Data Voucher</span>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">No Voucher</th>
                            <th class="text-center">Nama PT</th>
                            <th class="text-center">Jumlah Data</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Status Invoice</th>
                            <th class="text-center">Input By</th>
                            <th class="text-center">Tanggal Input</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_id_voucher as $id_voucher) :
                            $data_voucher = $this->db->get_where('voucher_visa', ['id_voucher' => $id_voucher['id_voucher']])->row_array();
                            if ($data_voucher['mata_uang'] == 'Rupiah') {
                                $harga = "Rp " . number_format($data_voucher['total_harga'], 2, ',', '.');
                            } else {
                                $harga = "$ " . number_format($data_voucher['total_harga'], 2, '.', ',');
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center"><?= $data_voucher['kode_voucher']; ?></td>
                                <?php $this->db->select('nama_pt');
                                $this->db->from('pt');
                                $this->db->where('id', $data_voucher['id_pt']);
                                $query_pt = $this->db->get();
                                $data_pt = $query_pt->row_array();
                                $this->db->select('nama');
                                $this->db->from('user');
                                $this->db->where('id', $data_voucher['input_by_id']);
                                $query_input_by = $this->db->get();
                                $data_input_by = $query_input_by->row_array();
                                $this->db->select('id_invoice');
                                $this->db->from('invoice_voucher_visa');
                                $this->db->where('id_voucher_visa', $data_voucher['id_voucher']);
                                $query_invoice = $this->db->get();
                                $data_invoice = $query_invoice->row_array();
                                ?>
                                <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                                <td class="text-center"><?= $data_voucher['jumlah_data']; ?></td>
                                <td class="text-center"><?= $harga; ?></td>
                                <?php if ($data_invoice) : ?>
                                    <td class="text-center"><?= $data_invoice['invoice']; ?></td>
                                <?php else : ?>
                                    <td class="text-center"><span class="badge badge-secondary">Belum Ada Invoice</span></td>
                                <?php endif; ?>
                                <td class="text-center"><?= $data_input_by['nama']; ?></td>
                                <td class="text-center"><?= date('d-m-Y', $data_voucher['tgl_input']); ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('Data_Voucher/detail/') ?><?= $data_voucher['id_voucher'] ?>" class="badge badge-success">Detail</a>
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