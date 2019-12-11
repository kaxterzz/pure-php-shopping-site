<?php 
$meta_title='Checkout Details';
$c_page = 'checkout';
include('inc_head.php');
session_start();
$session_id = session_id();

$Bfname='';
$Blname='';
$Bcompany='';
$Badd='';
$Badd2='';
$Bcity='';
$Bprov='';
$Btel='';
$Bemail='';

$fname='';
$lname='';
$company='';
$add='';
$add2='';
$city='';
$prov='';
$tel='';
$email='';
$frm_err_msg='';
$frm_err_msg_b='';
?>
</head>

<body>
<?php include('inc_header.php');?>
<?php if(isset($_SESSION['customer']) || isset($_SESSION['customer']['cid'])){ //if user logged in
			$cid=$_SESSION['customer']['cid'];
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
				
				$sql_all2="SELECT * FROM tbl_ship_info WHERE cus_id='$cid';";
				$result2=mysqli_query($GLOBALS['conn'],$sql_all2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				$nor2=mysqli_num_rows($result2);
				if($nor2>0){
					$row=mysqli_fetch_assoc($result2);
					$fname=$row['ship_fname'];
					$lname=$row['ship_lname'];
					$company=$row['ship_comp'];
					$add=$row['ship_add1'];
					$add2=$row['ship_add2'];
					$city=$row['ship_city'];
					$prov=$row['ship_prov'];
					$tel=$row['ship_tel'];
					$email=$row['ship_email'];
				}
			}
?>
<div class="container-fluid col-md-offset-1">
	<div id="msg"></div>
	<form class="frm form-horizontal" action="<?php echo $base_url.'checkout_bill_ship_info.php'?>" name="frmcheck" method="post">

	<div class="bill-form container col-md-5">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title"><h4>Billing Details</h4></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
            	<div id="msgb"></div>
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
                        </div><!-- end tel grp -->
                      	
                    </div><!-- end form horizontal -->   
            </div><!-- panel-body --> 
            <div class="panel-footer">
            </div><!-- panel-footer -->
         </div><!-- main panel -->    
    </div><!-- bill-form -->
    
    <div class="ship-form container col-md-5">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title row"><h4 class="col-sm-7">Shipping Details</h4> <a class="col-sm-5" role="button" onClick="fillShipInfo();"><small>Same Billing Details <span class="glyphicon glyphicon-arrow-down"></span></small></a></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
            	<div id="msgs"> </div>
             	<div class="form-horizontal" role="form" id="frmbill">
                    	<div class="form-group" >
                        	<label for="txtfname" class="col-sm-3 control-label">First Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtfname" name="txtfname" placeholder="" class="form-control" value="<?php echo $fname ?>"/>
                       		 </div>   
                        </div><!-- end fname grp -->
                        <div class="form-group" >
                        	<label for="txtlname" class="col-sm-3 control-label">Last Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtlname" name="txtlname" placeholder="" class="form-control" value="<?php echo $lname ?>"/>
                       		 </div>   
                        </div><!-- end lname grp -->
                        <div class="form-group" >
                        	<label for="txtcomp" class="col-sm-3 control-label">Company</label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtcomp" name="txtcomp" placeholder="" class="form-control" value="<?php echo $company ?>"/>
                       		 </div>   
                        </div><!-- end company grp -->
                        <div class="form-group" >
                        	<label for="txtadd" class="col-sm-3 control-label">AddressLine1<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtadd" name="txtadd" placeholder="" class="form-control" value="<?php echo $add ?>"/>
                       		 </div>   
                        </div><!-- end add1 grp -->
                        <div class="form-group" >
                        	<label for="txtadd2" class="col-sm-3 control-label">AddressLine2<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtadd2" name="txtadd2" placeholder="" class="form-control" value="<?php echo $add2 ?>"/>
                       		 </div>   
                        </div><!-- end add2 grp -->
                        <div class="form-group" >
                        	<label for="txtcity" class="col-sm-3 control-label">City<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtcity" name="txtcity" placeholder="" class="form-control" value="<?php echo $city ?>"/>
                       		 </div>   
                        </div><!-- end city grp -->
                        <div class="form-group" >
                        	<label for="cmbprov" class="col-sm-3 control-label">Province<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<select class="form-control" id="cmbprov" name="cmbprov">
                                    <option value="">--Select Province--</option>
                                    <?php //getCategory($cat) ?>
                                    <?php $sql_opt="SELECT * FROM tbl_province;";
                                                               $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
                                                               while($row=mysqli_fetch_assoc($result)){
                                                                   $provid=$row['prov_id'];
                                                                   $provname=$row['Prov_name'];
                                                                   $select='';
                                                                   if($prov==$provid){
                                                                       $select='selected="selected"';
                                                                   }
                                                                   
                                                             ?>
                                    <option value="<?php echo $provid?>" <?php echo $select?>><?php  echo $provname ?></option>
                                    <?php  }//end while?>
                                  </select>
                       		 </div>   
                        </div><!-- end province grp -->
                         <div class="form-group" >
                        	<label for="txttel" class="col-sm-3 control-label">Telephone<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="tel" id="txttel" name="txttel" placeholder="" class="form-control" value="<?php echo $tel ?>"/>
                       		 </div>   
                        </div><!-- end tel grp -->
                        <div class="form-group" >
                        	<label for="txtemail" class="col-sm-3 control-label">Email<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="email" id="txtemail" name="txtemail" placeholder="" class="form-control" value="<?php echo $email ?>"/>
                       		 </div>   
                        </div><!-- end tel grp -->
                        
                    </div><!-- end form horizontal -->   
            </div><!-- panel-body -->
            <div class="panel-footer">
            </div> <!-- panel-footer -->
         </div><!-- main panel -->    
    </div><!-- ship-form-->
   <!-- </form> -->
    		<table class"btns tbl-horizontal table-responsive">
            	<tr>
          		 	<td class="col-md-6"><a class="btn btn-warning" role="button" id="btnbcart" name="btnbcart" href="cart.php">Back to Cart <span class="glyphicon glyphicon-shopping-cart"></span></a></td>
                 	<td class="col-md-6"><button type="button" class="btn btn-primary" id="btncontinue2" name="btncontinue2">Continue<span class="glyphicon glyphicon-ok"></span></button></td>
          		</tr>
             </table>  
       </form> 
</div><!-- main container -->
<?php }
elseif(!isset($_SESSION['customer'])|| !isset($_SESSION['customer']['cid'])){ // if user not logged in 
	$sql_all="SELECT * FROM tbl_billing_info WHERE session_id='$session_id';";
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
				
				$sql_all2="SELECT * FROM tbl_ship_info WHERE session_id='$session_id';";
				$result2=mysqli_query($GLOBALS['conn'],$sql_all2) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
				$nor2=mysqli_num_rows($result2);
				if($nor2>0){
					$row=mysqli_fetch_assoc($result2);
					$fname=$row['ship_fname'];
					$lname=$row['ship_lname'];
					$company=$row['ship_comp'];
					$add=$row['ship_add1'];
					$add2=$row['ship_add2'];
					$city=$row['ship_city'];
					$prov=$row['ship_prov'];
					$tel=$row['ship_tel'];
					$email=$row['ship_email'];
				}
			}
