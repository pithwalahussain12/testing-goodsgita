<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#update_category_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allsliders').addClass('active');
  $('#allsliders a').find('i:last').addClass('fa-angle-down');
  $('#sliders').addClass('active');
  $('#all_sliders_ul').show();
    
  });


</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Edit Slider - <?php echo $allslider->title; ?>

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/Allsliders">Slider</a></li>

</ol>
</section>

<!-- Main content -->
<section class="content">


<div class="row">


<!-- left column -->
<div class="col-md-12">
<!-- general form elements -->
<div class="box box-primary">

<!-- form start -->

<form role="form" id="update_category_form" name="update_category_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/update_slider/<?php echo $allslider->id; ?>" enctype="multipart/form-data" >
<div class="box-body">
	
	<div class="form-group">
		<label class="control-label"> Title  </label>
			<input type="text" value="<?php echo $allslider->title; ?>" class="form-control required " name="title"   id="title" >			
	</div>	

	<div class="form-group">
		<label class="control-label"> Description  </label>
			<input type="text" value="<?php echo $allslider->descriptiondata; ?>" class="form-control required" name="descriptiondata"   id="descriptiondata" >			
	</div>		
	
	<div class="form-group">
		<label class="control-label">Slider Image</label>
			<input type="file" name="galleryimg" id="galleryimg" class="btn btn-info"  />
			  <?php if(!empty($allslider->image)) { ?>
			<img src="<?php echo base_url(); ?>uploads/sliders/<?php echo $allslider->image; ?>" width="50" height="50">
			<?php } ?>
			
		<input type="hidden" name="old_image1" id="old_image1" value="<?php if(!empty($allslider->image)) echo $allslider->image; ?>"	>
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
