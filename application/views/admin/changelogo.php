<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#update_category_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#products').addClass('active');
  $('#all_icloud_ul').show();
    
  });


</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Edit Product 

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/AllProducts">Product</a></li>

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
<form role="form" id="update_category_form" name="update_category_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/changelogoaction/<?php echo $edit_data->id; ?>" enctype="multipart/form-data" >
<div class="box-body">
	
	<div class="form-group">
		<label class="control-label">Logo</label>
			<input type="file" name="logoimg" id="logoimg" class="btn btn-info"  />
			  <?php if(!empty($edit_data->logoimg)) { ?>
			<img src="<?php echo base_url(); ?>uploads/logoimg/<?php echo $edit_data->logoimg; ?>" width="50" height="50">
			<?php } ?>
			
		<input type="hidden" name="old_image" id="old_image" value="<?php if(!empty($edit_data->logoimg)) echo $edit_data->logoimg; ?>"	>
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
<script>
 $(".allownumericwithdecimal").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
     $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

 $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
</script>		
<?php $this->load->view('admin/footer');    ?>
<script>
$(document).ready(function(){
	showsubcat(<?php echo $edit_data->categoryId; ?>);
})

function showsubcat(catid)	{
          $.ajax({
               url: '<?php echo base_url(); ?>koreatown-administrator/getsubcategory/',
               type: 'POST',
               data: {catid:catid},
               success: function(response) {				 
				   $("#subcategoryId").html(response);
               }
              });
              }//End Ajax
</script>