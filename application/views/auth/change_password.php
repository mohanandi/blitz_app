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
    <form class="user" method="post" action="<?= base_url('auth/changepassword'); ?>">
     <div class="login-form-head">
      <h1 class="h4 text-gray-900">Change Your Password For</h1>
      <h5 class="mb-4"><?= $this->session->userdata('reset_email'); ?></h5>
     </div>
     <?= $this->session->flashdata('message');  ?>
     <div class="login-form-body">
      <div class="form-gp">
       <label for="exampleInputEmail1">Enter New Password</label>
       <input type="password" id="password1" name="password1">
       <i class="ti-email"></i>
       <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
      </div>
      <div class="form-gp">
       <label for="exampleInputEmail1">Repeat Password</label>
       <input type="password" id="password2" name="password2">
       <i class="ti-email"></i>
       <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
      </div>

      <div class="submit-btn-area">
       <button type="submit" id="form_submit">Change Password</button>
      </div>
     </div>
    </form>
   </div>
  </div>
 </div>
 <!-- login area end -->
</body>