?>

<div class="container-fluid col-md-offset-1">
	<div id="msg"></div>
	<form class="frm form-horizontal" action="<?php echo $base_url.'checkout_bill_ship_info.php'?>" name="frmcheck" method="post">

	<div class="bill-form container col-md-5">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title"><h4>Billing Details</h4></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
            	<div id="msgb"></div>
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
                        </div><!-- end tel grp -->
                      	
                    </div><!-- end form horizontal -->   
            </div><!-- panel-body --> 
            <div class="panel-footer">
            </div><!-- panel-footer -->
         </div><!-- main panel -->    
    </div><!-- bill-form -->
    
    <div class="ship-form container col-md-5">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title row"><h4 class="col-sm-7">Shipping Details</h4> <a class="col-sm-5" role="button" onClick="fillShipInfo();"><small>Same Billing Details <span class="glyphicon glyphicon-arrow-down"></span></small></a></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
            	<div id="msgs"> </div>
             	<div class="form-horizontal" role="form" id="frmbill">
                    	<div class="form-group" >
                        	<label for="txtfname" class="col-sm-3 control-label">First Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtfname" name="txtfname" placeholder="" class="form-control" value="<?php echo $fname ?>"/>
                       		 </div>   
                        </div><!-- end fname grp -->
                        <div class="form-group" >
                        	<label for="txtlname" class="col-sm-3 control-label">Last Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtlname" name="txtlname" placeholder="" class="form-control" value="<?php echo $lname ?>"/>
                       		 </div>   
                        </div><!-- end lname grp -->
                        <div class="form-group" >
                        	<label for="txtcomp" class="col-sm-3 control-label">Company</label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtcomp" name="txtcomp" placeholder="" class="form-control" value="<?php echo $company ?>"/>
                       		 </div>   
                        </div><!-- end company grp -->
                        <div class="form-group" >
                        	<label for="txtadd" class="col-sm-3 control-label">AddressLine1<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtadd" name="txtadd" placeholder="" class="form-control" value="<?php echo $add ?>"/>
                       		 </div>   
                        </div><!-- end add1 grp -->
                        <div class="form-group" >
                        	<label for="txtadd2" class="col-sm-3 control-label">AddressLine2<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtadd2" name="txtadd2" placeholder="" class="form-control" value="<?php echo $add2 ?>"/>
                       		 </div>   
                        </div><!-- end add2 grp -->
                        <div class="form-group" >
                        	<label for="txtcity" class="col-sm-3 control-label">City<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtcity" name="txtcity" placeholder="" class="form-control" value="<?php echo $city ?>"/>
                       		 </div>   
                        </div><!-- end city grp -->
                        <div class="form-group" >
                        	<label for="cmbprov" class="col-sm-3 control-label">Province<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<select class="form-control" id="cmbprov" name="cmbprov">
                                    <option value="">--Select Province--</option>
                                    <?php //getCategory($cat) ?>
                                    <?php $sql_opt="SELECT * FROM tbl_province;";
                                                               $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
                                                               while($row=mysqli_fetch_assoc($result)){
                                                                   $provid=$row['prov_id'];
                                                                   $provname=$row['Prov_name'];
                                                                   $select='';
                                                                   if($prov==$provid){
                                                                       $select='selected="selected"';
                                                                   }
                                                                   
                                                             ?>
                                    <option value="<?php echo $provid?>" <?php echo $select?>><?php  echo $provname ?></option>
                                    <?php  }//end while?>
                                  </select>
                       		 </div>   
                        </div><!-- end province grp -->
                         <div class="form-group" >
                        	<label for="txttel" class="col-sm-3 control-label">Telephone<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="tel" id="txttel" name="txttel" placeholder="" class="form-control" value="<?php echo $tel ?>"/>
                       		 </div>   
                        </div><!-- end tel grp -->
                        <div class="form-group" >
                        	<label for="txtemail" class="col-sm-3 control-label">Email<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="email" id="txtemail" name="txtemail" placeholder="" class="form-control" value="<?php echo $email ?>"/>
                       		 </div>   
                        </div><!-- end tel grp -->
                        
                    </div><!-- end form horizontal -->   
            </div><!-- panel-body -->
            <div class="panel-footer">
            </div> <!-- panel-footer -->
         </div><!-- main panel -->    
    </div><!-- ship-form-->
   <!-- </form> -->
    		<table class"btns tbl-horizontal table-responsive">
            	<tr>
          		 	<td class="col-md-6"><a class="btn btn-warning" role="button" id="btnbcart" name="btnbcart" href="cart.php">Back to Cart <span class="glyphicon glyphicon-shopping-cart"></span></a></td>
                 	<td class="col-md-6"><button type="button" class="btn btn-primary" id="btncontinue" name="btncontinue">Continue<span class="glyphicon glyphicon-ok"></span></button></td>
          		</tr>
             </table>  
       </form> 
