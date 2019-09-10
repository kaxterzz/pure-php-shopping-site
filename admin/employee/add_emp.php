<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Employee Details";
$c_page = 'employees';

//--------------------------------------------------------
$page_action = '';
$page_title='';
$eid='';
$fname='';
$lname='';
$nic='';
$gen='';
$add='';
$tel='';
$email='';
$job='';
$stat='';
$uname='';
$pass='';
$repass='';
$frm_err_msg='';
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	if($page_action=='add'){
		$page_title='Add New Employee';
		$eid=getEmpId();
		if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
			$eid=$_POST['txteid'];
			$fname=trim($_POST['txtfname']);
			$lname=trim($_POST['txtlname']);
			$nic=$_POST['txtnic'];
			$gen=$_POST['optgen'];
			$add=$_POST['txtadd'];
			$tel=$_POST['txttel'];
			$email=$_POST['txtemail'];
			$job=$_POST['cmbjob'];
			$stat=$_POST['optstat'];
			$uname=$_POST['txtuname'];
			$pass=$_POST['txtpass'];
			$repass=$_POST['txtrepass'];
			$fname_pat='/^[a-zA-Z ]*$/';
			$lname_pat="/^[a-zA-Z ]*$/";
			$nic_pat="/^[0-9]{9}[\V|\X]{1}$/i";
			$tel_pat="/^[0]{1}[1-9]{2}[0-9]{7}$/";
			$email_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4}$/";
			$pass_pat="/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/";
			$repass_pat="/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/";
			$epass=md5($pass);
			$erepass=md5($repass);
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
			elseif($job==''){
				$frm_err_msg='Please select your job title ';
				}
			elseif($uname=='' || ($uname!=$fname && $uname!=$email )){
				$frm_err_msg='Please enter your valid User Name ';
				$uname='';
			}	
			elseif($pass=='' || !preg_match($pass_pat, $pass) ){
				$frm_err_msg='Please enter a valid Password ';
				$pass='';
				$repass='';
			}	
			elseif($repass=='' || !preg_match($repass_pat, $repass) ){
				$frm_err_msg='Please retype the valid Password ';
				$repass='';
			}
			elseif(strlen($pass)<8 && strlen($repass)<8){
				$frm_err_msg='Please Enter a password of atleast 8 characters ';
				$pass='';
				$repass='';
			}
			elseif($epass!=$erepass){
				$frm_err_msg='Please retype the valid password';
				$repass='';
			}
			else{
				$sql_insert="INSERT INTO 		        tbl_emp(emp_id,emp_fname,emp_lname,emp_nic,emp_gen,emp_add,emp_tel,emp_email,emp_job_id,emp_uname,emp_pass,emp_stat)     VALUES('$eid','$fname','$lname','$nic','$gen','$add','$tel','$email','$job','$uname','$epass','$stat');";
				mysqli_query($conn,$sql_insert) or die("Mysql error".mysqli_error());
				$from ="binnytraders@gmail.com";
				$header = "From : ".$from;
				$header .= "MIME-Version: 1.0\n";
				$header .= "Content-type: text/html; charset=iso-8859-1\n";
				$to ='newuser@localhost';
				$subject ='New Employee Added';
				$message ='Dear Sir,<br/><center><b style="color:#9900ff">New Employee Added</b></center>
			<br/><b>Emp ID:</b> '.$eid.'<br/><b>Employee Name:</b> '.$fname.' '.$lname.'<br/><b>Job:</b> '.$job.'<br/><br/>Thank you';
			$message = wordwrap($message, 70);	  
			// send mail
				if(mail($to,$subject,$message,$header))
				header('Location:'.$base_url.'employee/add_emp.php?action=add&id='.$eid.'&s=1');
				}	//else close
			
			}//post close
		}//add close
	elseif($page_action=='edit'){
		$page_title='Edit Employee Details';
		if(isset($_GET['id'])){
			$eid=$_GET['id'];
			$sql_all="SELECT * FROM tbl_emp WHERE emp_id='$eid';";
			$result=mysqli_query($conn,$sql_all) or die("MYSQL Error:".mysqli_error());
			$row=mysqli_fetch_assoc($result);
			$fname=$row['emp_fname'];
			$lname=$row['emp_lname'];
			$nic=$row['emp_nic'];
			$gen=$row['emp_gen'];
			$add=$row['emp_add'];
			$tel=$row['emp_tel'];
			$email=$row['emp_email'];
			$job=$row['emp_job_id'];
			$stat=$row['emp_stat'];
			
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$eid=$_POST['txteid'];
				$fname=trim($_POST['txtfname']);
				$lname=trim($_POST['txtlname']);
				$nic=$_POST['txtnic'];
				$gen=$_POST['optgen'];
				$add=$_POST['txtadd'];
				$tel=$_POST['txttel'];
				$email=$_POST['txtemail'];
				$job=$_POST['cmbjob'];
				$stat=$_POST['optstat'];
				$fname_pat='/[a-zA-Z]+/';
				$lname_pat="/[a-zA-Z]+/";
				$nic_pat="/^[0-9]{9}[\V|\X]{1}$/i";
				$tel_pat="/^[0]{1}[1-9]{2}[0-9]{7}$/";
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
				elseif($job==''){
					$frm_err_msg='Please select your job title ';
					}
				else{
					$sql_update="UPDATE tbl_emp SET  
				emp_fname='$fname',emp_lname='$lname',emp_nic='$nic',emp_gen='$gen',emp_add='$add',emp_tel='$tel',		       			emp_email='$email',emp_job_id='$job',emp_stat='$stat' WHERE emp_id='$eid';";
					mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
					header('Location:'.$base_url.'employee/view_emp.php?&id='.$eid.'&s=1');
					}	// else close
		
			}//post close
		}	//get id close
}// edit close
else{
		header('Lacation:'.$base_url.'employee/view_emp.php');
	}
}// end action
else{
		$page_title='View Employee Details';
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
                <?php if($page_action == 'add' || $page_action == 'edit'): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>employee/view_emp.php">View Employee Details</a></div>
                
    		</div><!-- end page-title -->
					
           			<?php if($page_action == 'add'):?>	
                	<form class="frm form-horizontal" action="<?php echo $base_url.'employee/add_emp.php?action=add'?>" name="frmemp" method="post">
                	<?php elseif($page_action=='edit'):?>
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'employee/add_emp.php?action=edit&id='.$_GET['id']?>" name="frmemp" method="post">
                    <?php endif;?>	
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
                                <td><input class="form-control" id="txteid" name="txteid" type="text" value="<?php echo $eid?>" readonly /></td>
                            </tr>
                        	<tr>
                            	<td><label for="txtfname">First Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control has-feedback" id="txtfname" name="txtfname" type="text" value="<?php echo $fname?>" autofocus/><div class="alert alert-danger errContainer"></div></td>
                               	<td><label for="txtlname">Last Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtlname" name="txtlname" type="text" value="<?php echo $lname?>" autofocus/><div class="errContainer"></div></td>
                            </tr>
                            <tr>
                            	<td><label for="txtnic">NIC<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtnic" name="txtnic" type="text" value="<?php echo $nic?>" autofocus/></td>
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
                                <td><textarea class="form-control" id="txadd" name="txtadd" rows="3" autofocus><?php echo $add ?></textarea></td>
                            </tr>
                            <tr>
                            	<td><label for="txttel">Phone</label></td>
                                <td><input class="form-control" id="txttel" name="txttel" type="tel" value="<?php echo $tel?>" autofocus/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtemail">Email</label></td>
                                <td><input class="form-control" id="txtemail" name="txtemail" type="email" value="<?php echo $email?>" autofocus/></td>
                            </tr>
							<tr>
                            	<td><label for="cmbjob">Job Title</label></td>
                                <td><select class="form-control" id="cmbjob" name="cmbjob">
                                      <option value="">--Select--</option>
										 <?php $sql_opt="SELECT * FROM tbl_job;";
                                           $result=mysqli_query($conn,$sql_opt) or die("SQL error:".mysqli_error());
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
                                <td><label for="optstat">Status<em style="color:#F00">*</em></label></td>
                                <td><input class="radio-inline" id="optstat" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>Active
                                <input class="radio-inline" id="optstat" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>Inactive
                                </td>
                            </tr>
                            <?php if($page_action == 'add'):?>
                            <tr>
                            	<th><h2>Create Account</h2></th>
                            </tr>
                            <tr>
                            	<td><label for="txtuname">User Name<em style="color:#F00">*</em></label></td>
                                <td><input type="text" id="txtuname" name="txtuname"  value="<?php echo $uname ?>" autofocus/> </td>
                                <td><span style="color:#00f;font-size:x-small;">Assign Email if available else assign the name<br>of the employee as the User Name </span></td>
                                
                            </tr>
                            <tr>
                            	<td><label for="txtpass">Password<em style="color:#F00">*</em></label></td>
                                <td><input type="password" id="txtpass" name="txtpass" value="<?php echo $pass ?>" autofocus/></td>
                                <td><span style="color:#00f;font-size:x-small;">Enter password with atleast 8 characters<br>with atleast one letter,atleast one number<br>and can include following characters<br>!@#$%</span></td>
                            </tr>
                            <tr>
                            	<td><label for="txtrepass">Re-type Password<em style="color:#F00">*</em></label></td>
                                <td><input type="password" id="txtrepass" name="txtrepass" value="<?php echo $repass?>" autofocus/></td>
                            </tr>
                            
                            <?php endif?>
                        </table>
                        </div><!-- end frmdiv -->
                        <table class="btns tbl-horizontal  col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit"/></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </form>
                    
                    <?php endif;?><!-- if($page_action == 'add' || $page_action == 'edit'): -->
        </div><!-- end inner -->
    </div><!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>