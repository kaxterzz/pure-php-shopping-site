<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Reset Account";
$c_page='administration';
//------------------------------------------
$page_title='Reset Account';
$eid=$_SESSION["employee"]['eid'];
$ename='';
$uname='';
$pass='';
$repass='';
$frm_err_msg='';

$sql_all="SELECT emp_uname,emp_fname,emp_email FROM tbl_emp WHERE emp_id='$eid';";
$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
$row=mysqli_fetch_assoc($result);
$uname=$row['emp_uname'];
$ename=$row['emp_fname'];
$eemail=$row['emp_email'];
if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
	$pass=$_POST['txtpass'];
	$repass=$_POST['txtrepass'];
	$pass_pat="/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/";
	$repass_pat="/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/";
	$epass=md5($pass);
	$erepass=md5($repass);
	if($pass=='' || !preg_match($pass_pat, $pass) ){
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
		$sql="UPDATE tbl_emp SET emp_pass='$epass' WHERE emp_id='$eid';";
		mysqli_query($GLOBALS['conn'],$sql) or die("Mysql error".mysqli_error($GLOBALS['conn']));
		$from ="clothshop@gmail.com";
		$header = "From : ".$from;
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-type: text/html; charset=iso-8859-1\n";
		$to = $eemail;
		$subject ='Account Reset';
		$message ='Dear '.$ename.'<br/>Your Account password have been changed Successfully<br/><br/>Thank you';
		$message = wordwrap($message, 70);	  
		// send mail
		if(mail($to,$subject,$message,$header))
				$esmsg="success email";
				if($esmsg=='success email'){
				header('Location:'.$base_url.'employee/reset_acc.php?&id='.$eid.'&s=1');	
		}



				
	}
}//end isset
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
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'employee/reset_acc.php'?>" name="frmemp" method="post">
                    
                    <div class="form_msg">
						<?php if($frm_err_msg != ''){
                            echo '<p class="bg-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="bg-success">Password have been Successfully changed</p>';
                        }
                        ?>
                    </div>
                    	<div class="frmdiv col-md-9">
                		<table class="frm-tbl table table-responsive">
                        	<tr>
                            	<td><label for="txtuname">User Name<em style="color:#F00">*</em></label></td>
                                <td><input type="text" id="txtuname" name="txtuname" value="<?php echo $uname ?>" readonly/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtpass">Password<em style="color:#F00">*</em></label></td>
                                <td><input type="password" id="txtpass" name="txtpass" value="<?php echo $pass ?>" autofocus/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtrepass">Re-type Password<em style="color:#F00">*</em></label></td>
                                <td><input type="password" id="txtrepass" name="txtrepass" value="<?php echo $repass ?>" autofocus/></td>
                            </tr>
                        </table>
                        </div><!-- end frmdiv -->
                        <table class="btns tbl-horizontal  col-md-3">
							<tr>
                            	<td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit" /></td>
                                <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
                            </tr>
                            
                        </table> 	
                    </form>  
        </div><!-- end inner -->
    </div><!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>