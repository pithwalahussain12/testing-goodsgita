<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#update_category_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#category').addClass('active');
  $('#all_icloud_ul').show();
    
  });


</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Edit Category - <?php echo $edit_data->categoryName; ?>

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/All_category">Categories</a></li>

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

<form role="form" id="update_category_form" name="update_category_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/update_category/<?php echo $edit_data->id; ?>" enctype="multipart/form-data" >
<div class="box-body">
    <div class="form-group">
		<label class="control-label">Category Name</label>
			<input type="text" value="<?php echo $edit_data->categoryName; ?>" class="form-control required" name="categoryname"   id="categoryname"  >
			
	</div>
	<div class="form-group">
		<label class="control-label">Description</label>
			<input type="text" value="<?php echo $edit_data->description; ?>" class="form-control required" name="description"   id="description"  >
			
	</div>
	
	<div class="form-group">
		<label class="control-label">category Image</label>
			<input type="file" name="categoryimage" value="" id="categoryimage" class="btn btn-info"  />
			  <?php if(!empty($edit_data->category_img)) { ?>
			<img src="<?php echo base_url(); ?>uploads/categoryimg/<?php echo $edit_data->category_img; ?>" width="50" height="50">
			<?php } ?>
			
		<input type="hidden" name="old_image" id="old_image" value="<?php if(!empty($edit_data->category_img)) echo $edit_data->category_img; ?>"	>
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
