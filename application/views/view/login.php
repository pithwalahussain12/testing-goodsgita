<!DOCTYPE html>
<html lang="en">
<?php
// foreach ($data as $value) {
//   echo $value['mobile'];
// }
//  die;
 ?>
<head>
 <base href="<?php echo base_url();?>"> 

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
             
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                   <form id="login_form" name="login_form" action="<?php echo base_url();?>home/login" method="post" class="user">
                <div class="body bg-gray">

                <?php
                if($this->session->flashdata('message') != ''){
                 echo $this->session->flashdata('message');
                }
                ?>        
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="userid" name="userid" value="<?php if($this->session->flashdata('mobile') != ''){
                 echo $this->session->flashdata('mobile');
                } ?>" placeholder="Enter Mobile Number">
                        <?php echo form_error('userid'); ?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" value="<?php if($this->session->flashdata('password') != ''){
                 echo $this->session->flashdata('password');
                } ?>" placeholder="Password">
                        <?php echo form_error('password'); ?>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <?php $rem = $this->input->cookie('userid_ad', TRUE); ?>
                        <input type="checkbox" class="custom-control-input" id="remember_me" name="remember_me">
                        <label class="custom-control-label" for="remember_me" <?php if($rem) {
                  echo 'checked="checked"';
                  }
                  else {
                  echo '';
                  }
                  ?>>Remember Me</label>
                      </div>
                    </div>
                     <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                  
                   
                  </form>
                 
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.js"></script>

</body>

</html>
