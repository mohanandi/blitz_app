<?php if ($this->session->flashdata('flash')) : ?>
    <div class="alert alert-success fade show" role="alert">Data Berhasil <?= $this->session->flashdata('flash'); ?> .</div>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Profil TKA
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Mandarin</th>
                            <th>Nama Latin</th>
                            <th>Passport</th>
                            <th>Perusahaan</th>
                            <th>Expired Passport</th>
                            <th>Tanggal Lahir</th>
                            <th>Kewarganegaraan</th>
                            <th>Keterangan</th>
                            <th>Input By</th>
                            <th>Tanggal Input</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $tka['nama_mandarin']; ?></td>
                            <td><?= $tka['nama_latin']; ?></td>
                            <td><?= $tka['passport']; ?></td>
                            <td><?= $pt['nama_pt']; ?></td>
                            <td><?= date('d-m-Y', $tka['expired_passport']); ?></td>
                            <td><?= date('d-m-Y', $tka['tgl_lahir']); ?></td>
                            <td><?= $tka['ket']; ?></td>
                            <td><?= $tka['kewarganegaraan']; ?></td>
                            <td><?= $user['nama']; ?></td>
                            <td><?= date('d-m-Y', $tka['tgl_input']); ?></td>
                            <td><a href="<?= base_url('Data_Tka/edit/') ?><?= $tka['id']; ?>" class="badge badge-secondary">Edit</a></td>
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
            <div class="card-header">Riwayat Visa
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama Visa</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Expired</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($riwayat_visa211 as $visa211) : ?>
                            <tr>
                                <?php
                                $this->db->select('visa');
                                $this->db->from('jenis_visa');
                                $this->db->where('id', $visa211['id_jenis_visa']);
                                $query = $this->db->get();
                                $data_jenis_visa = $query->row_array();
                                $this->db->select('*');
                                $this->db->from('visa_211');
                                $this->db->where('id_penghubung', $visa211['id_penghubung_visa211']);
                                $query = $this->db->get();
                                $data_visa = $query->row_array();
                                $this->db->select('nama_pt');
                                $this->db->from('pt');
                                $this->db->where('id', $visa211['id_pt']);
                                $query = $this->db->get();
                                $data_pt = $query->row_array();
                                ?>
                                <td><?= $no; ?></td>
                                <td><?= $data_pt['nama_pt']; ?></td>
                                <td><?= $data_jenis_visa['visa']; ?></td>
                                <td><?= date('d-m-Y', $data_visa['tgl_awal']); ?></td>
                                <td><?= date('d-m-Y', $data_visa['tgl_expired']); ?></td>
                                <td><?= $visa211['status']; ?></td>
                                <td>
                                    <a>Detail</a>
                                </td>
                            </tr>
                        <?php $no++;
                        endforeach; ?>
                        <?php foreach ($riwayat_visa312 as $visa312) : ?>
                            <tr>
                                <?php
                                $this->db->select('visa');
                                $this->db->from('jenis_visa');
                                $this->db->where('id', $visa312['id_jenis_visa']);
                                $query = $this->db->get();
                                $data_jenis_visa = $query->row_array();
                                $this->db->select('*');
                                $this->db->from('visa_312');
                                $this->db->where('id_penghubung_visa', $visa312['id_penghubung_visa312']);
                                $query = $this->db->get();
                                $data_visa = $query->row_array();
                                $this->db->select('nama_pt');
                                $this->db->from('pt');
                                $this->db->where('id', $visa312['id_pt']);
                                $query = $this->db->get();
                                $data_pt = $query->row_array();
                                ?>
                                <td><?= $no; ?></td>
                                <td><?= $data_pt['nama_pt']; ?></td>
                                <td><?= $data_jenis_visa['visa']; ?></td>
                                <td><?= date('d-m-Y', $data_visa['tgl_awal']); ?></td>
                                <td><?= date('d-m-Y', $data_visa['tgl_expired']); ?></td>
                                <td><?= $visa312['status']; ?></td>
                                <td>
                                    <a>Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Riwayat Voucher
            </div>

            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover display">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Perusahaan</th>
                            <th class="text-center">Kode Voucher</th>
                            <th class="text-center">Jenis Proses</th>
                            <th class="text-center">Tanggal Input Voucher</th>
                            <th class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($riwayat_voucher as $voucher) :
                            $data_voucher = $this->db->get_where('voucher_visa', ['id_voucher' => $voucher['id_voucher_visa']])->row_array();
                            $data_pt = $this->db->get_where('pt', ['id' => $data_voucher['id_pt']])->row_array();
                            $data_proses = $this->db->get_where('jenis_proses', ['id_proses' => $data_voucher['id_jenis_proses']])->row_array();
                        ?>
                            <tr>
                                <td class="text-center text-muted"><?= $no; ?></td>
                                <td class="text-center"><?= $data_pt['nama_pt']; ?></td>
                                <td class="text-center"><?= $data_voucher['kode_voucher']; ?></td>
                                <td class="text-center"><?= $data_proses['nama_proses']; ?></td>
                                <td class="text-center"><?= date('d-m-Y', $data_voucher['tgl_input']); ?></td>
                                <td class="text-center">
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