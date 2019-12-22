<?php 
session_start();
if((!isset($_SESSION['customer'])) || (!isset($_SESSION['customer']['cid']))){
	header("Location:login.php");
}
$session_id=session_id();
$cid=$_SESSION["customer"]["cid"];
$meta_title='My Account Details';
$c_page = 'myaccount';
include('inc_head.php');
$msg='';
//cus_info_variable
$fname='';
$lname='';
$add='';
$add2='';
$city='';
$tel='';
$gen='';

//reset pass variables
$uname='';
$pass='';
$repass='';

//bill info variables
$Bfname='';
$Blname='';
$Bcompany='';
$Badd='';
$Badd2='';
$Bcity='';
$Bprov='';
$Btel='';
$Bemail='';

$page_action='';
$frm_err_msg='';
//cus_info
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	if($page_action=='cusdetails'){
			$sql_all="SELECT * FROM tbl_customer WHERE cus_id='$cid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$fname=$row['cus_fname'];
			$lname=$row['cus_lname'];
			$gen=$row['cus_gen'];
			$add=$row['cus_add'];
			$add2=$row['cus_add2'];
			$city=$row['cus_city'];
			$tel=$row['cus_tel'];
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$fname=trim($_POST['txtfname']);
				$lname=trim($_POST['txtlname']);
				$gen=$_POST['optgen'];
				$add=$_POST['txtadd'];
				$add2=$_POST['txtadd2'];
				$city=$_POST['txtcity'];
				$tel=$_POST['txttel'];
				$fname_pat='/[a-zA-Z]+/';
				$lname_pat="/[a-zA-Z]+/";
				$tel_pat="/^[0]{1}[1-9]{2}[0-9]{7}$/";
				if($fname==''|| !preg_match($fname_pat,$fname)){
					$frm_err_msg='Please enter a valid first name';
					}
				elseif($lname==''|| !preg_match( $lname_pat,$lname)){
					$frm_err_msg='Please enter a valid last name';
					}	
				elseif($add=='' && $add2=='' && $city==''){
					$frm_err_msg='Please enter your address';
					}
				elseif($tel!='' && !preg_match( $tel_pat,$tel) ){
					
					$frm_err_msg='Please enter a valid telephone number';
					
				}		
				
				else{
					$sql_update="UPDATE tbl_customer SET cus_fname='$fname',cus_lname='$lname',cus_gen='$gen',cus_add='$add',cus_add2='$add2',cus_city='$city',cus_tel='$tel' WHERE cus_id='$cid';";
					mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					header('Location:'.$base_url.'myaccount.php?&id='.$cid.'&s=1');
					}	// else close
		
			}//post close
	}// cusdetails close
//reset pass
	elseif($page_action=='resetpass'){
			$sql_all="SELECT cus_email,cus_fname FROM tbl_customer WHERE cus_id='$cid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$uname=$row['cus_email'];
			$fname=$row['cus_fname'];
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
					$sql_update="UPDATE tbl_customer SET cus_pass='$epass' WHERE cus_id='$cid';";
					mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					$from ="amayafashion72@gmail.com";
					$header = "From : ".$from;
					$header .= "MIME-Version: 1.0\n";
					$header .= "Content-Type: text/html; charset=UTF-8\r\n";
					$header .= 'From: Amaya Fashions <amayafashion72@gmail.com>' . "\r\n";
					$to =$uname;
					$subject ='Account Reset';
					$message ='Dear '.$fname.'<br/>Your Account password have been changed Successfully<br/><br/>Thank you';
					$message = wordwrap($message, 70);	  
					// send mail
					if(mail($to,$subject,$message,$header))
						$esmsg="success email";

						// $resp ='+94712000300';
						// $msg ='Dear '.$fname.',Your Account password have been changed Successfully';
						// $gatewayURL = 'http://localhost:9333/ozeki?'; 
						// $request = 'login=admin'; 
						// $request .= '&password=abc123'; 
						// $request .= '&action=sendMessage'; 
						// $request .= '&messageType=SMS:TEXT'; 
						// $request .= '&recepient='.urlencode($resp); 
						// $request .= '&messageData='.urlencode($msg);
						// $url = $gatewayURL . $request; 
						// //Open the URL to send the message 
						// file($url);
						// $smsg="success";
						if($esmsg=='success email')
							header('Location:'.$base_url.'myaccount.php?&id='.$cid.'&ss=1');	
						
				}	// else close
		
			}//post close
	}// resetpass close
