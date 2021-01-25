<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data Visa
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Visa</th>
                            <th class="text-center">Visa Aktif</th>
                            <th class="text-center">Visa Non-Aktif</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $this->db->select('id_penghubung_visa312');
                            $this->db->from('penghubung_visa312');
                            $this->db->where('status', 'Aktif');
                            $query = $this->db->get();
                            $data = $query->result_array();
                            $jumlah_aktif_312 = count($data);
                            $this->db->select('id_penghubung_visa211');
                            $this->db->from('penghubung_visa211');
                            $this->db->where('status', 'Aktif');
                            $query = $this->db->get();
                            $data = $query->result_array();
                            $jumlah_aktif_211 = count($data);
                            $jumlah_visa_aktif = $jumlah_aktif_211 + $jumlah_aktif_312;
                            $this->db->select('id_penghubung_visa312');
                            $this->db->from('penghubung_visa312');
                            $this->db->where('status !=', 'Aktif');
                            $query = $this->db->get();
                            $data = $query->result_array();
                            $jumlah_non_312 = count($data);
                            $this->db->select('id_penghubung_visa211');
                            $this->db->from('penghubung_visa211');
                            $this->db->where('status !=', 'Aktif');
                            $query = $this->db->get();
                            $data = $query->result_array();
                            $jumlah_non_211 = count($data);
                            $jumlah_visa_non = $jumlah_non_211 + $jumlah_non_312;

                            $no = 1;
                            ?>
                            <td class="text-center"><?= $no; ?></td>
                            <td class="text-center">All</td>
                            <td class="text-center"><?= $jumlah_visa_aktif; ?></td>
                            <td class="text-center"><?= $jumlah_visa_non; ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('Data_Visa/visa_all/'); ?>" class="badge badge-success">Detail</a>
                            </td>
                        </tr>
                        <?php $no = 2;
                        foreach ($data_jenis_visa as $jenis_visa) :
                            if (($jenis_visa['id'] == 1) or ($jenis_visa['id'] == 2)) :
                            else : ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><?= $jenis_visa['visa']; ?></td>
                                    <?php if ($jenis_visa['kategori_id'] == 1) :
                                        $this->db->select('id_penghubung_visa312');
                                        $this->db->from('penghubung_visa312');
                                        $this->db->where('id_jenis_visa', $jenis_visa['id']);
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
                            endif;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>