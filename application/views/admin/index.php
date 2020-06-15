<?php  $this->load->view('admin/header'); ?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Dashboard
<small>Control panel</small>
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url();?>koreatown-administrator"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Dashboard</li>
</ol>
</section>

<!-- Main content -->
<section class="content">

<!-- Small boxes (Stat box) -->
<div class="row">

<?php if($this->session->userdata('userType') == 1){ ?>
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-yellow">
<div class="inner">
	
<h3>

<?php if(!empty($total_users))echo $total_users; else echo "0";?>

</h3>
<p>Registered Users </p>
</div>
<div class="icon">
<i class="ion ion-person-add"></i>
</div>
<a href="<?php echo base_url(); ?>koreatown-administrator/AllUsers" class="small-box-footer">
More info <i class="fa fa-arrow-circle-right"></i>
</a>
</div>
</div><!-- ./col -->
<?php } ?>

<?php if($this->session->userdata('userType') == 1){ ?>
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-green">
<div class="inner">
	
<h3>
<?php if(!empty($total_merchants))echo $total_merchants; else echo "0";?>
</h3>
<p>Registered Merchants </p>
</div>

<div class="icon">
<i class="ion ion-person-add"></i>
</div>
<a href="<?php echo base_url(); ?>koreatown-administrator/AllMerchants" class="small-box-footer">
More info <i class="fa fa-arrow-circle-right"></i>
</a>
</div>
</div><!-- ./col -->
<?php }  ?>

<?php if($this->session->userdata('userType') == 1){ ?>
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-blue">
<div class="inner">

	
	
<h3>
<?php if(!empty($total_products))echo $total_products; else echo "0";?>

</h3>
<p>Total Products </p>
</div>
<div class="icon">
<i class="ion ion-bag"></i>
</div>
<a href="<?php echo base_url(); ?>koreatown-administrator/AllProducts" class="small-box-footer">
More info <i class="fa fa-arrow-circle-right"></i>
</a>
</div>
</div><!-- ./col -->
<?php } ?>

<?php if($this->session->userdata('userType') == 1){ ?>
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-blue">
<div class="inner">
<h3>
<?php if(!empty($total_orders))echo $total_orders; else echo "0";?>

</h3>
<p>Total Orders </p>
</div>
<div class="icon">
<i class="ion ion-bag"></i>
</div>
<a href="<?php echo base_url(); ?>koreatown-administrator/OrdersList" class="small-box-footer">
More info <i class="fa fa-arrow-circle-right"></i>
</a>
</div>
</div><!-- ./col -->
<?php } ?>


<?php if($this->session->userdata('userType') == 2){ ?>
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-blue">
<div class="inner">

	
	
<h3>
<?php if(!empty($total_productmerchant))echo $total_productmerchant; else echo "0";?>

</h3>
<p>Total Products </p>
</div>
<div class="icon">
<i class="ion ion-bag"></i>
</div>
<a href="<?php echo base_url(); ?>koreatown-administrator/AllProductsmerchant" class="small-box-footer">
More info <i class="fa fa-arrow-circle-right"></i>
</a>
</div>
</div><!-- ./col -->
<?php } ?>

<?php if($this->session->userdata('userType') == 2){ ?>
<div class="col-lg-3 col-xs-6">
<!-- small box -->
<div class="small-box bg-blue">
<div class="inner">
<h3>
<?php if(!empty($total_merchantproducts))echo $total_merchantproducts; else echo "0";?>

</h3>
<p>Total Orders </p>
</div>
<div class="icon">
<i class="ion ion-bag"></i>
</div>
<a href="<?php echo base_url(); ?>koreatown-administrator/MerchanOrders" class="small-box-footer">
More info <i class="fa fa-arrow-circle-right"></i>
</a>
</div>
</div><!-- ./col -->
<?php } ?>


</div><!-- /.row -->

</section><!-- /.content -->
</aside><!-- /.right-side -->

<?php $this->load->view('admin/footer'); ?>

