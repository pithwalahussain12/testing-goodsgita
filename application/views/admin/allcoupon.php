<?php $this->load->view('admin/header');    ?>

<script type="text/javascript">
$(document).ready( function () {
  
  $('.sidebar-menu li').removeClass('active');
  $('#allusers').addClass('active');
  $('#allusers a').find('i:last').addClass('fa-angle-down');
  $('#coupon').addClass('active');
  $('#all_userul').show();
  
  getall_coupon();
});

/* get all users code */
function getall_coupon()
{          
			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>koreatown-administrator/get_coupon",	
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
						 show_data  +='<table class="table table-bordered"><tr><th width="10%">S.No.</th><th width="25%">Image</th><th width="25%"> Name</th><th width="25%">Action</th></tr><tr><td colspan="14" align="center"><span>No record here !</span></td></tr></table>';
						 
						}
						
						  $('#allusers').html(show_data);
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
						show_data  +='<table class="table table-bordered"><tr><th width="10%">S.No.</th><th width="25%">Image</th><th width="25%"> Name</th><th width="25%">Action</th></tr><tr><td colspan="14" align="center"><span>No record here !</span></td></tr></table>';
						}
						
						  $('#allusers').html(show_data);
						  $('.pag_bx1').html(response["pagination"]);
				 }
			 });
});
function delete_users(id)
{
	$('#confirm').modal({ backdrop: 'static', keyboard: false })
        .one('click', '#delete', function (e) { 
			
			location.href ='<?php echo base_url() ?>koreatown-administrator/delete_users/'+id;
			
	});
	
}

</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Coupon
</h1>

 
<h1 align="center">
<?php
	if($this->session->flashdata('err_login') != ''){
	 echo '<div class="alert alert-error alert-dismissible">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Error!</strong> '.$this->session->flashdata('err_login').'
		</div>';
	}					
?>
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/CouponList">Coupon</a></li>
</ol>
</section>

<!-- Main content -->
<section class="content">
	
<div class="row">

   
<div class="col-xs-12">
<div class="row"  style="margin-bottom:10px;">
<a href="<?php echo base_url() ?>koreatown-administrator/add_coupon"><button class="btn btn-primary pull-right" type="button" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Coupon</button></a>

   
</div>
<div id="allusers">


</div>

<div class="box-footer clearfix">
<ul class="pagination pagination-sm no-margin pull-right pag_bx1">

</ul>
</div>

</div><!-- /.col -->
</div><!-- /.box-body -->
</div><!-- /.row -->

</section><!-- /.content -->                
</aside><!-- /.right-side -->

<?php $this->load->view('admin/footer');    ?>
