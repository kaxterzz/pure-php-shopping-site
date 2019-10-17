<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}

include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Employee Details";
$c_page = 'employees';


//--------------------------------------------------------
$page_action = '';
$page_title='View Employee Details';
$frm_err_msg='';

if(isset($_GET['action'])){
	$page_action=$_GET['action'];
	if($page_action=='delete' && isset($_GET['id'])){
		$eid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_emp WHERE emp_id='$eid'";
		mysqli_query($GLOBALS['conn'],$sql_delete) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		header('Location:'.$base_url.'employee/view_emp.php?id='.$eid.'&ds=1');
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
                <div class="page-top-action pull-right" style="display:none"><a class="btn btn-primary" href="<?php echo $base_url?>employee/add_emp.php?action=add">Add New Employee</a></div>  
                 <?php elseif($page_action == '' && $_SESSION["employee"]["etype"]=="J0002"): ?>
                 <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>employee/add_emp.php?action=add">Add New Employee</a></div> 
                 <?php endif;?> 
                 <?php if($page_action == ''): ?>
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
                        	<th>Emp Id</th>
                        	<th>Employee Name</th>
                            <th>NIC</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Job Title</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                        <?php $sql_select="SELECT * FROM tbl_emp INNER JOIN tbl_job ON tbl_emp.emp_job_id=tbl_job.job_id;";
							  $result=mysqli_query($GLOBALS['conn'],$sql_select) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							  while($row=mysqli_fetch_assoc($result)){
								  
						?>	<tr>
                        	<td><?php echo $eid=$row['emp_id'];?></td>
                        	<td><?php echo $fname=$row['emp_fname'];?> <?php echo $lname=$row['emp_lname'];?></td>
                            <td><?php echo $nic=$row['emp_nic'];?></td>
                            <td><?php $gen=$row['emp_gen'];
								if($gen=='1'){
									echo "Male";
									}
								elseif($gen=='0'){
									echo "Female";
									}	
							?></td>
                            <td><?php echo $add=$row['emp_add'];?></td>
                            <td><?php echo $tel=$row['emp_tel'];?></td>
                            <td><?php echo $email=$row['emp_email'];?></td>
                            <td><?php echo $job=$row['job_title'];?></td>
                            <td><?php $stat=$row['emp_stat'];
								if($stat=='1'){
									echo "Active";
									}
								elseif($stat=='0'){
									echo "Inactive";
									}
							?></td>
                            <td>
                        <a class="glyphicon glyphicon-pencil link-edit" 
                        href="<?php echo $base_url ?>employee/add_emp.php?action=edit&amp;id=<?php echo $eid ?>" 
                        title="Edit"></a>
                        	</td>
                            <td>
            			<a class="glyphicon glyphicon-remove link-delete" 
           				onclick="confirmDelete('<?php echo $base_url.'employee/view_emp.php?action=delete&amp;id='.$eid ?>');"
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