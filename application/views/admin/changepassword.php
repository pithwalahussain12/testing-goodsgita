<?php $this->load->view('admin/header');    ?>
<script type="text/javascript">
$(document).ready(function(){
	
$('#add_suburb').validate();	

$('#error_msg').fadeOut(5000);

});

</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Change Password

</h1>
<ol class="breadcrumb">
<li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i>More</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/change_password">Change password</a></li>

</ol>

</section>

<!-- Main content -->
<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12">
<!-- general form elements -->
<div class="box box-primary">
<div class="box-header">
<h3 class="box-title">Change Password</h3>	
 <?php
if($this->session->flashdata('err_man') != ''){
		 echo $this->session->flashdata('err_man');
	    }
?>
</div><!-- /.box-header -->
<!-- form start -->

<form role="form"  id="add_suburb"  action="<?php echo base_url();?>koreatown-administrator/change_psw_action" method="post">

<div class="box-body">
	
	<div class="form-group">
		<label class="control-label">Cureent Password</label>
			<input type="password" class="form-control required" id="current_password" name="current_password" value="">
	</div>
	<div class="form-group">
		<label>New Password</label>
			<input type="password" class="form-control required" id="new_password" name="new_password" value="">
			<span id="passval" style="color:red"></span>   
	</div>
	<div class="form-group">
		<label>Confirm Password</label>
			<input type="password" class="form-control required"  equalTo="#new_password" id="conform_password" name="conform_password" value=""> 
	</div>
	
</div><!-- /.box-body -->

<div class="box-footer">

	<button type="submit" class="btn btn-primary" onclick="return chechpass();">Update</button>&nbsp;&nbsp;&nbsp;
	<a href="<?php echo base_url() ?>koreatown-administrator" class="btn">Cancel</a>
</div>
</form>
</div><!-- /.box -->

</div><!--/.col (left) -->
</div><!-- /.row -->

</section><!-- /.content -->                
</aside><!-- /.right-side -->
<script>
function chechpass() {
    var data = $('#new_password').val().length; 
	if(data < 6){
    document.getElementById("passval").innerHTML = "Maximum number of characters allowed in the password field is now 6.";
	return false;
	}
	return true;
}
</script>
<?php $this->load->view('admin/footer'); ?>
