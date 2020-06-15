<?php $this->load->view('view/header');    ?>

<script type="text/javascript">
$(document).ready( function () {
  
  $('.sidebar-menu li').removeClass('active');
  $('#allproducts').addClass('active');
  $('#allproducts a').find('i:last').addClass('fa-angle-down');
  $('#products').addClass('active');
  $('#all_userul').show();
  
  getall_products();
});

/* get all products code */
function getall_products()
{          
      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>home/get_products", 
        dataType:"json",
        success: function(response)
        { 
          
          var show_data='';
          if(response['searchall_data'] !='')
          { 
            
             for(i=0;i<response['searchall_data'].length; i++)
             {    
               show_data +=response['searchall_data'][i]; 
             }
          }
          else{
             show_data  +='<table class="table table-bordered"><tr><th width="10%">S.No.</th><th width="25%">Image</th><th width="25%"> Product-Name</th><th width="25%">Action</th></tr><tr><td colspan="14" align="center"><span>No record here !</span></td></tr></table>';
             
            }
            
              $('#allproducts').html(show_data);
              $('.pag_bx1').html(response["pagination"]);
         }
       });
 }
$(document).delegate('.pag_bx1 li a','click',function(){  
      var url = $(this).attr("rel");
     $.ajax({
        type: "post",
        url: url, 
        dataType:"json",
        success: function(response)
        { 
          var show_data='';
          if(response['searchall_data'] !='')
          { 
            
             for(i=0;i<response['searchall_data'].length; i++)
             {    
               show_data +=response['searchall_data'][i]; 
             }
          }
          else{
            show_data  +='<table class="table table-bordered"><tr><th width="10%">S.No.</th><th width="25%">Image</th><th width="25%"> Product-Name</th><th width="25%">Action</th></tr><tr><td colspan="14" align="center"><span>No record here !</span></td></tr></table>';
            }
            
              $('#allproducts').html(show_data);
              $('.pag_bx1').html(response["pagination"]);
         }
       });
});

function delete_products(id)
{
  alert(id);
  $('#confirm').modal({ backdrop: 'static', keyboard: false })
        .one('click', '#delete', function (e) { 
      
      location.href ='<?php echo base_url() ?>home/delete_products/'+id;
      
  });
  
}

</script>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Tables</h1>

          <button class="btn btn-primary pull-right"><a href="<?php echo base_url('home'); ?>" style="color: #fff;">Add Product</a></button>
          <button class="btn btn-primary pull-right"><a href="#"  onclick="window.history.go(-1); return true;" style="color: #fff;">Back</a></button>
        

          <!-- DataTales Example -->
          <div class="card shadow mb-4" style="margin-top: 25px;">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
          
                 
              <div id="allproducts">


              </div>


              </div>
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

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
