<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Product Details";
$c_page = 'inventory';


//--------------------------------------------------------
$page_action = '';
$page_title='View Product Details';
$frm_err_msg='';

if(isset($_GET['action'])){
	$page_action=$_GET['action'];
	if($page_action=='delete' && isset($_GET['id'])){
		$pid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_products WHERE prd_id='$pid'";
		mysqli_query($conn,$sql_delete) or die("SQL Error:".mysqli_error());
		header('Location:'.$base_url.'inventory/view_product.php?id='.$pid.'&ds=1');
		}
	}
?>
<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?> <!-- attach inc-header.php -->
<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php echo $page_title ?></h1>
                <?php if($page_action == '' && $_SESSION["employee"]["etype"]=="J0001" && $_SESSION["employee"]["etype"]=="J0003"): ?>
                <div class="page-top-action pull-right" style="display:none"><a class="btn btn-primary" href="<?php echo $base_url?>inventory/product.php?action=add">Add New Product</a></div>  
                <?php elseif($page_action == '' && ($_SESSION["employee"]["etype"]=="J0002")): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>inventory/product.php?action=add">Add New Product</a></div> 
                <?php endif;?>
                <?php if($page_action == ''): ?>
    		</div><!-- end page-title -->
            <div class="navigation"  style="margin-bottom:5px">  <!-- viewing options --> 
   		 <nav class="navbar navbar-default">
    	<!--<div class="container">-->
        	<div class="navbar-header">
            	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navi">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a href="" class="navbar-brand"><img src="images/logo.jpg" class="img-responsive"/></a>-->
            </div><!-- end navbar-header-->
            <!-- collection of navigations -->
            <div class="collapse navbar-collapse" id="navi">
            	<ul class="nav navbar-nav">
                    <li class="ByPid">
                    	<form class="navbar-form" role="search" id="ByPid" >
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>Product ID</label>
                            <div class="form-group">
                 	 		<select id="cmbpid" name="cmbpid" style="height:25px;border-radius:4px">
                            	<option value="">--Select--</option>
										 <?php $sql_opt="SELECT prd_id FROM tbl_products WHERE prd_stat='1';";
                                           $result=mysqli_query($conn,$sql_opt) or die("SQL error:".mysqli_error());
										   while($row=mysqli_fetch_assoc($result)){
											   $pid=$row['prd_id'];
											   $select='';
                                         ?>
                                      <option value="<?php echo $pid?>"><?php echo $pid ?></option>  
                                      <?php }//end while?>
                            </select>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoID">Go</button>-->
                    	</form>
                    </li><!-- bypid -->
                     <li class="ByprdName">
                    	<form class="navbar-form" role="search" id="ByprdName">
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>Product Name</label>
                            <div class="form-group">
                 	 		<input type="text" id="txtprdname" name="txtprdname" style="height:25px;border-radius:4px"/>
                			 </div>
                    	</form>
                    </li><!-- bylastnrec -->
                    <li class="ByCat">
                    	<form class="navbar-form" role="search" id="ByCat" >
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>Category</label>
                            <div class="form-group">
                 	 		<select id="cmbcat" name="cmbcat" style="height:25px;border-radius:4px">
                            	<option value="">--Select--</option>
										 <?php $sql_opt="SELECT cat_id,cat_name FROM tbl_category WHERE cat_stat='1';";
                                           $result=mysqli_query($conn,$sql_opt) or die("SQL error:".mysqli_error());
										   while($row=mysqli_fetch_assoc($result)){
											   $cid=$row['cat_id'];
											   $cat=$row['cat_name'];
											   $select='';
                                         ?>
                                      <option value="<?php echo $cid?>"><?php echo $cat ?></option>  
                                      <?php }//end while?>
                            </select>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoID">Go</button>-->
                    	</form>
                    </li><!-- bycat -->
                    <li class="ByBrand">
                    	<form class="navbar-form" role="search" id="ByBrand" >
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>Brand</label>
                            <div class="form-group">
                 	 		<select id="cmbbrand" name="cmbbrand" style="height:25px;border-radius:4px">
                            	<option value="">--Select--</option>
										 <?php $sql_opt="SELECT brand_id,brand_name FROM tbl_brand WHERE brand_stat='1';";
                                           $result=mysqli_query($conn,$sql_opt) or die("SQL error:".mysqli_error());
										   while($row=mysqli_fetch_assoc($result)){
											   $brid=$row['brand_id'];
											   $brand=$row['brand_name'];
											   $select='';
                                         ?>
                                      <option value="<?php echo $brid?>"><?php echo $brand ?></option>  
                                      <?php }//end while?>
                            </select>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoID">Go</button>-->
                    	</form>
                    </li><!-- bycat -->
                   
                    <li class="all"><a id="viewAll" style="padding-top:8px"><b><span class="glyphicon glyphicon-search"></span>View All</b></a></li>
                </ul>
            </div><!--end navi -->
         </nav>
         </div><!-- end navigation search-->  

             <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == "1"){
                            echo '<p class="bg-success">Record has been succesfully saved</p>';
                        }
						elseif(isset($_GET['ds']) && $_GET['ds'] == '1'){
                            echo '<p class="bg-warning">Record has been succesfully deleted</p>';
                        }
                        ?>
                    </div>
                    <div class="frmdiv">
                    <table class="frm-tbl table table-responsive">
                        <thead>
                        	<th>Product Id</th>
                        	<th>Product Name</th>
                            <th>Category Name</th>
                            <th>Brand Name</th>
                            <th>Product Image</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                        </thead>
                        <tbody id="viewRec">
                        <?php $sql_select="SELECT P.prd_id,P.prd_name,P.cat_id,C.cat_name,B.brand_name,P.prd_img_path,P.prd_reorder_lvl,P.prd_stat FROM tbl_category C JOIN tbl_products P ON C.cat_id=P.cat_id JOIN tbl_brand B ON P.brand_id=B.brand_id WHERE P.prd_stat=1;";
							  $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error());
							  while($row=mysqli_fetch_assoc($result)){
								  
						?>	<tr>
                        	<td><?php echo $pid=$row['prd_id'];?></td>
                        	<td><?php echo $pname=$row['prd_name'];?></td>
                            <td><?php echo $cname=$row['cat_name'];?></td>
                            <td><?php echo $bname=$row['brand_name'];?></td>
                           <?php $img=$row['prd_img_path'];
						   		 $cid=$row['cat_id'];	
						   ?>
                            <td><img class="img-responsive" src="<?php echo $base_url.'images/products/'.$img?>" width="120px"
                             height="100px"/></td>
                             <td><?php echo $reordrlvl=$row['prd_reorder_lvl']; ?></td>
                            <td><?php $stat=$row['prd_stat'];
								if($stat=='1'){
									echo "Active";
									}
								elseif($stat=='0'){
									echo "Inactive";
									}
							?></td>
                            <td>
                        <a class="glyphicon glyphicon-pencil link-edit" 
                        href="<?php echo $base_url ?>inventory/edit_product.php?id=<?php echo $pid ?>" 
                        title="Edit"></a>
                        	</td>
                            <td>
            			<a class="glyphicon glyphicon-remove link-delete" 
           				onclick="confirmDelete('<?php echo $base_url.'inventory/view_product.php?action=delete&amp;id='.$pid ?>');"
           				href="javascript:void(0);" title="Delete"></a>
                        	</td>
                            </tr>
                            <?php }// close while loop ?>
                        </tbody>
                    </table>    
                    </div><!-- end frmdiv -->
            	<?php endif; ?>
        </div><!-- end container inner -->
</div><!-- end page body container fluid -->            
<?php include('../inc-footer.php'); ?>
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){
		  //view all records
		$("#viewAll").click(function(){
		 $.post("../lib/searchBar.php?type=viewAllProducts",
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		$("#cmbpid").change(function(){
		  var pid = $(this).val();
		  //alert(bid);
		  $.post("../lib/searchBar.php?type=searchPrdid",{pid:pid},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		$("#cmbcat").change(function(){
		  var cat = $(this).val();
		  //alert(bid);
		  $.post("../lib/searchBar.php?type=searchCat",{cat:cat},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		$("#cmbbrand").change(function(){
		  var brand = $(this).val();
		  //alert(bid);
		  $.post("../lib/searchBar.php?type=searchBrand",{brand:brand},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		//view by emp name
		$("#txtprdname").keyup(function(){
		  //var n="0";	
		  var prdname = $(this).val();
		  //alert(n);
		  $.post("../lib/searchBar.php?type=searchPrdName",{prdname:prdname},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
	  });
</script>