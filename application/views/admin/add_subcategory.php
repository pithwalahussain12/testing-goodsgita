<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#add_subcategory_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#subcategorys').addClass('active');
  $('#all_icloud_ul').show();
   
  });

</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Add Product Sub-Category

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/All_subcategory">Product Categories</a></li>

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

<form role="form" id="add_subcategory_form" name="add_subcategory_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/add_subcategory/" enctype="multipart/form-data" >

<div class="box-body">
	<div class="form-group">
		<label class="control-label">Product Category Name</label>
			<select class="form-control required" name="catid"   id="categoryname" >
			   <option value="">Please select any Category</option>
			   <?php 
			   foreach($cat as $row){
			   ?>
			   <option value="<?php echo $row->id; ?>"><?php echo $row->categoryName; ?></option>
			   <?php } ?>
			</select>
			
	</div>
	
	<div class="form-group">
		<label class="control-label">Product Sub-Category Name</label>
			<input type="text" value="" class="form-control required" name="subcatname"   id="subcategoryname" >
			
	</div>
	
	<div class="form-group">
		<label class="control-label">Product Sub-Category Description</label>
			<input type="text" value="" class="form-control required" name="description"   id="description" >
			
	</div>
	
	<!--<div class="form-group">
		<label class="control-label">Product subcategory Image</label>
			 <input type="file" name="subcategoryimage" value="" id="subcategoryimage" class="btn btn-info"  />
	</div>-->
	
	
</div><!-- /.box-body -->

<div class="box-footer">
	<button type="submit" class="btn btn-primary">Add</button>
</div>
</form>
</div><!-- /.box -->
</div><!--/.col (left) -->
</div><!-- /.row -->
</section><!-- /.content -->                
</aside><!-- /.right-side -->
<?php $this->load->view('admin/footer');    ?>
