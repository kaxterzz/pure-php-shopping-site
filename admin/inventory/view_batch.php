<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
require('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Stock Details";
$c_page = 'inventory';
//--------------------------------------------------------
$page_action = '';
$page_title='View Batch Details';
$batchqnty='';
$prd='';
$frm_err_msg='';

if(isset($_GET['action'])){
	$page_action=$_GET['action'];
	if($page_action=='delete' && isset($_GET['id'])){
		$batchid=$_GET['id'];
		$sql="SELECT batch_qnty,prd_id FROM tbl_batch WHERE batch_id='$batchid';";
		$res=mysqli_query($conn,$sql) or die("SQL Error:".mysqli_error());
		$row=mysqli_fetch_assoc($res);
		$batchqnty=$row['batch_qnty'];
		$prd=$row['prd_id'];
		$sql_delete="DELETE FROM tbl_batch WHERE batch_id='$batchid';";
		$res1=mysqli_query($conn,$sql_delete) or die("SQL Error:".mysqli_error());
		$sql2="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty-'$batchqnty' WHERE prd_id='$prd'";
		$res2=mysqli_query($conn,$sql2) or die("Mysql error".mysqli_error());
				
		if($res1>0 && $res2>0)
		header('Location:'.$base_url.'inventory/view_batch.php?id='.$batchid.'&ds=1');
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
                <?php if($page_action == '' && $_SESSION["employee"]["etype"]=="J0001"): ?>
                <div class="page-top-action pull-right" style="display:none"><a class="btn btn-primary" href="<?php echo $base_url?>inventory/add_batch.php?action=add">Add New Batch</a></div>  
                 <?php elseif($page_action == '' && ($_SESSION["employee"]["etype"]=="J0002" || $_SESSION["employee"]["etype"]=="J0003" )): ?>
                 <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>inventory/add_batch.php?action=add">Add New Batch</a></div> 
                 <?php endif;?>
    		</div><!-- end page-title -->
             <?php if($page_action == ''): ?>
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
                    <li class="ById">
						<form class="navbar-form" role="search" id="ById" >
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>ID</label>
                            <div class="form-group">
                 	 		<select id="cmbid" name="cmbid" style="height:25px;border-radius:4px">
                            	<option value="">--Select ID--</option>
										 <?php $sql_opt="SELECT * FROM tbl_batch;";
                                           $result=mysqli_query($conn,$sql_opt) or die("SQL error:".mysqli_error());
										   while($row=mysqli_fetch_assoc($result)){
											   $bid=$row['batch_id'];
											   $select='';
                                         ?>
                                      <option value="<?php echo $bid?>"><?php echo $bid ?></option>  
                                      <?php }//end while?>
                            </select>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoID">Go</button>-->
                    	</form>
                    </li><!-- byid -->
                     <li class="ByDate">
                    	<form class="navbar-form" role="search" id="ByDate">
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>Date</label>
                            <div class="form-group">
                 	 		<input type="date" id="dtpdate" name="datpdate" style="height:25px;border-radius:4px"/>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoDate">Go</button>-->
                    	</form>
                    </li><!-- bydate -->
                    <li class="ByLastNRec">
                    	<form class="navbar-form" role="search" id="ByLastNRec">
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>View Last</label>
                            <div class="form-group">
                 	 		<input type="text" id="txtlastn" name="txtlastn" style="height:25px;border-radius:4px"/>
                			 </div>
                             <label style="color:#CCC">Records</label>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoLastN">Go</button>-->
                    	</form>
                    </li><!-- bylastnrec -->
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
                        	<th class="col-md-1">Batch Id</th>
                        	<th class="col-md-2">Product Name</th>
                            <th class="col-md-2">Date added</th>
                            <th class="col-md-1">Quantity</th>
                            <th class="col-md-1">Cost Price</th>
                            <th class="col-md-1">Sell Price</th>
                            <th class="col-md-2">Supplier</th>
                            <th class="col-md-1">Status</th>
                            <th class="col-md-1"></th>
                            
                        </thead>
                        <tbody id="viewRec">
                        <?php 
							$sql_select="SELECT B.batch_id,P.prd_name,B.batch_date,B.batch_qnty,B.batch_prd_cost_price,B.batch_prd_sell_price,S.sup_comp,B.batch_stat FROM tbl_batch B JOIN tbl_products P ON B.prd_id=P.prd_id JOIN tbl_supplier S ON B.sup_id=S.sup_id WHERE B.batch_stat=1;";
		 					$result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error());
							while($row=mysqli_fetch_assoc($result)){ 
                            $status=$row['batch_stat'];
						if($status=='1'){
							$stat='Enable';
						}
						elseif($status=='0'){
							$stat="Disable";
						}	?>		  
                        <tr>
                            <td><?php echo $bid=$row['batch_id'] ?></td>
                            <td><?php echo $row['prd_name'] ?></td>
                            <td><?php echo $row['batch_date'] ?></td>
                            <td><?php echo $row['batch_qnty'] ?></td>
                            <td><?php echo $row['batch_prd_cost_price'] ?></td>
                            <td><?php echo $row['batch_prd_sell_price'] ?></td>
                            <td><?php echo $row['sup_comp'] ?></td>
                        	<td><?php echo $stat ?></td>
                        	<td>
                        		<a class="glyphicon glyphicon-pencil link-edit" href="<?php echo $base_url ?>inventory/add_batch.php?action=edit&amp;id=<?php echo $bid ?>" title="Edit"></a>
                            </td>
                            <td>    
                        		<a class="glyphicon glyphicon-remove link-delete" onClick="confirmDelete('<?php echo $base_url.'inventory/view_batch.php?action=delete&amp;id='.$bid ?>');" href="javascript:void(0);" title="Delete"></a>
                        	</td>
                        </tr>
         				<?php }?>	
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
		 $.post("../lib/searchBar.php?type=viewAllBatch",
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		$("#cmbid").change(function(){
		  var bid = $(this).val();
		  //alert(bid);
		  $.post("../lib/searchBar.php?type=searchBatchid",{bid:bid},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		//view by job
		$("#dtpdate").change(function(){
		  var date = $(this).val();
		  //alert(date);
		  $.post("../lib/searchBar.php?type=searchBatchDate",{date:date},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		//view by emp name
		$("#txtlastn").keyup(function(){
		  //var n="0";	
		  var n = $(this).val();
		  //alert(n);
		  $.post("../lib/searchBar.php?type=searchBatchN",{n:n},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		
		
	  });
</script>