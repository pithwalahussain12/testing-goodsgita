<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#update_category_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#merchants').addClass('active');
  $('#all_icloud_ul').show();
    
  });


</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Edit Merchant - <?php echo $edit_data->UN; ?>

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/MerchantList">Merchant</a></li>

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

<form role="form" id="update_category_form" name="update_category_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/update_merchant/<?php echo $edit_data->id; ?>" enctype="multipart/form-data" >
<div class="box-body">

    <div class="form-group">
		<label class="control-label"> Name</label>
			<input type="text" value="<?php echo $edit_data->UN; ?>" class="form-control required" name="name" id="name"  >
			
	</div>
	<div class="form-group">
		<label class="control-label">Email</label>
			<input type="text" value="<?php echo $edit_data->EI; ?>" class="form-control required email" name="email" id="email"  >
	</div>
	
	<div class="form-group">
		<label class="control-label">Password</label>
			<input type="password" value="<?php echo $edit_data->SUP; ?>" class="form-control required" minlength="6" name="password" id="password"> 
			<span id="passval" style="color:red" ></span>
	</div>

	<div class="form-group">
		<label class="control-label">Contact</label>
			<input type="text" value="<?php echo $edit_data->contactNumber; ?>" class="form-control required" name="contact" id="contact" >
	</div>

</div><!-- /.box-body -->


<div class="box-footer">
	<button type="submit" class="btn btn-primary" onclick="return chechpass();">Update</button>
</div>
</form>
</div><!-- /.box -->
</div><!--/.col (left) -->
</div><!-- /.row -->
</section><!-- /.content -->                
</aside><!-- /.right-side -->


<?php $this->load->view('admin/footer');    ?>
