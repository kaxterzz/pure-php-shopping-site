<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Sales Order Details";
$c_page = 'sales';
//--------------------------------------------------------
$page_action = '';
$page_title='View Sales Orders';
$frm_err_msg='';

?>
<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?> <!-- attach inc-header.php -->
<div class="modal fade" id="ModelWindow">
	<div class="loadExt3"></div>
</div><!-- /.modal prd Details of sales orders -->
<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php echo $page_title ?></h1>
                <?php if($page_action == '' && $_SESSION["employee"]["etype"]=="J0001"): ?>
                <div class="page-top-action pull-right" style="display:none"><a class="btn btn-primary" href="<?php echo $base_url?>sales/add-order.php">Add New Order</a></div> 
                <?php elseif($page_action == '' && ($_SESSION["employee"]["etype"]=="J0002" || $_SESSION["employee"]["etype"]=="J0003" )): ?> 
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>sales/add-order.php">Add New Order</a></div> <?php endif;?>
    		</div><!-- end page-title -->
             <?php if($page_action == ''): ?>
            <div class="navigation"  style="margin-bottom:5px">  <!-- viewing options --> 
   		 <nav class="navbar navbar-default">
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
										 <?php $sql_opt="SELECT inv_id FROM tbl_invoice;";
                                           $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
										   while($row=mysqli_fetch_assoc($result)){
											   $invid=$row['inv_id'];
											   $select='';
                                         ?>
                                      <option value="<?php echo $invid?>"><?php echo $invid ?></option>  
                                      <?php }//end while?>
                            </select>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoID">Go</button>-->
                    	</form>
                    </li><!-- byid -->
                     <li class="ByFname">
                    	<form class="navbar-form" role="search" id="ByFname">
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>Customer First Name</label>
                            <div class="form-group">
                 	 		<input type="text" id="txtfname" name="txtfname" style="height:25px;border-radius:4px"/>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoDate">Go</button>-->
                    	</form>
                    </li><!-- byfname -->
                    
                    <li class="ByDate">
                    	<form class="navbar-form" role="search" id="ByDate">
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>Date</label>
                            <div class="form-group">
                 	 		<input type="date" id="dtpdate" name="datpdate" style="height:25px;border-radius:4px"/>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoDate">Go</button>-->
                    	</form>
                    </li><!-- bydate -->
                    <li class="online"><a id="onlineInv" style="padding-top:8px"><b><span class="glyphicon glyphicon-search"></span>Online</b></a></li>
                    <li class="all"><a id="viewAll" style="padding-top:8px"><b><span class="glyphicon glyphicon-search"></span>View All</b></a></li>
                </ul>
            </div><!--end navi -->
         </nav>
         </div><!-- end navigation search-->

             <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="alert alert-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == "1"){
                            echo '<p class="alert alert-success">Record has been succesfully saved</p>';
                        }
						elseif(isset($_GET['ds']) && $_GET['ds'] == '1'){
                            echo '<p class="alert alert-warning">Record has been succesfully deleted</p>';
                        }
                        ?>
                    </div>
                    <div class="frmdiv">
                    <table class="frm-tbl table table-responsive">
                        <thead>
                        	<th>Invoice ID</th>
                        	<th>Customer Name </th>
                            <th>Invoice Date</th>
                            <th>Gross Total</th>
                            <th>Discount</th>
                            <th>Net Total</th>
                            <th>Employee ID</th>
                            <th></th>
                        </thead>
                        <tbody id="viewRec">
                        <?php $sql_select="SELECT I.inv_id,C.cus_fname,C.cus_lname,I.inv_date,I.inv_gtot,I.inv_disc,I.inv_ntot,I.inv_emp_id FROM tbl_invoice I JOIN tbl_customer C ON I.inv_cus_id=C.cus_id;";
							  $result=mysqli_query($GLOBALS['conn'],$sql_select) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							  while($row=mysqli_fetch_assoc($result)){
								  
						?>	<tr>
                        	<td><?php echo $invid=$row['inv_id'];?></td>
                        	<td><?php echo $row['cus_fname'];?> <?php echo $row['cus_lname'];?></td>
                            <td><?php echo $date=$row['inv_date'];?></td>
                            <td><?php echo $tot=$row['inv_gtot'];?></td>
                            <td><?php echo $tot=$row['inv_disc'];?></td>
                            <td><?php echo $tot=$row['inv_ntot'];?></td>
                            <td><?php echo $emp=$row['inv_emp_id'];?></td>
                            
                            <td>
                        <a class="btnLoadOrderPrdData" role="button" id="btnviewprdorder" name="btnviewprdorder" data-type="view" data-id="<?php echo $invid ?>" type="button" data-toggle="modal" data-target="#ModelWindow"><span class="glyphicon glyphicon-eye-open"></span> View Details</a>
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
		 $.post("../lib/searchBar.php?type=viewAllInv",
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		//view all online invoice records
		$("#onlineInv").click(function(){
		 $.post("../lib/searchBar.php?type=viewAllOnlnInv",
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		$("#cmbid").change(function(){
		  var invid = $(this).val();
		  //alert(bid);
		  $.post("../lib/searchBar.php?type=searchInvid",{invid:invid},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		//view by job
		$("#dtpdate").change(function(){
		  var date = $(this).val();
		  //alert(date);
		  $.post("../lib/searchBar.php?type=searchInvDate",{date:date},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		//view by fname
		$("#txtfname").keyup(function(){
		  //var n="0";	
		  var fname = $(this).val();
		  //alert(n);
		  $.post("../lib/searchBar.php?type=searchByInvCusfname",{fname:fname},
		  function(data){
			$("#viewRec").html(data);
		  });		
		  	
		});
});
</script>