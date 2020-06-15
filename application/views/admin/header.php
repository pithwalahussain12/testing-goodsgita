<!DOCTYPE html>
<html>
<head>
 <base href="<?php echo base_url();?>">   	
<meta charset="UTF-8">
<title>Shopping | Dashboard</title>

<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- bootstrap 3.0.2 -->
<link href="<?php echo base_url() ?>admin-assets/dashboard_css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="<?php echo base_url() ?>admin-assets/dashboard_css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="<?php echo base_url() ?>admin-assets/dashboard_css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<!-- Theme style -->
<link href="<?php echo base_url() ?>admin-assets/dashboard_css/AdminLTE.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>admin-assets/dashboard_css/calendar.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>admin-assets/dashboard_css/bootstrap-datepicker.css" rel="stylesheet">


<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url() ?>admin-assets/dashboard_js/jquery.min.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="<?php echo base_url() ?>admin-assets/dashboard_js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url() ?>admin-assets/dashboard_js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morrs.js charts -->
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>admin-assets/dashboard_js/AdminLTE/app.js" type="text/javascript"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>admin-assets/dashboard_js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>admin-assets/dashboard_js/bootstrap-datepicker.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.1/ckeditor.js"></script>
</head>
<body class="skin-blue">
<!-- header logo: style can be found in header.less -->
<header class="header">
<a href="<?php echo base_url();?>koreatown-administrator" class="logo">
<!-- Add the class icon to your logo image or logo icon to add the margining -->
<img src="http://localhost/service/uploads/logoimg/c78aea31460925b03664bff79259431f.png" style=" height: 34px;>
<img src="" style=" height: 34px;">
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
<!-- Sidebar toggle button-->
<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</a>

<p class="text-white">Admin Panel</p>
<div class="navbar-right">
<ul class="nav navbar-nav">
<!-- Notifications: style can be found in dropdown.less -->
<li class="dropdown notifications-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-unsorted"></i>
		 <span class="" style="margin-left:5px;">More Option</span>
	</a>
	<ul class="dropdown-menu" style="height:200px;">
		<li class="header">You have option</li>
		<li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu" >
				<li>
					<a href="<?php echo base_url() ?>koreatown-administrator/change_password">
						<i class="fa fa-gift"></i>Change Password
					</a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>koreatown-administrator/change_user">
						<i class="ion ion-ios7-people info"></i> Change User
					</a>
				</li>
	
				<li>
					<a href="<?php echo base_url() ?>koreatown-administrator/changelogo">
						<i class="ion ion-ios7-people info"></i> Change Logo
					</a>
				</li>			
			</ul>
		</li>
	</ul>
</li>
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="glyphicon glyphicon-user"></i>
		<span><?php echo $this->session->userdata('admin_name'); ?> <i class="caret"></i></span>
	</a>
	<ul class="dropdown-menu">
		<!-- User image -->
		<li class="user-header bg-light-blue">
			<img src="<?php echo base_url(); ?>admin-assets/dashboard_img/logo.png" class="img-circle" alt="User Image" />
			<p>
				<?php echo $this->session->userdata('admin_name'); ?>
				<small><?php echo $this->session->userdata('admin_email'); ?></small>
				
			</p>
		</li>
		<!-- Menu Body -->
	   
		<!-- Menu Footer-->
		<li class="user-footer">

			<div class="pull-right">
				<a href="<?php echo base_url(); ?>koreatown-administrator/logout" class="btn btn-default btn-flat">Sign out</a>
			</div>
		</li>
	</ul>
</li>
</ul>
</div>
</nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<!-- Sidebar user panel -->
<div class="user-panel">
<div class="pull-left image">
	<img src="<?php echo base_url(); ?>admin-assets/dashboard_img/avatar3.png" class="img-circle" alt="User Image" />
</div>
<div class="pull-left info">
	<p>Hello, <?php echo $this->session->userdata('admin_name') ?></p>

	<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
