<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Customer Details";
$c_page = 'sales';

//--------------------------------------------------------
$page_action = '';
$page_title='View Customer Details';
$frm_err_msg='';

if(isset($_GET['action'])){
	$page_action=$_GET['action'];
	if($page_action=='delete' && isset($_GET['id'])){
		$cusid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_customer WHERE cus_id='$cusid'";
		mysqli_query($conn,$sql_delete) or die("SQL Error:".mysqli_error());
		header('Location:'.$base_url.'sales/view_cus.php?id='.$cusid.'&ds=1');
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
                <div class="page-top-action pull-right" style="display:none"><a class="btn btn-primary" href="<?php echo $base_url?>sales/add_cus.php?action=add">Add New Customer</a></div>  
				<?php elseif($page_action == '' && ($_SESSION["employee"]["etype"]=="J0002" || $_SESSION["employee"]["etype"]=="J0003" )): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>sales/add_cus.php?action=add">Add New Customer</a></div>
				<?php endif;?>
    		</div><!-- end page-title -->
            <?php if($page_action == ''):?>
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
										 <?php $sql_opt="SELECT cus_id FROM tbl_customer;";
                                           $result=mysqli_query($conn,$sql_opt) or die("SQL error:".mysqli_error());
										   while($row=mysqli_fetch_assoc($result)){
											   $cid=$row['cus_id'];
											   $select='';
                                         ?>
                                      <option value="<?php echo $cid?>"><?php echo $cid ?></option>  
                                      <?php }//end while?>
                            </select>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoID">Go</button>-->
                    	</form>
                    </li><!-- byid -->
                     <li class="ByFname">
                    	<form class="navbar-form" role="search" id="ByFname">
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>First Name</label>
                            <div class="form-group">
                 	 		<input type="text" id="txtfname" name="txtfname" style="height:25px;border-radius:4px"/>
                		 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoDate">Go</button>-->
                    	</form>
                    </li><!-- byfname -->
                    <li class="ByLname">
                    	<form class="navbar-form" role="search" id="ByLname">
                    		<label style="color:#CCC"><span class="glyphicon glyphicon-search"></span>Last Name</label>
                            <div class="form-group">
                 	 		<input type="text" id="txtlname" name="txtlname" style="height:25px;border-radius:4px"/>
                			 </div>
                		<!--<button type="submit" class="btn btn-primary" id="btnGoLastN">Go</button>-->
                    	</form>
                    </li><!-- bylname-->
                    <li class="onlinecus"><a id="onlnCus" style="padding-top:8px"><b><span class="glyphicon glyphicon-search"></span>Online Customers</b></a></li>
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
                        	<th>Cus Id</th>
                        	<th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody id="viewRec">
                        <?php $sql_select="SELECT * FROM tbl_customer;";
							  $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error());
							  while($row=mysqli_fetch_assoc($result)){
								  
						?>	<tr>
                        	<td><?php echo $cusid=$row['cus_id'];?></td>
                        	<td><?php echo $fname=$row['cus_fname'];?></td>
                            <td><?php echo $lname=$row['cus_lname'];?></td>
                            <td><?php $gen=$row['cus_gen'];
								if($gen=='1'){
									echo "Male";
									}
								elseif($gen=='0'){
									echo "Female";
									}	
							?></td>
                            <td><?php echo $add=$row['cus_add'];?></td>
                            <td><?php echo $tel=$row['cus_tel'];?></td>
                            <td><?php echo $email=$row['cus_email'];?></td>
                            <td><?php $stat=$row['cus_stat'];
									if($stat=='1'){
										echo 'Active';
									}
									elseif($stat=='0'){
										echo "Deactive";
									}
							?></td>
                            <td>
                        <a class="glyphicon glyphicon-pencil link-edit" 
                        href="<?php echo $base_url ?>sales/add_cus.php?action=edit&amp;id=<?php echo $cusid ?>" 
                        title="Edit"></a>
                        	</td>
                            <td>
            			<a class="glyphicon glyphicon-remove link-delete" 
           				onclick="confirmDelete('<?php echo $base_url.'sales/view_cus.php?action=delete&amp;id='.$cusid ?>');"
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
		 $.post("../lib/searchBar.php?type=viewAllCus",
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		 //view all online customer records
		$("#onlnCus").click(function(){
		 $.post("../lib/searchBar.php?type=viewAllOnlnCus",
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		 //view by id
		$("#cmbid").change(function(){
		  var cid = $(this).val();
		  //alert(bid);
		  $.post("../lib/searchBar.php?type=searchCusid",{cid:cid},
		  function(data){
			$("#viewRec").html(data);
		  });			
		});
		
		//view by fname
		$("#txtfname").keyup(function(){
		  //var n="0";	
		  var fname = $(this).val();
		  //alert(n);
		  $.post("../lib/searchBar.php?type=searchByCusfname",{fname:fname},
		  function(data){
			$("#viewRec").html(data);
		  });		
		  	
		});
		
		//view by lname
		$("#txtlname").keyup(function(){
		  //var n="0";	
		  var lname = $(this).val();
		  //alert(n);
		  $.post("../lib/searchBar.php?type=searchByCuslname",{lname:lname},
		  function(data){
			$("#viewRec").html(data);
		  });		
		  	
		});
	  });

</script>