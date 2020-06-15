<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#update_category_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#users').addClass('active');
  $('#all_icloud_ul').show();
    
  });


</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Edit USer - <?php echo $edit_data->name; ?>

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/UserList">User</a></li>

</ol>
</section>

<!-- Main content -->
<section class="content">


<div class="row">


<!-- left column -->
<div class="col-md-12">
<!-- general form elements -->
<div class="box box-primary">

<?php echo $this->session->flashdata('message'); ?>
<!-- form start -->

<form role="form" id="update_category_form" name="update_category_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/update_user/<?php echo $edit_data->id; ?>" enctype="multipart/form-data" >
<div class="box-body">

    <div class="form-group">
		<label class="control-label"> Name</label>
			<input type="text" value="<?php echo $edit_data->name; ?>" class="form-control required" name="name" id="name"  >
			
	</div>
	<div class="form-group">
		<label class="control-label">Email</label>
			<input type="text" value="<?php echo $edit_data->email; ?>" class="form-control required email" name="email" id="email"  >
	</div>
	
	<div class="form-group">
		<label class="control-label">Password</label>
			<input type="password" value="<?php echo $edit_data->password; ?>" minlength="6" class="form-control required" name="password" id="password"  >
	</div>

	<div class="form-group">
		<label class="control-label">Contact</label>
			<input type="text" value="<?php echo $edit_data->contactNumber; ?>" class="form-control required" name="contact" id="contact" >
	</div>

</div><!-- /.box-body -->

<div class="box-footer">
	<button type="submit" class="btn btn-primary">Update</button>
</div>
</form>
</div><!-- /.box -->
</div><!--/.col (left) -->
</div><!-- /.row -->
</section><!-- /.content -->                
</aside><!-- /.right-side -->
<?php $this->load->view('admin/footer');    ?>
