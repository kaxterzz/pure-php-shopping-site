<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Customer Details";
$c_page = 'sales';


//--------------------------------------------------------
$page_action = '';
$page_title='';
$cusid='';
$fname='';
$lname='';
$gen='';
$add='';
$tel='';
$email='';
$frm_err_msg='';
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	if($page_action=='add'){
		$page_title='Add New Customer';
		$cusid=getCusId();
		if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
			$cusid=$_POST['txtcusid'];
			$fname=trim($_POST['txtfname']);
			$lname=trim($_POST['txtlname']);
			$gen=$_POST['optgen'];
			$add=$_POST['txtadd'];
			$tel=$_POST['txttel'];
			$email=$_POST['txtemail'];
			$fname_pat='/^[a-zA-Z]+$/';
			$lname_pat="/^[a-zA-Z]+$/";
			$tel_pat="/^[0]{1}[1-9]{2}[0-9]{7}$/";
			$email_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4}$/";
			if($fname==''|| !preg_match($fname_pat,$fname)){
				$frm_err_msg='Please enter a valid first name';
				}
			elseif($lname==''|| !preg_match( $lname_pat,$lname)){
				$frm_err_msg='Please enter a valid last name';
				}		
			elseif($add==''){
				$frm_err_msg='Please enter your address';
				}
			elseif($tel!='' && !preg_match( $tel_pat,$tel) ){
				
				$frm_err_msg='Please enter a valid telephone number';	
			}	
			elseif($email!='' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
				
				$frm_err_msg='Please enter your valid email ';
			}		
			else{
				$sql_insert="INSERT INTO tbl_customer(cus_id,cus_fname,cus_lname,cus_gen,cus_add,cus_tel,cus_email) VALUES('$cusid','$fname','$lname','$gen','$add','$tel','$email');";
				mysqli_query($GLOBALS['conn'],$sql_insert) or die("Mysql error".mysqli_error($GLOBALS['conn']));
				header('Location:'.$base_url.'sales/add_cus.php?action=add&id='.$cusid.'&s=1');
				mysqli_close($con);
				}	//else close
			
			}//post close
		}//add close
	elseif($page_action=='edit'){
		$page_title='Edit Customer Details';
		if(isset($_GET['id'])){
			$cusid=$_GET['id'];
			$sql_all="SELECT * FROM tbl_customer WHERE cus_id='$cusid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$fname=$row['cus_fname'];
			$lname=$row['cus_lname'];
			$gen=$row['cus_gen'];
			$add=$row['cus_add'];
			$tel=$row['cus_tel'];
			$email=$row['cus_email'];
			
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$fname=trim($_POST['txtfname']);
				$lname=trim($_POST['txtlname']);
				$gen=$_POST['optgen'];
				$add=$_POST['txtadd'];
				$tel=$_POST['txttel'];
				$email=$_POST['txtemail'];
				$fname_pat='/^[a-zA-Z]+$/';
				$lname_pat="/^[a-zA-Z]+$/";
				$tel_pat="/^[0]{1}[1-9]{2}[0-9]{7}$/";
				$email_pat="/^[a-zA-Z0-9\.\_]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,4}$/";
			if($fname==''|| !preg_match($fname_pat,$fname)){
				$frm_err_msg='Please enter a valid first name';
				}
			elseif($lname==''|| !preg_match( $lname_pat,$lname)){
				$frm_err_msg='Please enter a valid last name';
				}		
			elseif($add==''){
				$frm_err_msg='Please enter your address';
				}
			elseif($tel!='' && !preg_match( $tel_pat,$tel) ){
				
				$frm_err_msg='Please enter a valid telephone number';	
			}	
			elseif($email!='' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
				
				$frm_err_msg='Please enter your valid email ';
			}		
				else{
					$sql_update="UPDATE tbl_customer SET  
				cus_fname='$fname',cus_lname='$lname',cus_gen='$gen',cus_add='$add',cus_tel='$tel',cus_email='$email' WHERE cus_id='$cusid';";
					mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					header('Location:'.$base_url.'sales/view_cus.php?&id='.$cusid.'&s=1');
					}	// else close
		
			}//post close
		}	//get id close
}// edit close
else{
		header('Lacation:'.$base_url.'sales/view_cus.php');
	}
}// end action
else{
		$page_title='View Customer Details';
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
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>sales/view_cus.php">View Customer Details</a></div>
                
    		</div><!-- end page-title -->
					
           			<?php if($page_action == 'add'):?>	
                	<form class="frm form-horizontal" action="<?php echo $base_url.'sales/add_cus.php?action=add'?>" name="frmcus" method="post">
                	<?php elseif($page_action=='edit'):?>
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'sales/add_cus.php?action=edit&id='.$_GET['id']?>" name="frmcus" method="post">
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
                            	<td><label for="txtcusid">Customer Id</label></td>
                                <td><input class="form-control" id="txtcusid" name="txtcusid" type="text" value="<?php echo $cusid?>" readonly/></td>
                            </tr>
                        	<tr>
                            	<td><label for="txtfname">First Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control has-feedback" id="txtfname" name="txtfname" type="text" value="<?php echo $fname?>"/></td>
                               	<td><label for="txtlname">Last Name<em style="color:#F00">*</em></label></td>
                                <td><input class="form-control" id="txtlname" name="txtlname" type="text" value="<?php echo $lname?>"/></td>
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