//billdetails	
	elseif($page_action=='billdetails'){
		$sql_email="SELECT cus_email FROM tbl_customer WHERE cus_id='$cid';";
			$res_email=mysqli_query($GLOBALS['conn'],$sql_email) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($res_email);
			$Bemail=$row['cus_email'];
			$sql_all="SELECT * FROM tbl_billing_info WHERE cus_id='$cid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$nor=mysqli_num_rows($result);
			if($nor>0){ //if record is available
				$row=mysqli_fetch_assoc($result);
				$Bfname=$row['bill_fname'];
				$Blname=$row['bill_lname'];
				$Bcompany=$row['bill_comp'];
				$Badd=$row['bill_add1'];
				$Badd2=$row['bill_add2'];
				$Bcity=$row['bill_city'];
				$Bprov=$row['bill_prov'];
				$Btel=$row['bill_tel'];
				$Bemail=$row['bill_email'];
			}
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$Bfname=$_POST['txtBfname'];
				$Blname=$_POST['txtBlname'];
				$Bcompany=$_POST['txtBcomp'];
				$Badd=$_POST['txtBadd'];
				$Badd2=$_POST['txtBadd2'];
				$Bcity=$_POST['txtBcity'];
				$Bprov=$_POST['cmbBprov'];
				$Btel=$_POST['txtBtel'];
				$Bemail=$_POST['txtBemail'];
				$Bfname_pat='/[a-zA-Z]+/';
				$Blname_pat="/[a-zA-Z]+/";
				$Btel_pat="/^[0]{1}[1-9]{2}[0-9]{7}$/";
				if($Bfname==''|| !preg_match($Bfname_pat,$Bfname)){
				$frm_err_msg='Please enter a valid first name';
				}
				elseif($Blname==''|| !preg_match( $Blname_pat,$Blname)){
					$frm_err_msg='Please enter a valid last name';
					}	
				elseif($Badd=='' || $Badd2=='' || $Bcity==''){
					$frm_err_msg='Please enter your address';
					}
				elseif($Btel=='' || !preg_match($Btel_pat,$Btel) ){
					$frm_err_msg='Please enter a valid telephone number';	
				}	
				else{
					$sql_update="UPDATE tbl_billing_info SET bill_fname='$Bfname',bill_lname='$Blname',bill_comp='$Bcomp',bill_add1='$Badd',bill_add2='$Badd2',bill_city='$Bcity',bill_prov='$Bprov',bill_tel='$Btel',bill_email='$Bemail' WHERE cus_id='$cid';";
					mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					header('Location:'.$base_url.'myaccount.php?&id='.$cid.'&s=1');
					}	// else close
			}
	}	//billdetails close
}
?>
</head>

