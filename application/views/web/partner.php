<!DOCTYPE html>
<html lang="zxx">

<head>
    <base href="<?php echo base_url();?>">
    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fashi | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css1/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css1/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css1/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="css1/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css1/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css1/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css1/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css1/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css1/style.css" type="text/css">
<style type="text/css">
     .tab {
            float: left;
            /*background-color: #f2f2f2;*/
            width: 100%;
            /*height: auto;*/
            font-size: 14px;
            font-family: inherit;
            color: #171919;
            font-weight: normal;
            margin-top: 20px;
            margin-bottom: 20px;
        }
            /* Style the buttons inside the tab */
            .tab button {
                display: inline-flex;
                background-color: inherit;
                color: black;
                padding: 10px 16px;
                /*width: 100%;*/
                border: none;
                outline: none;
                text-align: left;
                cursor: pointer;
                transition: 0.3s;
                font-size: 16px;
                /*border-bottom: 1px solid rgba(0,0,0,0.1);*/
            }
                /* Change background color of buttons on hover */
                .tab button:hover {
                    /*background-color: #aaaaaa;*/
                    /*color: #fff;*/
                }
                /* Create an active/current "tab button" class */
                .tab button.active {
                    border-bottom: 3px solid #e7ab3c;
                    color: #171919;
                }
        /* Style the tab content */
        .tabcontent {
            width: 100%;
            border-left: none;
        }