</div>
</div>

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
<?php if($this->session->userdata('userType') == 1){ ?>
<li class="active">
	<a href="<?php echo base_url(); ?>koreatown-administrator">
		<i class="fa fa-dashboard"></i> <span>Dashboard</span>
	</a>
</li>
<!-- <li id="users">
	<a href="<?php //echo base_url(); ?>koreatown-administrator/UserList">
		<i class="fa fa-user"></i> <span>All Users</span>
	</a>
</li> -->
<li id="merchants">
	<a href="<?php echo base_url(); ?>koreatown-administrator/MerchantList">
		<i class="fa fa-user"></i> <span>Partners</span>
	</a>
</li>
<li>
	<a href="#">
		<i class="fa fa-user"></i> <span>Customers</span>
	</a>
</li>
<li>
	<a href="#">
		<i class="fa fa-user"></i> <span>Offers</span>
	</a>
</li>
<li>
	<a href="#">
		<i class="fa fa-user"></i> <span>Orders</span>
	</a>
</li>

<li id="sliders">
	<a href="<?php echo base_url(); ?>koreatown-administrator/Allsliders">
		<i class="fa fa-user"></i> <span> Banners</span>
	</a>
</li>

<li id="products">
	<a href="<?php echo base_url(); ?>koreatown-administrator/AllProducts">
		<i class="fa fa-product-hunt"></i> <span>Products</span>
	</a>
</li>
<!-- <li id="coupon">
	<a href="<?php //echo base_url(); ?>koreatown-administrator/CouponList">
		<i class="far fa-tags"></i> <span>Coupon List</span>
	</a>
</li>
<li id="order">
	<a href="<?php //echo base_url(); ?>koreatown-administrator/OrdersList">
		<i class="fa fa-shopping-cart"></i> <span>Order List</span>
	</a>
</li> -->
<li id="category">
	<a href="<?php echo base_url(); ?>koreatown-administrator/Category">
		<i class="fa fa-list"></i> <span>Category</span>
	</a>
</li>
<li id="subcategory">
	<a href="<?php echo base_url(); ?>koreatown-administrator/Subcategory">
		<i class="fa fa-list"></i> <span>Sub-Category</span>
	</a>
</li>

<?php }else{  ?>

<li class="active">
	<a href="<?php echo base_url(); ?>koreatown-administrator">
		<i class="fa fa-dashboard"></i> <span>Dashboard</span>
	</a>
</li>

<li id="products">
	<a href="<?php echo base_url(); ?>koreatown-administrator/AllProductsmerchant">
		<i class="fa fa-product-hunt"></i> <span>Products</span>
	</a>
</li>
<li id="order">
	<a href="<?php echo base_url(); ?>koreatown-administrator/MerchanOrders">
		<i class="fa fa-shopping-cart"></i> <span>Order List</span>
	</a>
</li>
<?php }  ?>
<!--<li id="newspapers">
	<a href="<?php echo base_url(); ?>koreatown-administrator/All_newspaper">
		<i class="fa fa-user"></i> <span>All Newspapers</span>
	</a>
</li>-->	
</ul> 
</section>
<!-- /.sidebar -->
</aside>
<!-- Modal HTML -->
    <div id="change_stau" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
               
                <div class="modal-body">
                    <p>Do you want to  Change status ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="dlt_change">Change</button>
                </div>
            </div>
        </div>
    </div>

<!-- Model for show success message -->
 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="success_message" class="modal fade" style="display: none;z-index:10000;">
        <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header header_editcat">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Success Message</h4>
                </div>
                <div class="modal-body login-modal">
				<div class="clearfix"></div>
				<div class="modal-body-left">	
                    <div class="form-group clearfix" id="successmessage"></div>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>   
    
<!-- Model for show success message -->

 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="error_message" class="modal fade" style="display: none;z-index: 10000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header_editcat">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Error Message</h4>
                </div>
                <div class="modal-body login-modal">
				<div class="clearfix"></div>
				<div class="modal-body-left">	
                    <div class="form-group clearfix" id="errormessage"></div>
                </div>
                <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>  
<!-- Modal HTML -->
    <div id="confirm" class="modal fade" style="z-index:10000;">
        <div class="modal-dialog">
            <div class="modal-content">
               
                <div class="modal-body">
                    <p>Do you want to delete selected record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal HTML -->
    <div id="change_stau" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
               
                <div class="modal-body">
                    <p>Do you want to  Change status ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="dlt_change">Change</button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal HTML -->
    <div id="delete_all_coupon" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
               
                <div class="modal-body">
                    <p>Are you sure! You want to delete all product.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="dlt_coupon">Yes</button>
                </div>
            </div>
        </div>
    </div>
