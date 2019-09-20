<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}

include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Job Details";
$c_page = 'employees';


//--------------------------------------------------------
$page_action = '';
$page_title='View Job Details';
$jid='';
$job='';
$stat='';
$frm_err_msg='';
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	if($page_action=='add'){
		$jid=getJobId();
		$page_title='Add New Job';
		if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
			$jid=$_POST['txtjid'];
			$job=$_POST['txtjob'];
			$stat=$_POST['optstat'];
			$job_pat='/[a-zA-Z]+/';
			if($job==''|| !preg_match($job_pat,$job)){
				$frm_err_msg='Please enter a valid Job title';
				}
			else{
				
				$sql_insert="INSERT INTO tbl_job(job_id,job_title,job_stat) VALUES('$jid','$job','$stat');";
				mysqli_query($GLOBALS['conn'],$sql_insert) or die("Mysql error".mysqli_error($GLOBALS['conn']));
				header('Location:'.$base_url.'employee/job.php?action=add&id='.$jid.'&s=1');
				mysqli_close($con);
				}	//else close
			
			}//post close
		}//add close
	elseif($page_action=='edit'){
		$page_title='Edit Job Details';
		if(isset($_GET['id'])){
			$jid=$_GET['id'];
			$sql_all="SELECT * FROM tbl_job WHERE job_id='$jid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$job=$row['job_title'];
			$stat=$row['job_stat'];
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$job=$_POST['txtjob'];
				$stat=$_POST['optstat'];
				$job_pat='/[a-zA-Z]+/';
				
				if($job==''|| !preg_match($job_pat,$job)){
					$frm_err_msg='Please enter a valid Job Title';
					}
				else{
					$sql_update="UPDATE tbl_job SET job_title='$job',job_stat='$stat' WHERE job_id='$jid';";
					mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					header('Location:'.$base_url.'employee/job.php?&id='.$eid.'&s=1');
					}	// else close
		
			}//post close
		}	//get id close
}// edit close
elseif($page_action == ''){
		$page_title='View Job Details';
}
elseif($page_action == 'delete' && isset($_GET['id'])){
		$jid=$_GET['id'];
		$sql_delete="DELETE FROM tbl_job WHERE job_id='$jid'";
		mysqli_query($GLOBALS['conn'],$sql_delete) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
		header('Location:'.$base_url.'employee/job.php?id='.$jid.'&ds=1');
		}

}// end action
?>


<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?> <!-- attach inc-header.php -->
	<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php echo $page_title ?></h1>
                <?php if($page_action == 'add' || $page_action == 'edit'): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>employee/job.php">View Job Details</a></div>
                <?php elseif($page_action == ''): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>employee/job.php?action=add">Add New Job</a></div>
                <?php endif;?>
    		</div><!-- end page-title -->
					 <?php if($page_action==''):?>
                     <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                     		if(isset($_GET['ds']) && $_GET['ds'] == '1'){
                            echo '<p class="bg-warning">Record has been succesfully deleted</p>';
                        }
						  	elseif(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="bg-success">Record has been succesfuly saved</p>';
                        }
						
                        ?>
                     </div>
						
                    	<div class="frmdiv col-md-6">
                            <table class="frm-tbl table table-striped table-responsive">
                                <thead>
                                	<th>Job ID</th>
                                    <th>Job Title</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                <?php $sql_select="SELECT * FROM tbl_job;";
                                      $result=mysqli_query($GLOBALS['conn'],$sql_select) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
                                      while($row=mysqli_fetch_assoc($result)){
                                          
                                ?>	<tr>
                                	<td><?php echo $jid=$row['job_id'];?></td>
                                    <td><?php echo $job=$row['job_title'];?></td>
                                    <td><?php $stat=$row['job_stat'];
                                        if($stat=='1'){
                                            echo "Active";
                                            }
                                        elseif($stat=='0'){
                                            echo "Inactive";
                                            }
                                    ?></td>
                                    <td>
                                <a class="glyphicon glyphicon-pencil link-edit" 
                                href="<?php echo $base_url ?>employee/job.php?action=edit&amp;id=<?php echo $jid ?>" 
                                title="Edit"> Edit</a>
                                    </td>
                                    <td>
                                <a class="glyphicon glyphicon-remove link-delete" 
                                onclick="confirmDelete('<?php echo $base_url.'employee/job.php?action=delete&amp;id='.$jid ?>');"
                                href="javascript:void(0);" title="Delete"> Delete</a>
                                    </td>
                                    </tr>
                                    <?php }// close while loop ?>
                                </tbody>
                            </table>    
                    </div><!-- end frmdiv -->
                    <?php elseif($page_action == 'add' || $page_action=='edit'):?>
           			<?php if($page_action == 'add'):?>	
                	<form class="frm form-horizontal" action="<?php echo $base_url.'employee/job.php?action=add'?>" name="frmjob" method="post">
                	<?php elseif($page_action=='edit'):?>
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'employee/job.php?action=edit&id='.$_GET['id']?>" name="frmjob" method="post">
         			<?php endif?>
                    <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="bg-success">Record has been succesfuly saved</p>';
                        }
						
                        ?>
                    </div>
                    	<div class="frmdiv col-md-6">
                		<table class="frm-tbl table table-responsive">
                         <tr>
                            	<td><label for="txtjid">Job ID</label></td>
                                <td><input class="form-control" id="txtjid" name="txtjid" type="text" value="<?php echo $jid?>"/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtjob">Job Title<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtjob" name="txtjob" type="text" value="<?php echo $job?>"/></td>
                            </tr>
							<tr>
                                <td><label for="optstat">Status<em style="color:#F00">*</em></label></td>
                                <td><input class="radio-inline" id="optstat" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>Active
                                <input class="radio-inline" id="optstat" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>Inactive
                                </td>
                            </tr>
                        </table>
                        </div><!-- end frmdiv -->
                        <table class=" btns tbl-horizontal col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit"/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </form>
                    <?php endif?><!-- if($page_action ==): -->
        </div><!-- end inner -->
    </div><!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>