<?php $this->load->view('admin/header');    ?>

<script type="text/javascript">
$(document).ready( function () {
  
  $('.sidebar-menu li').removeClass('active');
  $('#allsubcategory').addClass('active');
  $('#allsubcategory a').find('i:last').addClass('fa-angle-down');
  $('#subcategory').addClass('active');
  $('#all_userul').show();
  
  getall_subcategory();
});

/* get all subcategory code */
function getall_subcategory()
{          
			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>koreatown-administrator/get_subcategory",	
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
						 show_data  +='<table class="table table-bordered"><tr><th width="10%">S.No.</th><th width="25%">SubCategory-Name</th><th width="25%">Category-Name</th><th width="25%"> Description</th><th width="25%"> Create Date</th><th width="25%">Action</th></tr><tr><td colspan="14" align="center"><span>No record here !</span></td></tr></table>';
						 
						}
						
						  $('#allsubcategory').html(show_data);
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
						show_data  +='<table class="table table-bordered"><tr><th width="10%">S.No.</th><th width="25%">SubCategory-Name</th><th width="25%">Category-Name</th><th width="25%"> Description</th><th width="25%"> Create Date</th><th width="25%">Action</th></tr><tr><td colspan="14" align="center"><span>No record here !</span></td></tr></table>';
						}
						
						  $('#allsubcategory').html(show_data);
						  $('.pag_bx1').html(response["pagination"]);
				 }
			 });
});
function delete_subcategory(id)
{
	$('#confirm').modal({ backdrop: 'static', keyboard: false })
        .one('click', '#delete', function (e) { 
			
			location.href ='<?php echo base_url() ?>koreatown-administrator/delete_subcategory/'+id;
			
	});
	
}

</script>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Sub-Category

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
<li><a href="<?php echo base_url();?>koreatown-administrator/Subcategory">Sub-Category</a></li>
</ol>
</section>

<!-- Main content -->
<section class="content">
	
<div class="row">

   
<div class="col-xs-12">
	<div class="row"  style="margin-bottom:10px;">
<a href="<?php echo base_url() ?>koreatown-administrator/add_subcategory"><button class="btn btn-primary pull-right" type="button" style="margin-right:10px;"><i class="fa fa-plus"></i> Add Sub-Category</button></a>

   
</div>
<div id="allsubcategory">


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
