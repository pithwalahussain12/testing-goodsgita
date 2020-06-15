<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#add_newspaper_form').validate();

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
Add Slider

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/add_slider">Add Slider </a></li>

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

<form role="form" id="add_newspaper_form" name="add_newspaper_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/add_slideraction/" enctype="multipart/form-data" >

<div class="box-body">
		
	<div class="form-group">
		<label class="control-label">  Title  </label>
			<input type="text" value="" class="form-control required" name="title"   id="title" >			
	</div>	

	<div class="form-group">
		<label class="control-label"> Description  </label>
		<textarea name="descriptiondata" id="descriptiondata" class="form-control"></textarea>		
	</div>	

	<div class="form-group">
		<label class="control-label">  Gallery Image  </label>
		<input type="file" name="galleryimg"  id="galleryimg" class="btn btn-info"  />			
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