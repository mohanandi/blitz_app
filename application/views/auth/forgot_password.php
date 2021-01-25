<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form class="user" method="post" action="<?= base_url('auth/forgot_password'); ?>">
                    <div class="login-form-head">
                        <h4>Forgot Your Password ?</h4>
                    </div>
                    <?= $this->session->flashdata('message');  ?>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="text" id="email" name="email" value="<?= set_value('email'); ?>">
                            <i class="ti-email"></i>
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6 text-left">
                                <a class="small" href="<?= base_url(); ?>">Back to Login</a>
                            </div>
                        </div>
                        <div class="submit-btn-area">
                            <button type="submit" id="form_submit">Reset Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->
</body>