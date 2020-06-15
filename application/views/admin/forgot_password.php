<!DOCTYPE html>
<html class="bg-grey">
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password: Admin Panel</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url() ?>admin-assets/dashboard_css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url() ?>admin-assets/dashboard_css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url() ?>admin-assets/dashboard_css/AdminLTE.css" rel="stylesheet" type="text/css" />

		<script src="<?php echo base_url() ?>admin-assets/dashboard_js/jquery.min.js"></script>
		<script src="<?php echo base_url() ?>admin-assets/dashboard_js/bootstrap.min.js" type="text/javascript"></script>
		
		<!--------Validation Script-------------Start---->
		<script src="<?php echo base_url() ?>admin-assets/dashboard_js/jquery.validate.js" type="text/javascript"></script>
		
		<!--------Validation Script-------------End------>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        <script type="text/javascript">
        
        $(document).ready(function(){
			
		$("#forgot_form").validate();
			
		});
        
        
        </script>
        
        
        
    </head>
    <body class="bg-grey">
		<div class="admin_logo">SuperFast Ads Administrator</div>
		
        <div class="form-box login-rest" id="login-box">
            <div class="header rest_header">Forgot Password</div>
            <form id="forgot_form" name="forgot_form" action="<?php echo base_url();?>koreatown-administrator/send_password" method="post">
                <div class="body">
					
				<?php
				if($this->session->flashdata('message') != ''){
				 echo $this->session->flashdata('message');
				}
				?>							
                    <div class="form-group">
                        <input type="text" name="email" id="email" class="form-control required email" placeholder="Enter Your Email Id" />
                    </div>       

                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Send Password</button>  
                </div>
            </form>

        </div>
    

    </body>
</html>