</style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="./index.html">
                                <img src="img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-lg-7">
                        <div class="advanced-search">
                            <button type="button" class="category-btn">All Categories</button>
                            <form action="#" class="input-group">
                                <input type="text" placeholder="What do you need?">
                                <button type="button"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 text-right col-lg-3">
                        <ul class="nav-right">
                            <li class="heart-icon"><a href="#">
                                    <i class="icon_heart_alt"></i>
                                    <span>1</span>
                                </a>
                            </li>
                            <li class="cart-icon"><a href="#">
                                    <i class="icon_bag_alt"></i>
                                    <span>3</span>
                                </a>
                                <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="si-pic"><img src="img/select-product-1.jpg" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>$60.00 x 1</p>
                                                            <h6>Kabino Bedside Table</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i class="ti-close"></i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="si-pic"><img src="img/select-product-2.jpg" alt=""></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>$60.00 x 1</p>
                                                            <h6>Kabino Bedside Table</h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i class="ti-close"></i>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>total:</span>
                                        <h5>$120.00</h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="#" class="primary-btn view-card">VIEW CARD</a>
                                        <a href="#" class="primary-btn checkout-btn">CHECK OUT</a>
                                    </div>
                                </div>
                            </li>
                            <li class="cart-price">$150.00</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>All departments</span>
                        <ul class="depart-hover">
                            <li class="active"><a href="#">Women’s Clothing</a></li>
                            <li><a href="#">Men’s Clothing</a></li>
                            <li><a href="#">Underwear</a></li>
                            <li><a href="#">Kid's Clothing</a></li>
                            <li><a href="#">Brand Fashion</a></li>
                            <li><a href="#">Accessories/Shoes</a></li>
                            <li><a href="#">Luxury Brands</a></li>
                            <li><a href="#">Brand Outdoor Apparel</a></li>
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li><a href="./index.html">Home</a></li>
                        <li><a href="./shop.html">Shop</a></li>
                        <li><a href="#">Collection</a>
                            <ul class="dropdown">
                                <li><a href="#">Men's</a></li>
                                <li><a href="#">Women's</a></li>
                                <li><a href="#">Kid's</a></li>
                            </ul>
                        </li>
                        <li><a href="./blog.html">Blog</a></li>
                        <li><a href="./contact.html">Contact</a></li>
                        <li><a href="#">Pages</a>
                            <ul class="dropdown">
                                <li><a href="./blog-details.html">Blog Details</a></li>
                                <li><a href="./shopping-cart.html">Shopping Cart</a></li>
                                <li><a href="./check-out.html">Checkout</a></li>
                                <li><a href="./faq.html">Faq</a></li>
                                <li><a href="./register.html">Register</a></li>
                                <li><a href="<?php echo base_url('Frientend/login');?>">Login</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Login</span>
                    </div>
                </div>
        </div>
    </div>
    <!-- Breadcrumb Form Section Begin -->

            </div>
    <!-- Register Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
    <?php
        $i=0;
         $getdata = $this->Home_model->get_all(SLIDERS);
         foreach ($getdata as $value) {
    ?>
                 <div class="col-lg-6 offset-lg-3">
                        <h2>Partners Registration</h2>
                    <div class="tab">
                     <button class="tablinks active" onclick="openCity(event, 'Paris')" id="defaultOpen">Personal</button>
                     
                      <button class="tablinks" onclick="openCity(event, 'Store')">Store Detail</button>
                      <button class="tablinks" onclick="openCity(event, 'Legal')">Legal Detal</button>
                      <button class="tablinks" onclick="openCity(event, 'Bank')">Bank Detail</button>
                 </div>

               <form  method="POST" action="<?php echo base_url();?>Frientend/add_partneraction" enctype="multipart/form-data" >

                 <div id="Paris" class="tabcontent">
                      <div class="login-form">
                      
                            <div class="group-input">
                                <label for="username">Name</label>
                                <input type="text" id="username" name="username">
                            </div>
                            <div class="group-input">
                                <label for="pass">Email</label>
                                <input type="email" id="email" name="email">
                            </div>
                              <div class="group-input">
                                <label for="pass">Mobile</label>
                                <input type="contact" id="contact" name="contact">
                            </div>
                              <div class="group-input">
                                <label for="pass">Password</label>
                                <input type="password" id="password" name="password">
                            </div>
                              <div class="group-input">
                                <label for="pass">Profile Pic</label>
                                <input type="file" id="profilepic" name="profilepic">
                            </div>
                           
                            <button type="button" class="site-btn login-btn" onclick="openCity(event, 'Store')" >Sign In</button>
                       
                        <div class="switch-login">
                            <!-- <a href="./register.html" class="or-login">Or Create An Account</a> -->
                        </div>
                    </div>
                 </div>

                 <div id="Store" class="tabcontent">
                   <div class="login-form">
                      
                            <div class="group-input">
                                <label for="username">PickUpAddress</label>
                                <textarea class="form-control" name="PickUpAddress" id="PickUpAddress" ></textarea>
                            </div>
                            <div class="group-input">
                                <label for="pass">PickUpPIN</label>
                                <textarea class="form-control" name="PickUpPIN" id="PickUpPIN"></textarea>
                                <!-- <input type="email" id="pass"> -->
                            </div>
                              <div class="group-input">
                                <label for="pass">Country</label>
                                <select class="form-control" name="Country" id="Country">
                                    <option>India</option>
                                    
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="pass">State</label>
                                <select class="form-control" name="State" id="State">
                                    <option>Madhya Pradesh</option>
                                    <option>Tehalgana</option>
                                    <!-- <option>Bhopal</option> -->
                                </select>
                            </div>
                             <div class="group-input">
                                <label for="pass">City</label>
                                <select class="form-control" name="City" id="City">
                                    <option>Dhar</option>
                                    <option>Indore</option>
                                    <option>Bhopal</option>
                                </select>
                            </div>
                             <div class="group-input">
                                <label for="username">Personal Address</label>
                                <textarea class="form-control" name="Personal_Address" id="Personal_Address"></textarea>
                            </div>
                            <div class="group-input">
                                <label for="pass">Personal PIN</label>
                                <textarea class="form-control" name="Personal_PIN" id="Personal_PIN"></textarea>
                                <!-- <input type="email" id="pass"> -->
                            </div>
                             
                           
                            <button type="button" class="site-btn login-btn"  onclick="openCity(event, 'Legal')" >Sign In</button>
                     
                    </div>
                </div>
                <div id="Legal" class="tabcontent">
                   <div class="login-form">
                      
                            <div class="group-input">
                                <label for="username">IsStoreIdAvailable</label>
                                <select class="form-control" name="IsStoreIdAvailable" id="IsStoreIdAvailable">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="username">StoreIdType</label>
                                <select class="form-control" name="StoreIdType" id="StoreIdType">
                                    <option>Addhar No</option>
                                    <option>GSTNumber</option>
                                </select>
                            </div>
                              <div class="group-input">
                                <label for="pass">StoreIdNumber</label>
                                <input type="text" name="StoreIdNumber" id="StoreIdNumber">
                            </div>
                              <div class="group-input">
                                <label for="pass">GSTNumber</label>
                                <input type="text" name="GSTNumber" id="GSTNumber">
                            </div>
                            
                            
                             
                           
                            <button type="button" class="site-btn login-btn" onclick="openCity(event, 'Bank')">Sign In</button>
                      
                    </div>
                </div>
                <div id="Bank" class="tabcontent">
                   <div class="login-form">
                      
                            <div class="group-input">
                                <label for="username">BankIfscCode</label>
                               <input type="text" name="BankIfscCode" id="BankIfscCode">

                            </div>
                            <div class="group-input">
                                <label for="pass">AccountNumber</label>
                               <input type="text" name="AccountNumber" id="AccountNumber">

                                <!-- <input type="email" id="pass"> -->
                            </div>
                              <div class="group-input">
                                <label for="pass">AccountHolderName</label>
                               <input type="text" name="AccountHolderName" id="AccountHolderName">
                            </div>
                            
                            <button type="submit" class="site-btn login-btn">Sign In</button>
                       
                    </div>
                </div>
                 </form>
                       
            </div>

<?php } ?>        
        </div>
    </div>
    <!-- Register Form Section End -->



    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-left">
                        <div class="footer-logo">
                            <a href="#"><img src="img/footer-logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 60-49 Road 11378 New York</li>
                            <li>Phone: +65 11.188.888</li>
                            <li>Email: hello.colorlib@gmail.com</li>
                        </ul>
                        <div class="footer-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <div class="footer-widget">
                        <h5>Information</h5>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Checkout</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Serivius</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h5>My Account</h5>
                        <ul>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Shopping Cart</a></li>
                            <li><a href="#">Shop</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="newslatter-item">
                        <h5>Join Our Newsletter Now</h5>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#" class="subscribe-form">
                            <input type="text" placeholder="Enter Your Mail">
                            <button type="button">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-reserved">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                       
                        <div class="payment-pic">
                            <img src="img/payment-method.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js1/jquery-3.3.1.min.js"></script>
    <script src="js1/bootstrap.min.js"></script>
    <script src="js1/jquery-ui.min.js"></script>
    <script src="js1/jquery.countdown.min.js"></script>
    <script src="js1/jquery.nice-select.min.js"></script>
    <script src="js1/jquery.zoom.min.js"></script>
    <script src="js1/jquery.dd.min.js"></script>
    <script src="js1/jquery.slicknav.js"></script>
    <script src="js1/owl.carousel.min.js"></script>
    <script src="js1/main.js"></script>
<script type="text/javascript">
    function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
</script>
</body>

</html>