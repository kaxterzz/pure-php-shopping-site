<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Supplier Details";
$c_page = 'purchases';


//--------------------------------------------------------
$page_action = '';
$page_title='View supplier Details';
$frm_err_msg='';

if(isset($_GET['action'])){
	$page_action=$_GET['action'];
	if($page_action=='delete' && isset($_GET['id'])){
		$cusid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_supplier WHERE sup_id='$supid'";
		mysqli_query($GLOBALS['conn'],$sql_delete) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		header('Location:'.$base_url.'purchases/view_sup.php?id='.$supid.'&ds=1');
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
                <?php if($page_action == ''): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>purchases/add_sup.php?action=add">Add New Supplier</a></div>  
                 
    		</div><!-- end page-title -->
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
                        	<th>Sup Id</th>
                        	<th>First Name</th>
                            <th>Last Name</th>
                            <th>Company Name</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                        <?php $sql_select="SELECT * FROM tbl_supplier;";
							  $result=mysqli_query($GLOBALS['conn'],$sql_select) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							  while($row=mysqli_fetch_assoc($result)){
								  
						?>	<tr>
                        	<td><?php echo $cusid=$row['sup_id']?>;</td>
                        	<td><?php echo $fname=$row['sup_fname'];?></td>
                            <td><?php echo $lname=$row['sup_lname'];?></td>
                            <td><?php echo $company=$row['sup_comp'];?></td>
                            <td><?php $gen=$row['sup_gen'];
								if($gen=='1'){
									echo "M";
									}
								elseif($gen=='0'){
									echo "F";
									}	
							?></td>
                            <td><?php echo $add=$row['sup_add'];?></td>
                            <td><?php echo $tel=$row['sup_tel'];?></td>
                            <td><?php echo $email=$row['sup_email'];?></td>
                            <td><?php $stat=$row['sup_stat'];
                                        if($stat=='1'){
                                            echo "Active";
                                            }
                                        elseif($stat=='0'){
                                            echo "Inactive";
                                            }
                                    ?></td>
                            <td>
                        <a class="glyphicon glyphicon-pencil link-edit" 
                        href="<?php echo $base_url ?>purchases/add_sup.php?action=edit&amp;id=<?php echo $supid ?>" 
                        title="Edit"> Edit</a>
                        	</td>
                            <td>
            			<a class="glyphicon glyphicon-remove link-delete" 
           				onclick="confirmDelete('<?php echo $base_url.'purchases/view_sup.php?action=delete&amp;id='.$supid ?>');"
           				href="javascript:void(0);" title="Delete"> Delete</a>
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