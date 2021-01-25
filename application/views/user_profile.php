<div class="row">
    <div class="col-lg-8">
        <?= $this->session->flashdata('message'); ?>
    </div>
</div>

<div class="card mb-3 col-lg-12">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="<?= base_url('assets/images/avatars/') . $user['image']; ?>" class="card-img">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <table class="mb-0 table">
                    <tbody>
                        <tr>
                            <th>Nama User</th>
                            <td><?= $user['nama'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $user['email'] ?></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td><input name="password" id="password" type="password" class="form-control" value="<?= $user['password'] ?>" readonly> </td>
                        </tr>
                    </tbody>
                </table>
                <a type="button" class="btn mr-2 mb-2 btn-primary" href="<?= base_url('Profile/edit/') . $user['id']; ?>" style="float: right; color: white;">
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row">
    <div class="col-lg-8">
        <div class="main-card mb-3 card">
            <div class="row no-gutters">
                <h5 class="card-title">Edit Profil</h5>
                <div class="col-md-4">
                    <td> <img src="<?= base_url('assets/images/avatars/') . $user['image']; ?>" class="card-img" alt="Foto"> </td>
                </div>
                <div class="col-md-8">
                    <table class="mb-0 table">
                        <tbody>
                            <tr>
                                <th>Nama User</th>
                                <td><input name="nama" id="nama" type="text" class="form-control" value="<?= $user['nama'] ?>" readonly> </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input name="email" id="email" type="email" class="form-control" value="<?= $user['email'] ?>" readonly> </td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><input name="password" id="password" type="password" class="form-control" value="<?= $user['password'] ?>" readonly> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn mr-2 mb-2 btn-warning" data-toggle="modal" data-target="#exampleModal" style="float: right; color: white;">
                    Edit
                </button>
            </div>
        </div>
    </div> -->
</div>