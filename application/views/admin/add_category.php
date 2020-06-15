<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#add_category_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#categorys').addClass('active');
  $('#all_icloud_ul').show();
   
  });

</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Add Product Category

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/All_category">Product Categories</a></li>

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

<form role="form" id="add_category_form" name="add_category_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/add_category/" enctype="multipart/form-data" >

<div class="box-body">
	<div class="form-group">
		<label class="control-label">Product Category Name</label>
			<input type="text" value="" class="form-control required" name="categoryname"   id="categoryname" >
			
	</div>
	
	<div class="form-group">
		<label class="control-label">Product Category Description</label>
			<input type="text" value="" class="form-control required" name="description"   id="description" >
			
	</div>
	
	<div class="form-group">
		<label class="control-label"> Category Image</label>
			 <input type="file" name="categoryimage" value="" id="categoryimage" class="btn btn-info"  />
	</div>
	
	
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
