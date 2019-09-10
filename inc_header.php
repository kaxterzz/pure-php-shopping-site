<?php 
$myaccount="";
$wishlist="";
$cart="";
$checkout="";
$login="";
if($c_page=='myaccount'){
	$myaccount='active';
	}
else if($c_page=='wishlist'){
	$wishlist='active';
	}
else if($c_page=='cart'){
	$cart='active';
	}
else if($c_page=='checkout'){
	$checkout='active';
	}	
else if($c_page=='login'){
	$login='active';
	}			
?>
<div class="main-top container-fluid">
	<div class="top row navbar navbar-default">
    	<div class="navbar-header">
            	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navi">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a href="<?php echo $base_url?>index.php"><img src="admin/images/logo.jpg" class="img-responsive" alt="business logo" /></a><!-- logo -->
            </div><!-- end navbar-header-->
            <!-- collection of navigations -->
       <div class="collapse navbar-collapse" id="navi">     
        <div class="col-md-8-offset-4">
        	<div class="shop-menu pull-right">
            	<ul class="nav navbar-nav">
                	<?php 
						if(!isset($_SESSION['customer'])|| !isset($_SESSION['customer']['cid'])){
								echo'<li class="'.($myaccount).'"><a href="myaccount.php"><span class="glyphicon glyphicon-user"></span> Account</a></li>';	
						   }
						   elseif(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid'])){
							 	echo'<li class="'.($myaccount).'"><a href="myaccount.php"><span class="glyphicon glyphicon-user"></span> ';
								$cid=$_SESSION['customer']['cid'];
								$sql="SELECT cus_fname FROM tbl_customer WHERE cus_id='$cid';";
								$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Eroor:".mysqli_error($GLOBALS['conn']));
								$row=mysqli_fetch_assoc($res);
								echo ''.$row['cus_fname'].'</a></li>';  
						   }
					?>
                	
                    <li class="<?php echo($wishlist) ?>"><a href="wishlist.php"><span class="glyphicon glyphicon-heart"></span> Wishlist</a></li>
                    <li class="<?php echo($cart) ?>"><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> cart
                    <?php
                        // count products in cart
						if(!isset($_SESSION['customer'])|| !isset($_SESSION['customer']['cid'])){
							$sql="SELECT SUM(cart_qnty) FROM tbl_cart WHERE session_id='$session_id';";
							$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							$row=mysqli_fetch_assoc($res);
							$cart_count=$row['SUM(cart_qnty)'];
						}
						elseif(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid'])){
							$cid=$_SESSION['customer']['cid'];
                        	$sql="SELECT SUM(cart_qnty) FROM tbl_cart WHERE cus_id='$cid';";
							$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							$row=mysqli_fetch_assoc($res);
							$cart_count=$row['SUM(cart_qnty)'];
						}
                        ?>
                        <span class="btn-primary"> <span class="badge " id="comparison-count"><?php echo $cart_count; ?></span></span>
                    </a></li>
                    <li class="<?php echo($checkout) ?>"><a href="checkout_bill_ship_info.php"><span class="glyphicon glyphicon-check"></span> Checkout</a></li>
                     
                    <?php if(!isset($_SESSION['customer'])|| !isset($_SESSION['customer']['cid'])){
								echo'<li class="'.($login).'"><a href="login.php"><span class="glyphicon glyphicon-lock"></span> Login</a></li>';	
						   }
						   elseif(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid'])){
							 	echo'<li class="'.($login).'"><a href="logout.php"><span class="glyphicon glyphicon-lock"></span> Logout</a></li>';  
						   }?>
                </ul>
            </div><!-- shop-menu -->
        </div><!-- shoppingcart/wishlist/checkout/account/login -->
       </div><!-- collapse navi --> 
    </div><!-- end top row -->
    
    
        </div><!-- end main top container -->