</div><!-- main container -->
<?php }?>
 <?php include('admin/inc-footer.php'); ?>
   
</body>

<script type="text/javascript">
$('#btncontinue2').click(function(){
			//alert('done');
			var Bfname=$('#txtBfname').val();
		var Blname=$('#txtBlname').val();
		var Bcomp=$('#txtBcomp').val();
		var Badd=$('#txtBadd').val();
		var Badd2=$('#txtBadd2').val();
		var Bcity=$('#txtBcity').val();
		var Bprov=$('#cmbBprov').val();
		var Btel=$('#txtBtel').val();
		var Bemail=$('#txtBemail').val();
		
		var fname=$('#txtfname').val();
		var lname=$('#txtlname').val();
		var comp=$('#txtcomp').val();
		var add=$('#txtadd').val();
		var add2=$('#txtadd2').val();
		var city=$('#txtcity').val();
		var prov=$('#cmbprov').val();
		var tel=$('#txttel').val();
		var email=$('#txtemail').val(); //alert(prov);
		$.post("lib/site_functions.php?type=billshipinsrtupdt_cus",{Bfname:Bfname,Blname:Blname,Bcomp:Bcomp,Badd:Badd,Badd2:Badd2,Bcity:Bcity,Bprov:Bprov,Btel:Btel,Bemail:Bemail,fname:fname,lname:lname,comp:comp,add:add,add2:add2,city:city,prov:prov,tel:tel,email:email},function(data,status){
			if(status=='success'){
				console.log(data);
				console.log(status);
				var dataArr = data.split("|");
				if(dataArr[0]==2 || dataArr[0]==3 || dataArr[0]==4 || dataArr[0]==5 || dataArr[0]==6){
					$("#msgb").css("display","block");
					$("#msgb").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');	
				}
				else if(dataArr[0]==7 || dataArr[0]==8 || dataArr[0]==9 || dataArr[0]==10 || dataArr[0]==11 || dataArr[0]==12){
					$("#msgs").css("display","block");
					$("#msgs").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
				}
				else if(dataArr[0]==1){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-success">'+dataArr[1]+'</p>');
					setTimeout(function(){ window.location.href= "check_confrm.php"; },1500);
				}
			}
			});
});
$("#btncontinue").click(function(){
	alert('done');
		var Bfname=$('#txtBfname').val();
		var Blname=$('#txtBlname').val();
		var Bcomp=$('#txtBcomp').val();
		var Badd=$('#txtBadd').val();
		var Badd2=$('#txtBadd2').val();
		var Bcity=$('#txtBcity').val();
		var Bprov=$('#cmbBprov').val();
		var Btel=$('#txtBtel').val();
		var Bemail=$('#txtBemail').val();
		
		var fname=$('#txtfname').val();
		var lname=$('#txtlname').val();
		var comp=$('#txtcomp').val();
		var add=$('#txtadd').val();
		var add2=$('#txtadd2').val();
		var city=$('#txtcity').val();
		var prov=$('#cmbprov').val();
		var tel=$('#txttel').val();
		var email=$('#txtemail').val(); //alert(prov);
		$.post("lib/site_functions.php?type=billshipinsrt_sess",{Bfname:Bfname,Blname:Blname,Bcomp:Bcomp,Badd:Badd,Badd2:Badd2,Bcity:Bcity,Bprov:Bprov,Btel:Btel,Bemail:Bemail,fname:fname,lname:lname,comp:comp,add:add,add2:add2,city:city,prov:prov,tel:tel,email:email},function(data,status){
			if(status=='success'){
				console.log(data);
				console.log(status);
				
				var dataArr = data.split("|");
				console.log(dataArr);
				
				if(dataArr[0]==2 || dataArr[0]==3 || dataArr[0]==4 || dataArr[0]==5 || dataArr[0]==6){
					$("#msgb").css("display","block");
					$("#msgb").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');	
				}
				else if(dataArr[0]==7 || dataArr[0]==8 || dataArr[0]==9 || dataArr[0]==10 || dataArr[0]==11 || dataArr[0]==12){
					$("#msgs").css("display","block");
					$("#msgs").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
				}
				else if(dataArr[0]==1){
					$("#msg").css("display","block");
					$("#msg").html('<p class="alert alert-success">'+dataArr[1]+'</p>');
					setTimeout(function(){ window.location.href= "check_confrm.php"; },1500);
				}
			}
			});
});
			
		
function fillShipInfo()	{ //fill the shipping details automatically when 'same billing details' link is clicked
	var Bfname=$('#txtBfname').val();
	var Blname=$('#txtBlname').val();
	var Bcomp=$('#txtBcomp').val();
	var Badd=$('#txtBadd').val();
	var Badd2=$('#txtBadd2').val();
	var Bcity=$('#txtBcity').val();
	var Bprov=$('#cmbBprov').val();
	var Btel=$('#txtBtel').val();
	var Bemail=$('#txtBemail').val();
	
	$('#txtfname').val(Bfname);
	$('#txtlname').val(Blname);
	$('#txtcomp').val(Bcomp);
	$('#txtadd').val(Badd);
	$('#txtadd2').val(Badd2);
	$('#txtcity').val(Bcity);
	$('#cmbprov').val(Bprov);
	$('#txttel').val(Btel);
	$('#txtemail').val(Bemail);
}	
</script>
</html>
