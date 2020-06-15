<?php $this->load->view('admin/header');    ?>
<style>
   #total {
      text-align:right;
   }

   #table {
      border:0px solid red;
      border-collapse:separate;
   }

   #table th, #table td {
      border:0px solid #000;
   }
</style>   


<script>
$(document).ready(function(){   
$('#update_merchant_form').validate();

  $('.sidebar-menu li').removeClass('active');
  $('#allicloud').addClass('active');
  $('#allicloud a').find('i:last').addClass('fa-angle-down');
  $('#order').addClass('active');
  $('#all_icloud_ul').show();
    
  });


</script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
<!-- Content Header (Page header) -->
<section class="content-header">
<h1 align="center">
View Order Detail

</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url();?>koreatown-administrator/MerchantList">Order Detail</a></li>

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

<form role="form" id="add_newspaper_form" name="add_newspaper_form" method="POST" action="" enctype="multipart/form-data" >
<h4 style="text-align:center;">OrderId : <?php echo $orderId; ?></h4>
<table id="table" width="100%" cellpadding="10">

  <thead>
   <tr>
     <th>Image</th>  
     <th>Prosuct Name</th>
     <th>Quantity</th>
     <th>Price</th>
     <th>Total Sum</th>
   </tr>
  </thead>
   <tbody>
 <?PHP $sumamount=0; foreach($view_data as $data){ ?> 
 
   <tr>     
     <td><img src="uploads/galleryimg/<?php if(!empty($data->imageGallery)){echo $data->imageGallery;} else{ echo "noimage.png";} ?>"  height="60px";  width="100px"; ></img> </td>
     <td><?php if(!empty($data->productName)){echo $data->productName;} else{ echo "NON";} ?></td>
     <td><?php if(!empty($data->quantity)){echo $data->quantity;} else{ echo "NON";} ?></td>
     <td><?php if(!empty($data->price)){echo $data->price;} else{ echo "NON";} ?></td>
     <td><?php $sumprice = $data->quantity*$data->price; echo number_format($sumprice, 2); ?></td>
     <?php  $sumamount = $sumamount + $sumprice; ?>	 
   </tr>   
  
 <?php } ?>	  
  </tbody>
  <tfoot>
    <tr>
      <th id="total" colspan="4">Total Amount:</th>
      <td><?php echo number_format($sumamount, 2); ?></td>
    </tr>
   </tfoot>
 </table>

</div><!-- /.box -->
</div><!--/.col (left) -->
</div><!-- /.row -->
</section><!-- /.content -->                
</aside><!-- /.right-side -->
<?php $this->load->view('admin/footer');    ?>
