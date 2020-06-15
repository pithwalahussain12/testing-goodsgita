<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#add_newspaper_form').validate();

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
Add Marchant

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/MerchantList">Add Marchant</a></li>
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

<form role="form" id="add_newspaper_form" name="add_newspaper_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/add_marchantaction/" enctype="multipart/form-data" >

<div class="box-body">
	
	<div class="form-group">
		<label class="control-label"> Name</label>
			<input type="text" value="" class="form-control required" name="name"   id="name" >			
	</div>
	
	<div class="form-group">
		<label class="control-label"> Email </label>
			<input type="text" value="" class="form-control required email" name="email"   id="email" >			
	</div>	

	<div class="form-group">
		<label class="control-label"> Password </label>
			<input type="password" value="" class="form-control required" minlength="6" name="password"   id="password"  >	
            <span id="passval" style="color:red"></span>   			
	</div>	
	
	<div class="form-group">
		<label class="control-label">ContactNo. </label>
			<input type="text" value="" class="form-control required " name="contact"   id="contact" >			
	</div>	
	
</div><!-- /.box-body -->

<div class="box-footer">
	<button type="submit" class="btn btn-primary" onclick="return chechpass();" >Add</button>
</div>
</form>
</div><!-- /.box -->
</div><!--/.col (left) -->
</div><!-- /.row -->
</section><!-- /.content -->                

<?php $this->load->view('admin/footer');    ?>
