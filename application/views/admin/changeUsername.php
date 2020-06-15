<?php $this->load->view('admin/header');    ?>
<script type="text/javascript">
$(document).ready(function(){
	
$('#add_suburb').validate();	

});

</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Change Username

</h1>
<ol class="breadcrumb">
<li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i>More</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/change_user">Change Username</a></li>

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
<h3 class="box-title">Change Username</h3>	
 <?php
if($this->session->flashdata('err_man') != ''){
		 echo $this->session->flashdata('err_man');
	    }
if($this->session->flashdata('message') != ''){
		 echo $this->session->flashdata('message');
	    }		
?>
</div><!-- /.box-header -->
<!-- form start -->

<form role="form"  id="add_suburb"  action="<?php echo base_url();?>koreatown-administrator/change_username"  method="post">

<div class="box-body">
	
	<div class="form-group">
		<label class="control-label">User Name</label>
		
			<input type="text" class="form-control required" id="user_name" name="user_name" value="<?php if(!empty($edit_data->UN)){echo $edit_data->UN; }?>">
	</div>
	<div class="form-group">
		<label>Email Id</label>
			<input type="text" class="form-control required email" id="email_id" name="email_id" value="<?php if(!empty($edit_data->EI)){echo $edit_data->EI; }?>">
	</div>
	
	
</div><!-- /.box-body -->

<div class="box-footer">

	<button type="submit" class="btn btn-primary">Update</button>&nbsp;&nbsp;&nbsp;
	<a href="<?php echo base_url() ?>koreatown-administrator" class="btn">Cancel</a>
</div>
</form>
</div><!-- /.box -->

</div><!--/.col (left) -->
</div><!-- /.row -->

</section><!-- /.content -->                
</aside><!-- /.right-side -->
<?php $this->load->view('admin/footer'); ?>
