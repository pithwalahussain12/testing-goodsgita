<!DOCTYPE html>
<html lang="en">

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
                   <form id="login_form" name="login_form" action="<?php echo base_url();?>home/registor" method="post" class="user" enctype="multipart/form-data">
                <div class="body bg-gray">

                <?php
                if($this->session->flashdata('message') != ''){
                 echo $this->session->flashdata('message');
                }
                ?>        
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="username" id="username" value="" aria-describedby="emailHelp" placeholder="Enter Your Name">
                        <?php echo form_error('name'); ?>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="father" placeholder="Enter Father Name" name="father" value="">
                        <?php echo form_error('father'); ?>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="mob" name="mob" placeholder="Enter first Mobile Number" value="">
                        <?php echo form_error('mob'); ?>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="email" placeholder="Enter Email-Id" name="email" value="">
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="category" id="category">
                        <option value="">Select Category</option>
                        <?php foreach($category as $data){ ?>
                        <option value="<?php echo $data->id; ?>"> <?php echo $data->categoryName; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="voter_id" placeholder="Enter Voter-Id" name="voter_id" value="">
                        <?php echo form_error('voter_id'); ?>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="aadhar_no" placeholder="Enter Aadhar No" name="aadhar_no" value="">
                        <?php echo form_error('aadhar_no'); ?>
                    </div>

                    <div class="form-group">
                      <span class="btn btn-primary btn-file">
                      Voter-Id Image  <input type="file" class="form-control form-control-user" id="voter_img" placeholder="Voter Img" name="voter_img" value="">
                      </span>
                        <?php echo form_error('voter_img'); ?>
                    </div>

                    <div class="form-group">
                      <span class="btn btn-primary btn-file">
                      Aadhar Image  <input type="file" class="form-control form-control-user" id="aadhar_img" placeholder="Aadhar Image" name="aadhar_img" value="">
                      </span>
                        <?php echo form_error('aadhar_img'); ?>
                    </div>
                  
                   
                     <button type="submit" class="btn btn-primary btn-user btn-block">Registor</button>
                  
                    </div>
                   
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
