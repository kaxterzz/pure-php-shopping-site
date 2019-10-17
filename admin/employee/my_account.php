<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "My Account";
$c_page = 'administration';

//--------------------------------------------------------
$page_title='My Account Details';
$eid='';
$fname='';
$lname='';
$nic='';
$gen='';
$add='';
$tel='';
$email='';
$job='';
$frm_err_msg='';
		if(isset($_SESSION["employee"]["eid"])){
			$eid=$_SESSION["employee"]["eid"];
			$sql_all="SELECT * FROM tbl_emp WHERE emp_id='$eid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$fname=$row['emp_fname'];
			$lname=$row['emp_lname'];
			$nic=$row['emp_nic'];
			$gen=$row['emp_gen'];
			$add=$row['emp_add'];
			$tel=$row['emp_tel'];
			$email=$row['emp_email'];
			$job=$row['emp_job_id'];
			
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$eid=$_POST['txteid'];
				$fname=trim($_POST['txtfname']);
				$lname=trim($_POST['txtlname']);
				$nic=$_POST['txtnic'];
				$gen=$_POST['optgen'];
				$add=$_POST['txtadd'];
				$tel=$_POST['txttel'];
				$email=$_POST['txtemail'];
				//$job=$_POST['cmbjob'];
				$fname_pat='/[a-zA-Z]+/';
				$lname_pat="/[a-zA-Z]+/";
				$nic_pat="/^[0-9]{9}[\V|\X]{1}$/i";
				$tel_pat="/^[0]{1}[0-9]{9}$/";
				$email_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4}$/";
				if($fname=='' || !preg_match($fname_pat,$fname)){
					$frm_err_msg='Please enter a valid first name';
					$fname='';
				}
				elseif($lname=='' || !preg_match( $lname_pat,$lname)){
					$frm_err_msg='Please enter a valid last name';
					$lname='';
				}	
				elseif($nic==''|| !preg_match($nic_pat,$nic)){
						$frm_err_msg='Please enter your valid National Identification Card Number ';
						$nic='';
				}	
				elseif($add==''){
					$frm_err_msg='Please enter your address';
				}
				elseif($tel!='' && !preg_match( $tel_pat,$tel) ){
					$frm_err_msg='Please enter a valid telephone number';
					$tel='';
				}	
				/*elseif($email!='' && !preg_match($email_pat, $email)){
					
					$frm_err_msg='Please enter your valid email ';
					
				}*/		
				elseif($email!='' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
					$frm_err_msg='Please enter your valid email ';
					$email='';
				}
				/*elseif($job==''){
					$frm_err_msg='Please select your job title ';
					}*/
				else{
					$sql_update="UPDATE tbl_emp SET  
				emp_fname='$fname',emp_lname='$lname',emp_nic='$nic',emp_gen='$gen',emp_add='$add',emp_tel='$tel',		       			emp_email='$email' WHERE emp_id='$eid';";
					mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					header('Location:'.$base_url.'employee/my_account.php?&id='.$eid.'&s=1');
					}	// else close
		
			}//post close
		}	//get id close
?>


<?php include('../inc-head.php');?> <!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?> <!-- attach inc-header.php -->
	<div class="page-body container-fluid">
    	<div class="container inner">
        	<div class="page-title clearfix">
                <h1 class="pull-left"><?php echo $page_title ?></h1>    
    		</div><!-- end page-title -->
                	
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'employee/my_account.php'?>" name="frmemp" method="post">
                    
                    <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="bg-success">Record has been succesfuly saved</p>';
                        }
                        ?>
                    </div>
                    	<div class="frmdiv">
                		<table class="frm-tbl table table-responsive">
                        	<tr>
                            	<td><label for="txteid">Employee Id</label></td>
                                <td><input class="form-control" id="txteid" name="txteid" type="text" value="<?php echo $eid?>" readonly/></td>
                            </tr>
                        	<tr>
                            	<td><label for="txtfname">First Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control has-feedback" id="txtfname" name="txtfname" type="text" value="<?php echo $fname?>"/><div class="alert alert-danger errContainer"></div></td>
                               	<td><label for="txtlname">Last Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtlname" name="txtlname" type="text" value="<?php echo $lname?>"/><div class="errContainer"></div></td>
                            </tr>
                            <tr>
                            	<td><label for="txtnic">NIC<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtnic" name="txtnic" type="text" value="<?php echo $nic?>"/></td>
                            </tr>
							<tr>
                            	<td><label for="optgen">Gender<em style="color:#F00">*</em></label></td>
                                <td>
                                <input class="radio-inline" id="optgen" name="optgen" type="radio" value="1"<?php if($gen=='1'):?>
								 checked='checked' <?php endif?> checked/>Male
                                <input class="radio-inline" id="optgen" name="optgen" type="radio" value="0"<?php if($gen=='0'):?>
								 checked='checked'<?php endif?>/>Female
                                </td>
                            </tr>
                            <tr>
                            	<td><label for="txtadd">Address<em style="color:#F00">*</em></label></td>
                                <td><textarea class="form-control" id="txadd" name="txtadd" rows="3"><?php echo $add ?></textarea></td>
                            </tr>
                            <tr>
                            	<td><label for="txttel">Phone</label></td>
                                <td><input class="form-control" id="txttel" name="txttel" type="tel" value="<?php echo $tel?>"/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtemail">Email</label></td>
                                <td><input class="form-control" id="txtemail" name="txtemail" type="email" value="<?php echo $email?>"/></td>
                            </tr>
							<tr>
                            	<td><label for="cmbjob">Job Title</label></td>
                                <td><select class="form-control" id="cmbjob" name="cmbjob" disabled>
                                      <option value="">--Select--</option>
										 <?php $sql_opt="SELECT * FROM tbl_job;";
                                           $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
										   while($row=mysqli_fetch_assoc($result)){
											   $jobid=$row['job_id'];
											   $jobtitle=$row['job_title'];
											   $select='';
											   if($job==$jobid){
												   $select='selected="selected"';
											   }
                                         ?>
                                      <option value="<?php echo $jobid?>" <?php echo $select?>><?php echo $jobtitle ?></option>  
                                      <?php }//end while?>
                                    </select>
                                </td>
                              </tr>
                        </table>
                        </div><!-- end frmdiv -->
                        <table class="btns tbl-horizontal  col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit"/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </form>
                    
                   
        </div><!-- end inner -->
    </div><!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>
<script type="text/javascript">
function confirmUpdate(update_url) //submit button click data upadation confirmation
{
	var usereq=confirm("Are you sure you want to update the details?");
	if(usereq=='true'){
		window.location=update_url+'&s=1';
	}
	/*$.jAlert({
	type:'confirm',
	title:'Confirmation',
	theme:'yellow',
	confirmQuestion: 'Are you sure you want to Update the Details?',
	onConfirm:function(){
			window.location= update_url;
		}
	});*/
}
</script>