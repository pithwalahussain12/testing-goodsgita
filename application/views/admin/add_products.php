<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#add_newspaper_form').validate();

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
Add Products

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/AllProducts">Add Products </a></li>

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

<form role="form" id="add_newspaper_form" name="add_newspaper_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/add_productaction/" enctype="multipart/form-data" >

<div class="box-body">
			
	<div class="form-group">
		<label class="control-label"> Product Name  </label>
			<input type="text" value="" class="form-control required " name="productName"   id="productName" >			
	</div>	
<!-- 
	<div class="form-group">
		<label class="control-label"> Merchant Name </label>
		<select name="merchantId" id="merchantId" class="form-control required">		
		  <option value=""> Select Merchant</option>
		  <?php foreach($allmerchant as $data){ ?>
		  <option value="<?php echo $data->id; ?>"> <?php echo $data->UN; ?></option>
		  <?php } ?>
		</select>			
	</div>	 -->
	
	<div class="form-group">
		<label class="control-label">  CategoryId  </label>
		<select name="categoryId" id="categoryId" class="form-control required" onchange="showsubcat(this.value)	" >		
		  <option value=""> Select Category</option>
		  <?php foreach($category as $data){ ?>
		  <option value="<?php echo $data->id; ?>"> <?php echo $data->categoryName; ?></option>
		  <?php } ?>
		</select>			
	</div>	

	<div class="form-group">
		<label class="control-label">  SubCategoryId  </label>		
		<select name="subcategoryId" id="subcategoryId" class="form-control required" >	
		  <option value=""> Select SubCategory</option>		
		 </select>		
	</div>	

	<div class="form-group">
		<label class="control-label">  Price  </label>
			<input type="text" value="" class="form-control required allownumericwithdecimal" name="price"   id="price" >			
	</div>	

	<div class="form-group">
		<label class="control-label"> Retailprice  </label>
			<input type="text" value="" class="form-control required allownumericwithdecimal" name="retailprice"   id="retailprice" >			
	</div>	

	<div class="form-group">
		<label class="control-label"> Whole Sale Price  </label>
			<input type="text" value="" class="form-control required allownumericwithdecimal" name="wholesaleprice"   id="wholesaleprice" >			
	</div>		
		
	<div class="form-group">
		<label class="control-label"> Review  </label>
			<input type="text" value="" class="form-control required " name="review"   id="review" >			
	</div>	

	<div class="form-group">
		<label class="control-label"> Rating  </label>
			<input type="text" value="" class="form-control required " name="rating"   id="rating" >			
	</div>	

	<div class="form-group">
		<label class="control-label"> Availability  </label>
			<input type="text" value="" class="form-control required " name="availability"   id="availability" >			
	</div>	
		
	<div class="form-group">
		<label class="control-label">  Featurd Image  </label>
		<input type="file" name="featurdimg"  id="featurdimg" class="btn btn-info"  />	
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