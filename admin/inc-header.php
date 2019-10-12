<?php
//-- active the appropriate tab in the navbar according to the current page --
$home="";
//$myacc="";
$sales="";
$inven="";
$purch="";
$emp="";
$exp="";
$rep="";
$admin="";
if($c_page=='dashbord'){
	$home='active';
	}
/*else if($c_page=='myaccount'){
	$myacc='active';
	}*/	
else if($c_page=='sales'){
	$sales='active';
	}
else if($c_page=='inventory'){
	$inven='active';
	}
else if($c_page=='purchases'){
	$purch='active';
	}	
else if($c_page=='employees'){
	$emp='active';
	}
/*else if($c_page=='vehicles'){
	$veh='active';
	}*/
else if($c_page=='expense'){
	$exp='active';
	}	
else if($c_page=='reports'){
	$rep='active';
	}		
else if($c_page=='administration'){
	$admin='active';
	}			
?>
<div class="container-fluid header"> 
        <div class="top">
        	<div class="bannar col-lg-12 col-md-12 col-sm-12 col-xs-12"><a href="#"><img src="<?php echo($base_url)?>images/header_bannar.png" width="100%" class="img-responsive" align=center/></a></div><!-- end bannar -->
            </div>
         </div><!-- end top -->
         
     <?php 
		if(isset($_SESSION['employee']) && $_SESSION['employee']['etype']=="J0001"):
				$logempid=$_SESSION['employee']['eid'];
				 ?>
                <div class="navigation">    
   		 <nav class="navbar navbar-default">
    	<!--<div class="container">-->
        	<div class="navbar-header">
            	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navi">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div><!-- end navbar-header-->
            <!-- collection of navigations -->
            <div class="collapse navbar-collapse" id="navi">
            	<ul class="nav navbar-nav">
                    <li class="<?php echo($home) ?>"><a href="../admin_dashboard.php"><span class="glyphicon glyphicon-home"></span></a></li><!-- home -->
                    <li class="dropdown <?php echo($sales) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sales <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Customer</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>sales/view_cus.php">View Customer Details</a></li>
                         	</ul><!-- end sub menu customer details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Sales Orders</a>
                        	<ul class="dropdown-menu">
                        		<li><a href="<?php echo $base_url?>sales/view_order.php">View Sales Orders</a></li>
                         	</ul><!-- end sub menu sales orders details -->
                         </li><!-- end dropdown-submenu --> 
                        <li class="divider"></li>
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Sales Returns</a>
                        	<ul class="dropdown-menu">
                       			 <li><a href="<?php echo $base_url?>sales/sales_return.php?">View Sales Return</a></li>
                         	</ul><!-- end sub menu sales return details -->
                         </li><!-- end dropdown-submenu --> 
                        <li class="divider"></li>
                      </ul><!-- end inner-menu of sales -->
                    </li><!-- end sales dropdown -->
                    <li class="dropdown <?php echo($inven) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Inventory <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Batches</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>inventory/view_batch.php">View Batch Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                         <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Products</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>inventory/view_product.php">View Product Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>inventory/categoryWindow.php">View Category Details</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>inventory/brandWindow.php">View Brand Details</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>inventory/view_current_stock.php">View Current Stock</a></li>
                      </ul><!-- end inner-menu of inventory -->
                    </li><!-- end inventory dropdown -->
                    <li class="dropdown <?php echo($purch) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Purchases <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Supplier</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>purchases/add_sup.php?action=add">Add New Supplier</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url?>purchases/view_sup.php">View Supplier Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>purchases/pur_return.php">View Purchases Return</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>purchases/credit_pur.php">View Credit Purchases</a></li>
                      </ul><!-- end inner-menu of purchases -->
                    </li><!-- end purchases dropdown -->
                    <li class="dropdown <?php echo($emp) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Employees <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                      	<li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Employee</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>employee/view_emp.php">View Employee Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->           
                      </ul><!-- end inner-menu of employees -->
                    </li><!-- end employees dropdown -->
                    <li class="dropdown <?php echo($exp) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Expenses <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo $base_url?>expense.php?action=add">Add Expence</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>expense.php">View Expence</a></li>
                      </ul><!-- end inner-menu of expenses -->
                    </li><!-- end expenses dropdown -->
                    <li class="dropdown <?php echo($rep) ?>">
                      <a href="<?php echo $base_url ?>reports/reports.php"role="button">Reports</a>
                    </li><!-- end reports dropdown -->
                    <li class="dropdown <?php echo($admin) ?>">
                      <a href="#" data-toggle="dropdown" role="button" aria-expanded="false">Administration <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                      	<li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Account</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>employee/my_account.php">My Account</a></li>
                                <li><a href="<?php echo $base_url?>employee/reset_acc.php">Reset Account</a></li>
 							</ul><!-- end submenu of Account -->
                        </li><!-- end dropdown-submenu -->   
                      </ul><!-- end inner-menu of administration -->
                   </li><!-- end administration dropdown -->
                    
                    <li><a href="<?php echo $base_url ?>emp_logout.php">Logout <span class="glyphicon glyphicon-lock"></span></a></li>
      </ul>
            </div><!-- end navi -->
        <!--</div><!-- end container -->
    </nav><!-- end navbar -->
 </div><!-- end navigation -->
 
 <div class="top2 alert alert-info" style="margin:0px;padding:0px">
 			<?php $sql="SELECT emp_fname,emp_lname FROM tbl_emp WHERE emp_id='$logempid';";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				$nor=mysqli_num_rows($res);
				if($nor>0){
					$row=mysqli_fetch_assoc($res);
				}
			?>
            <table class="col-md-12">
         	<td class="col-md-10"><span class="glyphicon glyphicon-user"></span> Welcome, <b><?php echo $row['emp_fname']." ".$row['emp_lname'] ?></b></td>
            <td class="col-md-2"><b> <span id="clock"></span></b></td>
            </table>
            
 </div><!-- end top2 -->
