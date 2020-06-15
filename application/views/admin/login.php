<!DOCTYPE html>
<html class="">
    <head>
        <meta charset="UTF-8">
        <title>Login: Admin Panel</title>
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
        
        <script type="text/javascript">
        
        $(document).ready(function(){
			
		$("#login_form").validate();
			
		});
        
        
        </script>
        
        
        
    </head>
    <body class="">
		<div class="admin_logo">Korea Town Administrator Login</div>
        <div class="form-box" id="login-box">
            <div class="header"><img src="<?php echo base_url();?>admin-assets/dashboard_img/admin_logo.png" class="img-responsive" width="200" /></div>
            <form id="login_form" name="login_form" action="<?php echo base_url();?>koreatown-administrator/login" method="post">
                <div class="body bg-gray">

<?php
if($this->session->flashdata('message') != ''){
 echo $this->session->flashdata('message');
}
?>						
		
                    <div class="form-group">
                        <input type="text" name="userid" class="form-control required" placeholder="User Name" value="<?php echo $this->input->cookie('userid_ad', TRUE); ?>"/>
                         <?php echo form_error('userid'); ?>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control required" placeholder="Password" value="<?php echo $this->input->cookie('password_ad', TRUE); ?>"/>
                        <?php echo form_error('password'); ?>
                    </div>          
                    <div class="form-group">
						<?php $rem = $this->input->cookie('userid_ad', TRUE); ?>
                        
					<input id="remember_me" name="remember_me" type="checkbox" value="1" <?php if($rem) {
					echo 'checked="checked"';
					}
					else {
					echo '';
					}
					?> /> Remember me             
                        
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="<?php echo base_url();?>koreatown-administrator/forgot_password">I forgot my password</a></p>
                    
                </div>
            </form>

        </div>
    

    </body>
</html>
