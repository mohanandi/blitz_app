<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Filter by pt
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form name="add_name" method="POST" action="">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dynamic_field">
                            <thead class="table-info">
                                <tr>
                                    <th class="text-center">Nama PT</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>
                                    <select class="form-control" id="nama_pt" name="nama_pt">
                                        <?php if (set_value('nama_pt')) :
                                            $pt = $this->db->select('nama_pt')->get_where('pt', ['id' => set_value('nama_pt')])->row_array();
                                        ?>
                                            <option value="<?= set_value('nama_pt'); ?>"> <?= $pt['nama_pt']; ?></option>
                                        <?php else : ?>
                                            <option value="">Select PT</option>
                                        <?php endif; ?>
                                        <?php foreach ($data_pt as $p) : ?>
                                            <option value="<?= $p['id']; ?>"><?= $p['nama_pt']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header"> Pilih Data TKA untuk <?= $subjudul; ?>
            </div>
            <div class="table-responsive" style="padding: 10px;">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Perusahaan</th>
                            <th class="text-center">No Passport</th>
                            <th class="text-center">Nama Latin</th>
                            <th class="text-center">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($jalan_pintas == 1) {
                            $no = 1;
                            foreach ($id_tenaga as $tka) :
                                $this->db->select(array('id', 'id_pt', 'nama_latin', 'passport'));
                                $this->db->from('tka');
                                $this->db->where('id', $tka['id_tka']);
                                $query = $this->db->get();
                                $data_tka = $query->row_array();
                                $this->db->select(array('id_penghubung_visa211', 'status'));
                                $this->db->from('penghubung_visa211');
                                $this->db->where(array('id_jenis_visa' => $data_jenis_visa['id'], 'id_tka' => $tka['id_tka']));
                                $query = $this->db->get();
                                $check_visa = $query->row_array();
                                if ($check_visa['status'] == 'Aktif') :
                                else :
                                    $pt = $this->db->select('nama_pt')->get_where('pt', ['id' => $data_tka['id_pt']])->row_array();
                                    if ($check_pt) :
                                        if ($check_pt == $data_tka['id_pt']) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no; ?></td>
                                                <td class="text-center"><?= $pt['nama_pt']; ?></td>
                                                <td class="text-center"><?= $data_tka['passport']; ?></td>
                                                <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                                                <td class="text-center">
                                                    <form action="<?= base_url('Data_Visa/tambah_visa211/'); ?>" method="POST">
                                                        <input type="hidden" name="id_tka" value="<?= $tka['id_tka']; ?>">
                                                        <input type="hidden" name="id_visa" value="<?= $data_jenis_visa['id']; ?>">
                                                        <button type="submit" class="badge badge-success">Pilih</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php else :
                                        endif;
                                    else : ?>
                                        <tr>
                                            <td class="text-center"><?= $no; ?></td>
                                            <td class="text-center"><?= $pt['nama_pt']; ?></td>
                                            <td class="text-center"><?= $data_tka['passport']; ?></td>
                                            <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                                            <td class="text-center">
                                                <form action="<?= base_url('Data_Visa/tambah_visa211/'); ?>" method="POST">
                                                    <input type="hidden" name="id_tka" value="<?= $tka['id_tka']; ?>">
                                                    <input type="hidden" name="id_visa" value="<?= $data_jenis_visa['id']; ?>">
                                                    <button type="submit" class="badge badge-success">Pilih</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endif;
                                endif;
                                $no++;
                            endforeach;
                        } else {
                            $no = 1;
                            foreach ($id_tenaga as $tka) :
                                $this->db->select(array('id', 'id_pt', 'nama_latin', 'passport'));
                                $this->db->from('tka');
                                $this->db->where('id', $tka['id']);
                                $query = $this->db->get();
                                $data_tka = $query->row_array();
                                $this->db->select(array('id_penghubung_visa211', 'status'));
                                $this->db->from('penghubung_visa211');
                                $this->db->where(array('id_jenis_visa' => $data_jenis_visa['id'], 'id_tka' => $tka['id']));
                                $query = $this->db->get();
                                $check_visa = $query->row_array();
                                if ($check_visa['status'] == 'Aktif') :
                                else : ?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                        <?php $pt = $this->db->select('nama_pt')->get_where('pt', ['id' => $data_tka['id_pt']])->row_array(); ?>
                                        <td class="text-center"><?= $pt['nama_pt']; ?></td>
                                        <td class="text-center"><?= $data_tka['passport']; ?></td>
                                        <td class="text-center"><?= $data_tka['nama_latin']; ?></td>
                                        <td class="text-center">
                                            <form action="<?= base_url('Data_Visa/tambah_visa211/'); ?>" method="POST">
                                                <input type="hidden" name="id_tka" value="<?= $tka['id']; ?>">
                                                <input type="hidden" name="id_visa" value="<?= $data_jenis_visa['id']; ?>">
                                                <button type="submit" class="badge badge-success">Pilih</button>
                                            </form>
                                        </td>
                                    </tr>

                        <?php $no++;
                                endif;
                            endforeach;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>