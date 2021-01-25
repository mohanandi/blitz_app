<!-- <div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Pie Chart</h5>
                <canvas id="canvas"></canvas>
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Radar Chart</h5>
                <canvas id="radar-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Doughnut</h5>
                <canvas id="doughnut-chart"></canvas>
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Polar Chart</h5>
                <canvas id="polar-chart"></canvas>
            </div>
        </div>
    </div>
</div> -->
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <button id="filter" class="btn btn-primary btn-sm rounded-0 action-delete" type="button">Filter</button>

                <?php if (set_value('sampai') && (set_value('nama_pt'))) : ?>
                    <form class="btn-actions-pane-right mb-2 mr-2" action="<?= base_url('Export/export_voucher'); ?>" method="POST">
                        <input name="dari" id="dari" placeholder="Filter Dari" value="<?= set_value('dari'); ?>" type="hidden" class=" form-control">
                        <input name="sampai" id="sampai" value="<?= set_value('sampai'); ?>" type="hidden" class="form-control">
                        <input name="id_pt" id="id_pt" value="<?= set_value('nama_pt'); ?>" type="hidden" class="form-control">
                        <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="top" title="Export"><i class="fa fa-download" aria-hidden="true"></i></button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="table-responsive" id="filter_box" style="padding: 20px;">
                <form class="" action="" method="POST">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="exampleEmail11" class=""><b>Dari</b></label>
                                <input name="dari" id="dari" placeholder="Filter Dari" value="<?= set_value('dari'); ?>" type="date" class=" form-control" required>
                                <?= form_error('dari'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="examplePassword11" class=""><b>Sampai</b></label>
                                <input name="sampai" id="sampai" value="<?= set_value('sampai'); ?>" type="date" class="form-control" required>
                                <?= form_error('sampai'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="exampleAddress" class=""><b>Nama Perusahaan</b></label>
                        <select class="form-control" id="nama_pt" name="nama_pt">
                            <?php if (set_value('nama_pt')) :
                                if (set_value('nama_pt') == 'Semua Perusahaan') : ?>
                                    <option value="<?= set_value('nama_pt'); ?>"> <?= set_value('nama_pt'); ?></option>
                                <?php else :
                                    $perusahaan = $this->db->get_where('pt', ['id' => set_value('nama_pt')])->row_array();
                                ?>
                                    <option value="<?= set_value('nama_pt'); ?>"> <?= $perusahaan['nama_pt']; ?></option>
                                <?php endif;
                            else : ?>
                                <option value="">Select Perusahaan</option>
                            <?php endif; ?>
                            <option value="Semua Perusahaan">Semua Perusahaan</option>
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
    <div class="col-md-6 col-lg-3">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Jumlah Perusahaan</div>
                    <div class="widget-subheading"><a href="<?= base_url('Data_Pt'); ?>">see detail</a></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span><?= $jumlah_pt; ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Jumlah TKA</div>
                    <div class="widget-subheading"><a href="<?= base_url('Data_Tka'); ?>">see detail</a></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span><?= $jumlah_tka; ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Jumlah Voucher</div>
                    <div class="widget-subheading"><a href="<?= base_url('Data_Voucher'); ?>">see detail</a></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span><?= $jumlah_voucher; ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Jumlah RPTKA</div>
                    <div class="widget-subheading"><a href="<?= base_url('Data_Rptka'); ?>">see detail</a></div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span><?= $jumlah_rptka; ?></span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Data By perusahaan
                <div class="btn-actions-pane-right">
                </div>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Perusahaan</th>
                            <th class="text-center">Jumlah TKA</th>
                            <th class="text-center">Jumlah Voucher</th>
                            <th class="text-center">Jumlah Rptka</th>
                            <th class="text-center">Jumlah Visa (RPTKA-Aktif)</th>
                            <th class="text-center">Jumlah Visa (Non-RPTKA)</th>
                            <th class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_pt as $pt) :
                            $jumlah_tka = $this->db->from('tka')
                                ->where('id_pt', $pt['id'])
                                ->get()
                                ->num_rows();
                            $voucher_visa = $this->db->from('voucher_visa')
                                ->where('id_pt', $pt['id'])
                                ->get()
                                ->num_rows();
                            $voucher_entertaint = $this->db->from('voucher_entertaint')
                                ->where('id_pt', $pt['id'])
                                ->get()
                                ->num_rows();
                            $jumlah_voucher = $voucher_visa + $voucher_entertaint;
                            $jumlah_rptka = $this->db->from('rptka')
                                ->where('id_pt', $pt['id'])
                                ->get()
                                ->num_rows();
                            $jumlah_visa211 = $this->db->from('penghubung_visa211')
                                ->where('id_pt', $pt['id'])
                                ->get()
                                ->num_rows();
                            $jumlah_visa312 = $this->db->from('penghubung_visa312')
                                ->where('id_pt', $pt['id'])
                                ->get()
                                ->num_rows();
                        ?>
                            <tr>
                                <td class="text-center text-muted"><?= $no; ?></td>
                                <td class="text-center"><?= $pt['nama_pt']; ?></td>
                                <td class="text-center"><?= $jumlah_tka; ?></td>
                                <td class="text-center"><?= $jumlah_voucher; ?></td>
                                <td class="text-center"><?= $jumlah_rptka; ?></td>
                                <td class="text-center"><?= $jumlah_visa211; ?></td>
                                <td class="text-center"><?= $jumlah_visa312; ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('Data_Pt/detail/') . $pt['id']; ?>" class="badge badge-success">Detail</a>
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

<script>
    $(document).ready(function() {
        $("#filter_box").hide();
    });
    $('#filter').click(function() {
        $("#filter_box").toggle();
    });
</script>