<body>
<?php include('inc_header.php');?>
<div class="container">
	<div id="msg" class="alert alert-dismissible">
    	 <?php if($frm_err_msg != ''){
                            echo '<p class="alert alert-danger">'.$frm_err_msg.'</p>';
                        }
                        if(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="alert alert-success">Record has been succesfuly saved</p>';
                        }
						if(isset($_GET['ss']) && $_GET['ss'] == '1'){
                            echo '<p class="alert alert-success">Password have been Successfully changed</p>';
                        }
                        ?>
    </div>
        <ul class="nav nav-tabs">
          <li><a class="btn btn-primary" href="<?php echo $base_url.'myaccount.php?action=cusdetails&id='.$cid?>" id="showcus">Edit Account Details</a></li>
          <li><a class="btn btn-warning" href="<?php echo $base_url.'myaccount.php?action=resetpass&id='.$cid?>" id="showcus">Reset Password</a></li>
          <li><a class="btn btn-primary" href="<?php echo $base_url.'myaccount.php?action=billdetails&id='.$cid?>" id="showcus">Edit Billing Details</a></li>
        </ul>
         <?php if($page_action==''):?>
         	<div class="container" id="Cusdetails" style="margin-top:20px;margin-bottom:20px">
            	<center><h1><span class="alert alert-info"> Welcome to your Account !!! </span></h1></center>
            </div>
         <?php elseif($page_action=='cusdetails'):?>
        <div class="container" id="Cusdetails" style="margin-top:20px">
        	<div class="container" id="title" style="margin-top:20px;margin-bottom:20px">
            	<center><h1><span class="alert alert-info"> Edit Basic Details </span></h1></center>
            </div>
            	<form class="frm form-horizontal" action="<?php echo $base_url.'myaccount.php?action=cusdetails&id='.$cid?>" name="frmemp" method="post">
                <div class="form-horizontal" role="form" id="frmcus">
                    	<div class="form-group" >
                        	<label for="txtfname" class="col-sm-2 control-label">First Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-4">   
                            		<input type="text" id="txtfname" name="txtfname" placeholder="" class="form-control" value="<?php echo $fname ?>"/>
                       		 </div>   
                        </div><!-- end fname grp -->
                        <div class="form-group" >
                        	<label for="txtlname" class="col-sm-2 control-label">Last Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-4">   
                            		<input type="text" id="txtlname" name="txtlname" placeholder="" class="form-control" value="<?php echo $lname ?>"/>
                       		 </div>   
                        </div><!-- end lname grp -->
                        <div class="form-group" >
                        	<label for="txtadd" class="col-sm-2 control-label">Address Line 1<em style="color:#F00">*</em></label>
                        	<div class="col-sm-4">   
                            		<input type="text" id="txtadd" name="txtadd" placeholder="" class="form-control" value="<?php echo $add ?>"/>
                       		 </div>   
                        </div><!-- end add grp -->
                        <div class="form-group" >
                        	<label for="txtadd2" class="col-sm-2 control-label">Address Line 2<em style="color:#F00">*</em></label>
                        	<div class="col-sm-4">   
                            		<input type="text" id="txtadd2" name="txtadd2" placeholder="" class="form-control" value="<?php echo $add2 ?>"/>
                       		 </div>   
                        </div><!-- end add2 grp -->
                        <div class="form-group" >
                        	<label for="txtcity" class="col-sm-2 control-label">City<em style="color:#F00">*</em></label>
                        	<div class="col-sm-4">   
                            		<input type="text" id="txtcity" name="txtcity" placeholder="" class="form-control" value="<?php echo $city ?>"/>
                       		 </div>   
                        </div><!-- end add grp -->
                        <div class="form-group" >
                        	<label for="optgen" class="col-sm-2 control-label">Gender<em style="color:#F00">*</em></label>
                            <div class="col-sm-4">
                                <div class="col-sm-2"><input class="form-group inline col-sm-6" id="optgen1" name="optgen" type="radio" value="1" <?php if($gen=='1'):?>checked='checked'<?php endif; ?>checked><span class="col-sm-6">Male</span></div>
                               <div class="col-sm-offset-2"><input class="form-group inline col-sm-6" id="optgen2" name="optgen" type="radio" value="0" <?php if($gen=='0'):?>checked='checked'<?php endif; ?>><span class="col-sm-6">Female</span></div>
                             </div>   
                         </div>
                         <div class="form-group" >
                        	<label for="txttel" class="col-sm-2 control-label">Telephone</label>
                        	<div class="col-sm-4">   
                            		<input type="tel" id="txttel" name="txttel" placeholder="" class="form-control" value="<?php echo $tel ?>"/>
                       		 </div>   
                        </div><!-- end tel grp -->
                    </div><!-- end form horizontal --> 
                 <div class="form-group last">
                  <div class="col-sm-offset-4">
                 	<input type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit"value="Submit" />
                    <input type="reset" class="btn btn-warning" id="btnreset" value="Reset"/>
          			</div>
                 </div> 
                 </form>
           </div><!--end cusdetails-->  
           
           <?php elseif($page_action=='resetpass'):?>
       		 <div class="container" id="resetpass" style="margin-top:20px">
             	<div class="container" id="title" style="margin-top:20px;margin-bottom:20px">
            	<center><h1><span class="alert alert-info"> Reset Password </span></h1></center>
            </div>
             	<form class="frm form-horizontal" action="<?php echo $base_url.'myaccount.php?action=resetpass&id='.$cid?>" name="frmresetpass" method="post">
                	<div class="form-horizontal" role="form" id="frmcus">
                    	<div class="form-group" >
                			<label for="txtuname" class="col-sm-2 control-label">User Name<em style="color:#F00">*</em></label>
                    			<div class="col-sm-4">
                             		<input type="text" id="txtuname" name="txtuname"  value="<?php echo $uname ?>" readonly/>
                        		</div>    
                    	</div><!--end form-group -->  
                    	<div class="form-group" >          
                     		<label for="txtpass" class="col-sm-2 control-label">Password<em style="color:#F00">*</em></label>
                            	<div class="col-sm-4">
                                	<input type="password" id="txtpass" name="txtpass" value="<?php echo $pass ?>" autofocus/>
                                 </div>   
                    	</div><!--end form-group -->
                        <div class="form-group" >             
                            	<label for="txtrepass" class="col-sm-2 control-label">Re-type Password<em style="color:#F00">*</em></label>
                                <div class="col-sm-4">
                               		<input type="password" id="txtrepass" name="txtrepass" value="<?php echo $repass?>" autofocus/>
                                </div>    
                    	</div><!--end form-group -->        
                    </div> <!--end form-horizontal-->     
                <div class="form-group last">
                  <div class="col-sm-offset-4">
                 	<input type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit"value="Submit" />
                    <input type="reset" class="btn btn-warning" id="btnreset" value="Reset"/>
          			</div>
                 </div> 
                </form>  
           </div><!--END rsetpass-->
           <?php elseif($page_action=='billdetails'):?>
       		 <div class="container" id="billdetails" style="margin-top:20px">
             	<div class="container" id="title" style="margin-top:20px;margin-bottom:20px">
            	<center><h1><span class="alert alert-info"> Edit Billing Details</span></h1></center>
            </div>
             	<form class="frm form-horizontal" action="<?php echo $base_url.'myaccount.php?action=billdetails&id='.$cid?>" name="frmresetpass" method="post">
                	<div class="form-horizontal" role="form" id="frmbill">
                    	<div class="form-group" >
                        	<label for="txtBfname" class="col-sm-3 control-label">First Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtBfname" name="txtBfname" placeholder="" class="form-control" value="<?php echo $Bfname ?>"/>
                       		 </div>   
                        </div><!-- end fname grp -->
                        <div class="form-group" >
                        	<label for="txtBlname" class="col-sm-3 control-label">Last Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtBlname" name="txtBlname" placeholder="" class="form-control" value="<?php echo $Blname ?>"/>
                       		 </div>   
                        </div><!-- end lname grp -->
                        <div class="form-group" >
                        	<label for="txtBcomp" class="col-sm-3 control-label">Company</label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtBcomp" name="txtBcomp" placeholder="" class="form-control" value="<?php echo $Bcompany ?>"/>
                       		 </div>   
                        </div><!-- end company grp -->
                        <div class="form-group" >
                        	<label for="txtBadd" class="col-sm-3 control-label">AddressLine1<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtBadd" name="txtBadd" placeholder="" class="form-control" value="<?php echo $Badd ?>"/>
                       		 </div>   
                        </div><!-- end add1 grp -->
                        <div class="form-group" >
                        	<label for="txtBadd2" class="col-sm-3 control-label">AddressLine2<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtBadd2" name="txtBadd2" placeholder="" class="form-control" value="<?php echo $Badd2 ?>"/>
                       		 </div>   
                        </div><!-- end add2 grp -->
                        <div class="form-group" >
                        	<label for="txtBcity" class="col-sm-3 control-label">City<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtBcity" name="txtBcity" placeholder="" class="form-control" value="<?php echo $Bcity ?>"/>
                       		 </div>   
                        </div><!-- end city grp -->
                        <div class="form-group" >
                        	<label for="cmbBprov" class="col-sm-3 control-label">Province</label>
                        	<div class="col-sm-7">   
                            		<select class="form-control" id="cmbBprov" name="cmbBprov">
                                    <option value="">--Select Province--</option>
                                    <?php //getCategory($cat) ?>
                                    <?php $sql_opt="SELECT * FROM tbl_province;";
                                          $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
                                          while($row=mysqli_fetch_assoc($result)){
                                                $Bprovid=$row['prov_id'];
                                                $Bprovname=$row['Prov_name'];
                                                $select='';
                                                if($Bprov==$Bprovid){
                                                  $select='selected="selected"';
                                                }
                                                                   
                                                             ?>
                                    <option value="<?php echo $Bprovid?>" <?php echo $select?>><?php  echo $Bprovname ?></option>
                <?php  }//end while?>
              </select>
                       		 </div>   
                        </div><!-- end province grp -->
                         <div class="form-group" >
                        	<label for="txtBtel" class="col-sm-3 control-label">Telephone<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="tel" id="txtBtel" name="txtBtel" placeholder="" class="form-control" value="<?php echo $Btel ?>"/>
                       		 </div>   
                        </div><!-- end tel grp -->
                        <div class="form-group" >
                        	<label for="txtBemail" class="col-sm-3 control-label">Email<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="email" id="txtBemail" name="txtBemail" placeholder="" class="form-control" <?php if(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid'])):?>readonly<?php endif;?> value="<?php echo $Bemail ?>"/>
                       		 </div>   
                        </div><!-- end email grp -->
                       </div> <!--end form-horizontal--> 
                       <div class="form-group last">
                          <div class="col-sm-offset-4">
                            <input type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit"value="Submit" />
                            <input type="reset" class="btn btn-warning" id="btnreset" value="Reset"/>
                            </div>
                 		</div>  
                </form>    
              </div>  <!-- end billdetails -->          
            <?php endif;?>
    
</div><!-- main container -->
 <?php include('admin/inc-footer.php'); ?>
</body>
</html>