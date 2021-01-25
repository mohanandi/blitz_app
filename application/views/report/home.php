<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Expired Schedules Data Visa
                <div class="btn-actions-pane-right">
                </div>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Visa</th>
                            <th class="text-center">Expired</th>
                            <th class="text-center">Satu Minggu</th>
                            <th class="text-center">Dua Minggu</th>
                            <th class="text-center">Tiga Minggu</th>
                            <th class="text-center">Satu Bulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_visa as $visa) : ?>
                            <tr>
                                <td class="text-center text-muted"><?= $visa['visa']; ?></td>
                                <?php if ($visa['kategori_id'] == 1) {
                                    $expired = $this->db->from('penghubung_visa312')
                                        ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
                                        ->where('penghubung_visa312.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa312.status', 'Aktif')
                                        ->where('visa_312.tgl_expired <', time())
                                        ->get()
                                        ->num_rows();
                                    $seminggu = $this->db->from('penghubung_visa312')
                                        ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
                                        ->where('penghubung_visa312.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa312.status', 'Aktif')
                                        ->where('visa_312.tgl_expired >=', time())
                                        ->where('visa_312.tgl_expired <=', (time() + (60 * 60 * 24 * 7)))
                                        ->get()
                                        ->num_rows();
                                    $duaminggu = $this->db->from('penghubung_visa312')
                                        ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
                                        ->where('penghubung_visa312.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa312.status', 'Aktif')
                                        ->where('visa_312.tgl_expired >=', time())
                                        ->where('visa_312.tgl_expired <=', (time() + (60 * 60 * 24 * 14)))
                                        ->get()
                                        ->num_rows();
                                    $tigaminggu = $this->db->from('penghubung_visa312')
                                        ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
                                        ->where('penghubung_visa312.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa312.status', 'Aktif')
                                        ->where('visa_312.tgl_expired >=', time())
                                        ->where('visa_312.tgl_expired <=', (time() + (60 * 60 * 24 * 21)))
                                        ->get()
                                        ->num_rows();
                                    $sebulan = $this->db->from('penghubung_visa312')
                                        ->join('visa_312', 'visa_312.id_penghubung_visa=penghubung_visa312.id_penghubung_visa312')
                                        ->where('penghubung_visa312.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa312.status', 'Aktif')
                                        ->where('visa_312.tgl_expired >=', time())
                                        ->where('visa_312.tgl_expired <=', (time() + (60 * 60 * 24 * 30)))
                                        ->get()
                                        ->num_rows();
                                } else {
                                    $expired = $this->db->from('penghubung_visa211')
                                        ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
                                        ->where('penghubung_visa211.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa211.status', 'Aktif')
                                        ->where('visa_211.tgl_expired <', time())
                                        ->get()
                                        ->num_rows();
                                    $seminggu = $this->db->from('penghubung_visa211')
                                        ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
                                        ->where('penghubung_visa211.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa211.status', 'Aktif')
                                        ->where('visa_211.tgl_expired >=', time())
                                        ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 7)))
                                        ->get()
                                        ->num_rows();
                                    $duaminggu = $this->db->from('penghubung_visa211')
                                        ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
                                        ->where('penghubung_visa211.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa211.status', 'Aktif')
                                        ->where('visa_211.tgl_expired >=', time())
                                        ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 14)))
                                        ->get()
                                        ->num_rows();
                                    $tigaminggu = $this->db->from('penghubung_visa211')
                                        ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
                                        ->where('penghubung_visa211.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa211.status', 'Aktif')
                                        ->where('visa_211.tgl_expired >=', time())
                                        ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 21)))
                                        ->get()
                                        ->num_rows();
                                    $sebulan = $this->db->from('penghubung_visa211')
                                        ->join('visa_211', 'visa_211.id_penghubung=penghubung_visa211.id_penghubung_visa211')
                                        ->where('penghubung_visa211.id_jenis_visa', $visa['id'])
                                        ->where('penghubung_visa211.status', 'Aktif')
                                        ->where('visa_211.tgl_expired >=', time())
                                        ->where('visa_211.tgl_expired <=', (time() + (60 * 60 * 24 * 30)))
                                        ->get()
                                        ->num_rows();
                                }
                                ?>
                                <td class="text-center">
                                    <a href="<?= base_url('Home/expired/') . $visa['id']; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Detail"><?= $expired; ?></a>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('Home/seminggu/') . $visa['id']; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Detail"><?= $seminggu; ?></a>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('Home/duaminggu/') . $visa['id']; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Detail"><?= $duaminggu; ?></a>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('Home/tigaminggu/') . $visa['id']; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Detail"><?= $tigaminggu; ?></a>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('Home/sebulan/') . $visa['id']; ?>" class="btn btn-light btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Detail"><?= $sebulan; ?></a>
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
<!-- <div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card-shadow-danger mb-3 widget-chart widget-chart2 text-left card">
            <div class="widget-content">
                <div class="widget-content-outer">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left pr-2 fsize-1">
                            <div class="widget-numbers mt-0 fsize-3 text-danger">71%</div>
                        </div>
                        <div class="widget-content-right w-100">
                            <div class="progress-bar-xs progress">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100" style="width: 71%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left fsize-1">
                        <div class="text-muted opacity-6">Income Target</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-shadow-success mb-3 widget-chart widget-chart2 text-left card">
            <div class="widget-content">
                <div class="widget-content-outer">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left pr-2 fsize-1">
                            <div class="widget-numbers mt-0 fsize-3 text-success">54%</div>
                        </div>
                        <div class="widget-content-right w-100">
                            <div class="progress-bar-xs progress">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left fsize-1">
                        <div class="text-muted opacity-6">Expenses Target</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-shadow-warning mb-3 widget-chart widget-chart2 text-left card">
            <div class="widget-content">
                <div class="widget-content-outer">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left pr-2 fsize-1">
                            <div class="widget-numbers mt-0 fsize-3 text-warning">32%</div>
                        </div>
                        <div class="widget-content-right w-100">
                            <div class="progress-bar-xs progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100" style="width: 32%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left fsize-1">
                        <div class="text-muted opacity-6">Spendings Target</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card-shadow-info mb-3 widget-chart widget-chart2 text-left card">
            <div class="widget-content">
                <div class="widget-content-outer">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left pr-2 fsize-1">
                            <div class="widget-numbers mt-0 fsize-3 text-info">89%</div>
                        </div>
                        <div class="widget-content-right w-100">
                            <div class="progress-bar-xs progress">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left fsize-1">
                        <div class="text-muted opacity-6">Totals Target</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->