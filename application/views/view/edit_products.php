<?php $this->load->view('view/header');    ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Add product</h1>
         <button class="btn btn-primary pull-right"><a href="<?php echo base_url();?>"  onclick="window.history.go(-1); return true;" style="color: #fff;">Back</a></button>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Add product</h6>
            </div>
            <div class="card-body">
           
<form role="form" id="update_category_form" name="update_category_form" method="POST" action="<?php echo base_url();?>home/update_productds/<?php echo $edit_data->id; ?>" enctype="multipart/form-data"  class="user" >

  <div class="body bg-gray">
      
  <div class="form-group">
    <label class="control-label"> Product Name </label>
      <input type="text" class="form-control form-control-user required " name="productName"   id="productName" value="<?php echo $edit_data->productName; ?>">      
  </div>  


  
	<div class="form-group">
		<label class="control-label">  CategoryId  </label>
		<select name="categoryId" id="categoryId" class="form-control required" onchange="showsubcat(this.value)	" >		
		  <option value=""> Select Category</option>
		  <?php foreach($category as $data){ ?>
		  <option value="<?php echo $data->id; ?>"  <?php if($data->id == $edit_data->categoryId){ echo 'selected';} ?>> <?php echo $data->categoryName; ?></option>
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
      <input type="text" value="<?php echo $edit_data->price; ?>" class="form-control form-control-user required allownumericwithdecimal" name="price"   id="price" >     
  </div>  

  <div class="form-group">
    <label class="control-label"> Retailprice  </label>
      <input type="text" value="<?php echo $edit_data->retailprice; ?>" class="form-control form-control-user required allownumericwithdecimal" name="retailprice"   id="retailprice" >     
  </div>  

  <div class="form-group">
    <label class="control-label"> Whole Sale Price  </label>
      <input type="text" value="<?php echo $edit_data->wholesaleprice; ?>" class="form-control form-control-user required allownumericwithdecimal" name="wholesaleprice"   id="wholesaleprice" >     
  </div>    
    
  <div class="form-group">
    <label class="control-label"> Review  </label>
      <input type="text" value="<?php echo $edit_data->review; ?>" class="form-control form-control-user required " name="review"   id="review" >      
  </div>  

  <div class="form-group">
    <label class="control-label"> Rating  </label>
      <input type="text" value="<?php echo $edit_data->rating; ?>" class="form-control form-control-user required " name="rating"   id="rating" >      
  </div>  

  <div class="form-group">
    <label class="control-label"> Availability  </label>
      <input type="text" value="<?php echo $edit_data->availability; ?>" class="form-control form-control-user required " name="availability"   id="availability" >      
  </div>  
	
	<div class="form-group">
		<label class="control-label">Featurd Image</label>
			<input type="file" name="featurdimg" id="featurdimg" class="btn btn-info"  />
			  <?php if(!empty($edit_data->featureImage)) { ?>
			<img src="<?php echo base_url(); ?>uploads/featuredimg/<?php echo $edit_data->featureImage; ?>" width="50" height="50">
			<?php } ?>
			
		<input type="hidden" name="old_image" id="old_image" value="<?php if(!empty($edit_data->featureImage)) echo $edit_data->featureImage; ?>"	>
	</div>
	
	<div class="form-group">
		<label class="control-label">Gallery Image</label>
			<input type="file" name="galleryimg" id="galleryimg" class="btn btn-info"  />
			  <?php if(!empty($edit_data->featureImage)) { ?>
			<img src="<?php echo base_url(); ?>uploads/galleryimg/<?php echo $edit_data->imageGallery; ?>" width="50" height="50">
			<?php } ?>
			
		<input type="hidden" name="old_image1" id="old_image1" value="<?php if(!empty($edit_data->imageGallery)) echo $edit_data->imageGallery; ?>"	>
	</div>	  


</div><!-- /.box-body -->

  <div class="col-xl-6 m-t-12">
            <button type="submit"  id="open-sucees-note" class="btn btn-success btn-admin ml-p">Success</button>
  </div>

</form>
       


            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- notification Suceess-code -->

  <div class="alert-notification-sucees">
      <div class="head-alert">
          <i class="fa fa-check custom-check">
              <p>Hii , Form are Submit Successful</p>
          </i>
      </div>
  </div>

  <div class="error1">
      <div class="head-alert error-alert">
          <i class="fa fa-times custom-check">
              <p>Hii , Form are Submit Unsuccessful</p>
          </i>
      </div>
  </div>



  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/jquery.validity.js"></script>
  <script src="js/script.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script type="text/javascript">
        $(document).ready(function(){
    $("#open-sucees-note").click(function(){
    $(".alert-notification-sucees").fadeIn();
    });
  });

  $(document).ready(function(){
    $("#open-error-note").click(function(){
    $(".error1").fadeIn();
    });
  });

  </script>


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
               url: '<?php echo base_url(); ?>home/getsubcategory/',
               type: 'POST',
               data: {catid:catid},
               success: function(response) {				 
				   $("#subcategoryId").html(response);
               }
              });
              }//End Ajax
</script>

</body>

</html>
