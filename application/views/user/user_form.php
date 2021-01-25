<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header"><?= $subjudul; ?>
            </div>
            <div class="table-responsive" style="padding: 20px;">
                <form class="" method="POST">
                    <div class="position-relative row form-group">
                        <label for="NamaTKA" class="col-sm-2 col-form-label"><b>Nama</b></label>
                        <?php if ($users['id']) : ?>
                            <input name="id_user" id="id_user" type="hidden" value="<?= $users['id']; ?>" class=" form-control">
                        <?php else : ?>
                        <?php endif; ?>
                        <div class="col-sm-10">
                            <?php if (set_value('nama')) : ?>
                                <input name="nama" id="nama" type="text" value="<?= set_value('nama'); ?>" placeholder="Nama User" class="form-control">
                            <?php elseif ($users['nama']) : ?>
                                <input name="nama" id="nama" type="text" value="<?= $users['nama']; ?>" placeholder="Nama User" class="form-control">
                            <?php else : ?>
                                <input name="nama" id="nama" type="text" placeholder="Nama User" class="form-control">
                            <?php endif; ?>
                            <?= form_error('nama'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label"><b>Email</b></label>
                        <div class="col-sm-10">
                            <?php if (set_value('email')) : ?>
                                <input name="email" id="email" type="email" value="<?= set_value('email'); ?>" placeholder="Email" class="form-control">
                            <?php elseif ($users['email']) : ?>
                                <input name="email" id="email" type="email" value="<?= $users['email']; ?>" placeholder="Email" class="form-control">
                            <?php else : ?>
                                <input name="email" id="email" type="email" placeholder="Email" class="form-control">
                            <?php endif; ?>
                            <?= form_error('email'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="Kewarganegaraan" class="col-sm-2 col-form-label"><b>Password</b></label>
                        <div class="col-sm-10">
                            <?php if ($users['password']) : ?>
                                <input name="password" id="password" type="password" value="<?= $users['password']; ?>" placeholder="Password" class="form-control" readonly>
                            <?php elseif (set_value('password')) : ?>
                                <input name="password" id="password" type="password" value="<?= set_value('password'); ?>" placeholder="Password" class="form-control">
                            <?php else : ?>
                                <input name="password" id="password" type="password" value="<?= $users['password']; ?>" placeholder="Password" class="form-control">
                            <?php endif; ?>
                            <?= form_error('password'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="passport" class="col-sm-2 col-form-label"><b>Role</b></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="role_id" name="role_id">
                                <?php if (set_value('role_id')) :
                                    $data_role = $this->db->get_where('role', ['id' => set_value('role_id')])->row_array();
                                ?>
                                    <option value="<?= set_value('role_id'); ?>"> <?= $data_role['role']; ?></option>
                                <?php elseif ($users['role_id']) :
                                    $data_role = $this->db->get_where('role', ['id' => $users['role_id']])->row_array();
                                ?>
                                    <option value="<?= $data_role['id']; ?>"> <?= $data_role['role']; ?></option>
                                <?php else : ?>
                                    <option value="">Role User</option>
                                <?php endif; ?>
                                <?php foreach ($role as $rl) : ?>
                                    <option value="<?= $rl['id']; ?>"><?= $rl['role']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('role_id'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="expassport" class="col-sm-2 col-form-label"><b>PIC PT</b></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="pic_pt" name="pic_pt">
                                <?php if (set_value('pic_pt')) : ?>
                                    <option value="<?= set_value('pic_pt'); ?>"> <?= set_value('pic_pt'); ?></option>
                                <?php elseif ($users['pic_pt']) : ?>
                                    <option value="<?= $users['pic_pt']; ?>"> <?= $users['pic_pt']; ?></option>
                                <?php else : ?>
                                    <option value="">Status PIC PT</option>
                                <?php endif; ?>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                            <?= form_error('pic_pt'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-group">
                        <label for="expassport" class="col-sm-2 col-form-label"><b>Status</b></label>
                        <div class="col-sm-10">
                            <select class="form-control" id="is_active" name="is_active">
                                <?php if (set_value('is_active')) : ?>
                                    <option value="<?= set_value('is_active'); ?>"> <?= set_value('is_active'); ?></option>
                                <?php elseif ($users['is_active']) : ?>
                                    <option value="<?= $users['is_active']; ?>"> <?= $users['is_active']; ?></option>
                                <?php else : ?>
                                    <option value="">Status</option>
                                <?php endif; ?>
                                <option value="Aktif">Aktif</option>
                                <option value="Non-Aktif">Non-Aktif</option>
                            </select>
                            <?= form_error('is_active'); ?>
                        </div>
                    </div>
                    <div class="position-relative row form-check">
                        <div class="right">
                            <button type="submit" class="btn btn-success"><?= $button; ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>