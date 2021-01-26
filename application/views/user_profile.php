<div class="row">
    <div class="col-lg-8">
        <?= $this->session->flashdata('message'); ?>
    </div>
</div>

<ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
    <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-0" href="<?= base_url('Profile'); ?>">
            <span>Profile</span>
        </a>
    </li>
    <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-1" href="<?= base_url('Profile/change_password'); ?>">
            <span>Change Password</span>
        </a>
    </li>
</ul>

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