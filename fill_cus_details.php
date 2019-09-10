<?php 
session_start();
if(!isset($_SESSION["customer"]) /*|| $_SESSION["customer"]["ctype"]!="1"*/){
	header("Location:login.php");
}
$meta_title='Basic Customer Details';
$c_page = 'myaccount';
include('inc_head.php');

$cid=$_SESSION["customer"]["cid"];
$fname='';
$lname='';
$add='';
$add2='';
$city='';
$tel='';
$gen='';
$page_action='';
$frm_err_msg='';
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	if($page_action=='add'){
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
			$tel_pat="/^[0]{1}[0-9]{9}$/";
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
				$sql="UPDATE tbl_customer SET  
				cus_fname='$fname',cus_lname='$lname',cus_gen='$gen',cus_add='$add',cus_add2='$add2',cus_city='$city',cus_tel='$tel' WHERE cus_id='$cid';";
				mysqli_query($GLOBALS['conn'],$sql) or die("Mysql error".mysqli_error($GLOBALS['conn']));
				header('Location:'.$base_url.'myaccount.php?action=add&id='.$cid.'&s=1');
				}	//else close
			
			}//post close
		}//add close
	elseif($page_action=='edit'){
		if(isset($_SESSION["customer"]["cid"])){
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
				$tel_pat="/^[0]{1}[0-9]{9}$/";
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
		}	//get id close
}// edit close
else{
		header('Lacation:'.$base_url.'myaccount.php');
	}
}// end action


?>
</head>

<body>
<?php include('inc_header.php');
if($page_action=='add' || $page_action=='edit'):
?>
<div class="container">
	<div id="msg">
    	<?php if($frm_err_msg != ''){
                            echo '<p class="alert alert-danger">'.$frm_err_msg.'</p>';
                        }
              if(isset($_GET['s']) && $_GET['s'] == '1'){
                            echo '<p class="alert alert-success">Record has been succesfuly saved</p>';
                        }
                        ?>
    </div>
<div class="container-fluid col-md-offset-3">
	
    <?php if($page_action == 'add'):?>	
                	<form class="frm form-horizontal" action="<?php echo $base_url.'fill_cus_details.php?action=add'?>" name="frmemp" method="post">
                	<?php elseif($page_action=='edit'):?>
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'fill_cus_details.php?action=edit&id='.$_GET['id']?>" name="frmemp" method="post">
                    <?php endif;?>
	<div class="bill-form container col-md-8">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title"><h4>Basic Customer Details</h4></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
             	<div class="form-horizontal" role="form" id="frmbill">
                    	<div class="form-group" >
                        	<label for="txtfname" class="col-sm-4 control-label">First Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-8">   
                            		<input type="text" id="txtfname" name="txtfname" placeholder="" class="form-control" value="<?php echo $fname ?>"/>
                       		 </div>   
                        </div><!-- end fname grp -->
                        <div class="form-group" >
                        	<label for="txtlname" class="col-sm-4 control-label">Last Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-8">   
                            		<input type="text" id="txtlname" name="txtlname" placeholder="" class="form-control" value="<?php echo $lname ?>"/>
                       		 </div>   
                        </div><!-- end lname grp -->
                        <div class="form-group" >
                        	<label for="txtadd" class="col-sm-4 control-label">Address Line 1<em style="color:#F00">*</em></label>
                        	<div class="col-sm-8">   
                            		<input type="text" id="txtadd" name="txtadd" placeholder="" class="form-control" value="<?php echo $add ?>"/>
                       		 </div>   
                        </div><!-- end add grp -->
                        <div class="form-group" >
                        	<label for="txtadd2" class="col-sm-4 control-label">Address Line 2<em style="color:#F00">*</em></label>
                        	<div class="col-sm-8">   
                            		<input type="text" id="txtadd2" name="txtadd2" placeholder="" class="form-control" value="<?php echo $add2 ?>"/>
                       		 </div>   
                        </div><!-- end add2 grp -->
                        <div class="form-group" >
                        	<label for="txtcity" class="col-sm-4 control-label">City<em style="color:#F00">*</em></label>
                        	<div class="col-sm-8">   
                            		<input type="text" id="txtcity" name="txtcity" placeholder="" class="form-control" value="<?php echo $city ?>"/>
                       		 </div>   
                        </div><!-- end add grp -->
                        <div class="form-group" >
                        	<label for="optgen" class="col-sm-4 control-label">Gender<em style="color:#F00">*</em></label>
                            <div class="col-sm-8">
                                <div class="col-sm-4"><input class="form-group inline col-sm-6" id="optgen1" name="optgen" type="radio" value="1" <?php if($gen=='1'):?>checked='checked'<?php endif; ?>checked><span class="col-sm-6">Male</span></div>
                               <div class="col-sm-4"><input class="form-group inline col-sm-6" id="optgen2" name="optgen" type="radio" value="0" <?php if($gen=='0'):?>checked='checked'<?php endif; ?>><span class="col-sm-6">Female</span></div>
                             </div>   
                         </div>
                         <div class="form-group" >
                        	<label for="txttel" class="col-sm-4 control-label">Telephone</label>
                        	<div class="col-sm-8">   
                            		<input type="tel" id="txttel" name="txttel" placeholder="" class="form-control" value="<?php echo $tel ?>"/>
                       		 </div>   
                        </div><!-- end tel grp -->
                    </div><!-- end form horizontal -->   
            </div><!-- panel-body --> 
            <div class="form-group last">
                  <div class="col-sm-offset-4">
                 	<input type="submit" class="btn btn-primary" id="btnsubmit" name="btnsubmit"value="Submit" <?php if($page_action=='edit'):?> onClick="confirmUpdate('<?php echo $base_url.'fill_cus_details.php?action=edit&amp;id='.$cid ?>');" href="javascript:void(0);"<?php endif;?>/>
                    <input type="reset" class="btn btn-warning" id="btnreset" value="Reset"/>
          			</div>
                 </div> 
                 
         </div><!-- main panel -->    
    </div><!-- bill-form -->  
    </form>      
</div><!-- main container -->
</div>
 <?php include('admin/inc-footer.php'); ?>   
</body>
</html>
<?php endif;?>