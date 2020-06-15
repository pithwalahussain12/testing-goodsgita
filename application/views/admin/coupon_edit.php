<?php $this->load->view('admin/header');    ?>

<script>
$(document).ready(function(){   
$('#update_category_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#coupon').addClass('active');
  $('#all_icloud_ul').show();
    
  });


</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
Edit Coupon - <?php echo $edit_data->couponCode; ?>

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/CouponList">Coupon</a></li>

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

<form role="form" id="update_category_form" name="update_category_form" method="POST" action="<?php echo base_url();?>koreatown-administrator/update_coupon/<?php echo $edit_data->id; ?>" enctype="multipart/form-data" >
<div class="box-body">

    <div class="form-group">
		<label class="control-label">User Name</label>
		<select name="username" id="username" class="form-control required">			
			<?php foreach($getuserdata as $data){ ?>
			   <option value="<?php echo $data->id; ?>" <?php if($data->id == $edit_data->userId){ echo 'selected';} ?> ><?php echo $data->name ?></option>			
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label">Coupon Code</label>
			<input type="text" value="<?php echo $edit_data->couponCode; ?>" class="form-control required allownumericwithoutdecimal" name="couponCode" id="couponCode"  >
	</div>
	
	<div class="form-group">
		<label class="control-label">Coupon Amount</label>
			<input type="text" value="<?php echo $edit_data->couponAmount; ?>" class="form-control required allownumericwithdecimal" name="couponAmount" id="couponAmount"  >
	</div>
	
	<div class="form-group">
		<label class="control-label">  Vailid From </label>
                <input type="text" value="<?php echo $edit_data->availFrom; ?>" class="form-control required " name="availFrom"   id="availFrom"  readonly>	
	</div>	

	<div class="form-group">
		<label class="control-label">  Expire Date </label>
			<input type="text" value="<?php echo $edit_data->expireDate; ?>" class="form-control required " name="expireDate"   id="expireDate" readonly >			
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
var startDate = new Date();
var fechaFin = new Date();
var FromEndDate = new Date();
var ToEndDate = new Date();
$('#availFrom').datepicker({
    autoclose: true,
	startDate: startDate,
    format: 'yyyy-mm-dd'
}).on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#expireDate').datepicker('setStartDate', startDate);
    }); 

$('#expireDate').datepicker({
    autoclose: true,
    format:'yyyy-mm-dd'
}).on('changeDate', function(selected){
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('#availFrom').datepicker('setEndDate', FromEndDate);
    });

	
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