</div><!-- end container header -->
	<?php	
		elseif(isset($_SESSION['employee']) && $_SESSION['employee']['etype']=="J0002"):
				$logempid=$_SESSION['employee']['eid']; ?>
                <div class="navigation">    
   		 <nav class="navbar navbar-default">
    	<!--<div class="container">-->
        	<div class="navbar-header">
            	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navi">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div><!-- end navbar-header-->
            <!-- collection of navigations -->
            <div class="collapse navbar-collapse" id="navi">
            	<ul class="nav navbar-nav">
                    <li class="<?php echo($home) ?>"><a href="../admin_dashboard.php"><span class="glyphicon glyphicon-home"></span></a></li><!-- home -->
                    <li class="dropdown <?php echo($sales) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sales <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Customer</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>sales/add_cus.php?action=add">Add New Customer</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url?>sales/view_cus.php">View Customer Details</a></li>
                         	</ul><!-- end sub menu customer details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Sales Orders</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>sales/add-order.php">Add Sales Order</a></li>
                                <li class="divider"></li>
                        		<li><a href="<?php echo $base_url?>sales/view_order.php">View Sales Orders</a></li>
                         	</ul><!-- end sub menu sales orders details -->
                         </li><!-- end dropdown-submenu --> 
                        <li class="divider"></li>
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Sales Returns</a>
                        	<ul class="dropdown-menu">
                               <li><a href="<?php echo $base_url?>sales/sales_return.php?action=add">Add Sales Return</a></li>
                               <li class="divider"></li>
                       			 <li><a href="<?php echo $base_url?>sales/sales_return.php?">View Sales Return</a></li>
                         	</ul><!-- end sub menu sales return details -->
                         </li><!-- end dropdown-submenu --> 
                        <li class="divider"></li>
                      </ul><!-- end inner-menu of sales -->
                    </li><!-- end sales dropdown -->
                    <li class="dropdown <?php echo($inven) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Inventory <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Batches</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>inventory/add_batch.php?action=add">Add New Batch</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url?>inventory/view_batch.php">View Batch Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                         <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Products</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>inventory/product.php?action=add">Add New Product</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url?>inventory/view_product.php">View Product Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>inventory/categoryWindow.php">View Category Details</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>inventory/brandWindow.php">View Brand Details</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>inventory/view_current_stock.php">View Current Stock</a></li>
                      </ul><!-- end inner-menu of inventory -->
                    </li><!-- end inventory dropdown -->
                    <li class="dropdown <?php echo($purch) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Purchases <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Supplier</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>purchases/add_sup.php?action=add">Add New Supplier</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url?>purchases/view_sup.php">View Supplier Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>purchases/pur_return.php">View Purchases Return</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>purchases/credit_pur.php">View Credit Purchases</a></li>
                      </ul><!-- end inner-menu of purchases -->
                    </li><!-- end purchases dropdown -->
                    <li class="dropdown <?php echo($emp) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Employees <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                      	<li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Employee</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>employee/add_emp.php?action=add">Add New Employee</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url?>employee/view_emp.php">View Employee Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Job</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>employee/job.php?action=add">Add New Job</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url?>employee/job.php">View Job Details</a></li>
                        	</ul><!-- end sub menu employee details -->
                        </li><!-- end dropdown-submenu -->     
                      </ul><!-- end inner-menu of employees -->
                    </li><!-- end employees dropdown -->
                    <li class="dropdown <?php echo($exp) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Expenses <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo $base_url?>expense.php?action=add">Add Expence</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>expense.php">View Expence</a></li>
                      </ul><!-- end inner-menu of expenses -->
                    </li><!-- end expenses dropdown -->
                    <li class="dropdown <?php echo($rep) ?>">
                      <a href="<?php echo $base_url ?>reports/reports.php"role="button">Reports</a>
                    </li><!-- end reports dropdown -->
                    <li class="dropdown <?php echo($admin) ?>">
                      <a href="#" data-toggle="dropdown" role="button" aria-expanded="false">Administration <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                      	<li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Account</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>employee/my_account.php">My Account</a></li>
                                <li><a href="<?php echo $base_url?>employee/reset_acc.php">Reset Account</a></li>
 							</ul><!-- end submenu of Account -->
                        </li><!-- end dropdown-submenu -->   
                      </ul><!-- end inner-menu of administration -->
                   </li><!-- end administration dropdown -->
                    
                    <li><a href="<?php echo $base_url ?>emp_logout.php">Logout <span class="glyphicon glyphicon-lock"></span></a></li>
      </ul>
            </div><!-- end navi -->
        <!--</div><!-- end container -->
    </nav><!-- end navbar -->
 </div><!-- end navigation -->
 
 <div class="top2 alert alert-info" style="margin:0px;padding:0px">
 			<?php $sql="SELECT emp_fname,emp_lname FROM tbl_emp WHERE emp_id='$logempid';";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				$nor=mysqli_num_rows($res);
				if($nor>0){
					$row=mysqli_fetch_assoc($res);
				}
			?>
            <table class="col-md-12">
         	<td class="col-md-10"><span class="glyphicon glyphicon-user"></span> Welcome, <b><?php echo $row['emp_fname']." ".$row['emp_lname'] ?></b></td>
            <td class="col-md-2"><b> <span id="clock"></span></b></td>
            </table>
            
 </div><!-- end top2 -->
