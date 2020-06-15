<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#update_newspaper_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#newspapers').addClass('active');
  $('#all_icloud_ul').show();
    
  });


</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Edit Newspaper - <?php echo $edit_data->newspapername; ?>

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>superfastads-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>superfastads-administrator/All_newspaper">Newspapers</a></li>

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

<form role="form" id="update_newspaper_form" name="update_newspaper_form" method="POST" action="<?php echo base_url();?>superfastads-administrator/update_newspaper/<?php echo $edit_data->newspaperid; ?>" enctype="multipart/form-data" >
<div class="box-body">
    <div class="form-group">
		<label class="control-label">Newspaper Name</label>
			<input type="text" value="<?php echo $edit_data->newspapername; ?>" class="form-control required" name="newspapername"   id="newspapername"  >
			
	</div>
	<div class="form-group">
		<label class="control-label">Newspaper Image</label>
			<input type="file" name="newspaperimage" value="" id="newspaperimage" class="btn btn-info"  />
			  <?php if(!empty($edit_data->newspaperimage)) { ?>
			<img src="<?php echo base_url(); ?>uploads/newspapers/<?php echo $edit_data->newspaperimage; ?>" width="50" height="50">
			<?php } ?>
			
		<input type="hidden" name="old_image" id="old_image" value="<?php if(!empty($edit_data->newspaperimage)) echo $edit_data->newspaperimage; ?>"	>
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