</div><!-- end container header -->
	<?php	
		elseif(isset($_SESSION['employee']) && $_SESSION['employee']['etype']=="J0003"):
				$logempid=$_SESSION['employee']['eid']; ?>
                <div class="navigation">    
   		 <nav class="navbar navbar-default">
    	<!--<div class="container">-->
        	<div class="navbar-header">
            	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navi">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div><!-- end navbar-header-->
            <!-- collection of navigations -->
            <div class="collapse navbar-collapse" id="navi">
            	<ul class="nav navbar-nav">
                    <li class="<?php echo($home) ?>"><a href="../admin_dashboard.php"><span class="glyphicon glyphicon-home"></span></a></li><!-- home -->
                    <li class="dropdown <?php echo($sales) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sales <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Customer</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>sales/add_cus.php?action=add">Add New Customer</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo $base_url?>sales/view_cus.php">View Customer Details</a></li>
                         	</ul><!-- end sub menu customer details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Sales Orders</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>sales/add-order.php">Add Sales Order</a></li>
                                <li class="divider"></li>
                        		<li><a href="<?php echo $base_url?>sales/view_order.php">View Sales Orders</a></li>
                         	</ul><!-- end sub menu sales orders details -->
                         </li><!-- end dropdown-submenu --> 
                        <li class="divider"></li>
                        <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Sales Returns</a>
                        	<ul class="dropdown-menu">
                               <li><a href="<?php echo $base_url?>sales/sales_return.php?action=add">Add Sales Return</a></li>
                               <li class="divider"></li>
                       			 <li><a href="<?php echo $base_url?>sales/sales_return.php?">View Sales Return</a></li>
                         	</ul><!-- end sub menu sales return details -->
                         </li><!-- end dropdown-submenu --> 
                        <li class="divider"></li>
                      </ul><!-- end inner-menu of sales -->
                    </li><!-- end sales dropdown -->
                    <li class="dropdown <?php echo($inven) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Inventory <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                         <li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Products</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>inventory/view_product.php">View Product Details</a></li>
                         	</ul><!-- end sub menu employee details -->
                         </li><!-- end dropdown-submenu -->          
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>inventory/view_current_stock.php">View Current Stock</a></li>
                      </ul><!-- end inner-menu of inventory -->
                    </li><!-- end inventory dropdown -->
                    <li class="dropdown <?php echo($exp) ?>">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Expenses <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo $base_url?>expense.php?action=add">Add Expence</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $base_url?>expense.php">View Expence</a></li>
                      </ul><!-- end inner-menu of expenses -->
                    </li><!-- end expenses dropdown -->
                    <li class="dropdown <?php echo($admin) ?>">
                      <a href="#" data-toggle="dropdown" role="button" aria-expanded="false">Administration <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                      	<li class="dropdown-submenu"><a href="#" data-toggle="dropdown">Account</a>
                        	<ul class="dropdown-menu">
                                <li><a href="<?php echo $base_url?>employee/my_account.php">My Account</a></li>
                                <li><a href="<?php echo $base_url?>employee/reset_acc.php">Reset Account</a></li>
 							</ul><!-- end submenu of Account -->
                        </li><!-- end dropdown-submenu -->   
                      </ul><!-- end inner-menu of administration -->
                   </li><!-- end administration dropdown -->
                    
                    <li><a href="<?php echo $base_url ?>emp_logout.php">Logout <span class="glyphicon glyphicon-lock"></span></a></li>
      </ul>
            </div><!-- end navi -->
        <!--</div><!-- end container -->
    </nav><!-- end navbar -->
 </div><!-- end navigation -->
 
 <div class="top2 alert alert-info" style="margin:0px;padding:0px">
 			<?php $sql="SELECT emp_fname,emp_lname FROM tbl_emp WHERE emp_id='$logempid';";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				$nor=mysqli_num_rows($res);
				if($nor>0){
					$row=mysqli_fetch_assoc($res);
				}
			?>
            <table class="col-md-12">
         	<td class="col-md-10"><span class="glyphicon glyphicon-user"></span> Welcome, <b><?php echo $row['emp_fname']." ".$row['emp_lname'] ?></b></td>
            <td class="col-md-2"><b> <span id="clock"></span></b></td>
            </table>
            
 </div><!-- end top2 -->
</div><!-- end container header -->
                
	<?php	
	endif;
	?>					

<script type="text/javascript">
//changing position of top bannar
var menu = $('.navigation'), pos = menu.offset();
$(document).ready(function() {
    $(window).scroll(function(){
	//console.log($(this).scrollTop());
    if($(this).scrollTop() > 156){    
         menu.addClass('navigationScrollUp'); 
    } 
	else {
        menu.removeClass('navigationScrollUp');
    }
 });
 
 	
});
</script>



