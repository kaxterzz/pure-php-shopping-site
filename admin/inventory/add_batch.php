<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
// include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
include('../lib/inv_func.php');
$meta_title = "Stock Details";
$c_page = 'inventory';
//--------------------------------------------------------
$page_action = '';
$page_title='';
$batchid='';
$cat='';
$prd='';
$date='';
$qnty='';
$cprice='';
$sprice='';
$sup='';
$stat='';
$totamnt='';
$payamnt='';
$credit='';
$settledate='';
$credit_stat='';
$frm_err_msg='';
if(isset($_GET['action'])){
	$page_action = $_GET['action'];
	if($page_action=='add'){
		$page_title='Add New Batch';
		$batchid=getBatchId();
		if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
			$batchid=$_POST['txtbid'];
			$cat=$_POST['cmbcat'];
			$prd=$_POST['cmbprd'];
			$date=$_POST['txtdate'];
			$qnty=$_POST['txtqnty'];
			$cprice=$_POST['txtcprice'];
			$sprice=$_POST['txtsprice'];
			$sup=$_POST['cmbsup'];
			$stat=$_POST['optstat'];
			$totamnt=$_POST['txttotamnt'];
			$credit=$_POST['txtcredit'];
			$settledate=$_POST['txtstldate'];
			$cprice_pat='/^[0-9]{1,6}\.[0-9]{2}$/';
			$sprice_pat='/^[0-9]{1,6}\.[0-9]{2}$/';
			$qnty_pat='/^[0-9]+$/';
			if($cat==''){
				$frm_err_msg='Please Select a Category';
			}
			elseif($prd==''){
				$frm_err_msg='Please Select a Product';
			}
			elseif($date==''){
				$frm_err_msg='Please Select a Date';
			}
			elseif($qnty==''|| !preg_match($qnty_pat,$qnty)){
					$frm_err_msg='Please enter your valid Quantity';
				}
			elseif($cprice==''|| !preg_match($cprice_pat,$cprice)){
				$frm_err_msg='Please enter a valid cost price';
				}
			elseif($sprice==''|| !preg_match( $sprice_pat,$sprice)){
				$frm_err_msg='Please enter a valid Selling price';
				}	
			elseif($sup==''){
				$frm_err_msg='Please Select a Supplier';
				}			
			else{
				if($credit!='')
					$credit_stat='1';
				else
					$credit_stat='0';
				$sql="INSERT INTO tbl_batch(batch_id,prd_id,batch_date,batch_qnty,batch_prd_cost_price,batch_prd_sell_price,sup_id,batch_pay_amount,batch_on_credit,batch_credit_amount,batch_settle_date,batch_stat) VALUES('$batchid','$prd','$date','$qnty','$cprice','$sprice','$sup','$totamnt','$credit_stat','$credit','$settledate','$stat');";
				$res1=mysqli_query($GLOBALS['conn'],$sql) or die("Mysql error".mysqli_error($GLOBALS['conn']));
				$sql2="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty+'$qnty',prd_price='$sprice' WHERE prd_id='$prd'";
				$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("Mysql error".mysqli_error($GLOBALS['conn']));
				
				if($res1>0 && $res2>0){
					$from ="amayafashion72@gmail.com";
				 	$header = "From : ".$from;
					$header .= "MIME-Version: 1.0\n";
					$header .= "Content-type: text/html; charset=iso-8859-1\n";
					$to ='newuser@localhost';
					$subject ='Batch '.$batchid.' of Product '.$prd.' Added';
					$message ='Dear Sir,<br/><center><b style="color:#9900ff">Batch Summary</b></center><br/><b>Batch Quantity:</b> '.$qnty.'<br/><b>Cost Price:</b> Rs.'.$cprice.'<br/><b>Sell Price:</b> Rs.'.$sprice.'<br/><b>Added Date:</b> '.$date.'<br/><b>Total Amount:</b> Rs.'.$totamnt.'<br/><b>Batch Credit Amount:</b> Rs.'.$credit.'<br/><b>Credit Settle Date:</b> '.$settledate.'<br/><br/>Thank you';
							  
				  // message lines should not exceed 70 characters (PHP rule), so wrap it
					$message = wordwrap($message, 70);
							  
				// send mail
					if(mail($to,$subject,$message,$header)){
						header('Location:'.$base_url.'inventory/add_batch.php?action=add&id='.$batchid.'&s=1');
					}
					
				}
			  }	//else close
			
			}//post close
		}//add close
	elseif($page_action=='edit'){
		$page_title='Edit Stock Details';
		if(isset($_GET['id'])){
			$batchid=$_GET['id'];
			$sql_all="SELECT * FROM tbl_batch WHERE batch_id='$batchid';";
			$result=mysqli_query($GLOBALS['conn'],$sql_all) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row=mysqli_fetch_assoc($result);
			$prd=$row['prd_id'];
			$sql_droplists="SELECT cat_id FROM tbl_products WHERE prd_id='$prd'";
			$result_drop=mysqli_query($GLOBALS['conn'],$sql_droplists) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
			$row_drop=mysqli_fetch_assoc($result_drop);
			$cat=$row_drop['cat_id'];
			$date=$row['batch_date'];
			$qnty=$row['batch_qnty'];
			$cprice=$row['batch_prd_cost_price'];
			$sprice=$row['batch_prd_sell_price'];
			$sup=$row['sup_id'];
			$stat=$row['batch_stat'];
			
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
			$batchid=$_POST['txtbid'];
			$cat=$_POST['cmbcat'];
			$prd=$_POST['cmbprd'];
			$date=$_POST['txtdate'];
			$qnty=$_POST['txtqnty'];
			$cprice=$_POST['txtcprice'];
			$sprice=$_POST['txtsprice'];
			$sup=$_POST['cmbsup'];
			$stat=$_POST['optstat'];
			$cprice_pat='/^[0-9]{1,6}\.[0-9]{2}$/';
			$sprice_pat='/^[0-9]{1,6}\.[0-9]{2}$/';
			$qnty_pat='/^[0-9]$/';
			if($cat==''){
				$frm_err_msg='Please Select a Category';
			}
			elseif($prd==''){
				$frm_err_msg='Please Select a Product';
			}
			elseif($date==''){
				$frm_err_msg='Please Select a Date';
			}
			elseif($qnty==''|| !preg_match($qnty_pat,$qnty)){
					$frm_err_msg='Please enter your valid Quantity';
				}
			elseif($cprice==''|| !preg_match($cprice_pat,$cprice)){
				$frm_err_msg='Please enter a valid cost price';
				}
			elseif($sprice==''|| !preg_match( $sprice_pat,$sprice)){
				$frm_err_msg='Please enter a valid Selling price';
				}	
			elseif($sup==''){
				$frm_err_msg='Please Select a Supplier';
				}		
				
			else{
					$sql_update="UPDATE tbl_batch SET  
				prd_id='$prd',batch_date='$date',batch_qnty='$qnty',batch_prd_cost_price='$cprice',batch_prd_sell_price='$sprice',sup_id='$sup',batch_stat='$stat' WHERE batch_id='$batchid';";
					$res1=mysqli_query($GLOBALS['conn'],$sql_update) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					$sql_prd_qnty="UPDATE tbl_products SET prd_tot_qnty=prd_tot_qnty+'$qnty',prd_price='$sprice' WHERE prd_id='$prd'";
					$res2=mysqli_query($GLOBALS['conn'],$sql_prd_qnty) or die("Mysql error".mysqli_error($GLOBALS['conn']));
					if($res1>0 && $res2>0)
					header('Location:'.$base_url.'inventory/view_batch.php?&id='.$batchid.'&s=1');
					}	// else close
		
			}//post close
		}	//get id close
}// edit close
else{
		header('Lacation:'.$base_url.'inventory/view_batch.php');
	}
}// end action
else{
		$page_title='View Stock Details';
	}
?>
<?php include('../inc-head.php');?>
<!-- attach inc-head.php -->
</head>

<body onLoad="startTime();">
<?php include('../inc-header.php');?>
<!-- attach inc-header.php -->
<div class="page-body container-fluid">
  <div class="container inner">
    <div class="page-title clearfix">
      <h1 class="pull-left"><?php echo $page_title ?></h1>
      <?php if($page_action == 'add' || $page_action == 'edit'): ?>
      <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>inventory/view_batch.php">View Batch Details</a></div>
    </div>
    <!-- end page-title -->
    
    <?php if($page_action == 'add'):?>
    <form class="frm form-horizontal" action="<?php echo $base_url.'inventory/add_batch.php?action=add'?>" name="frmbatch" method="post">
    <?php elseif($page_action=='edit'):?>
    <form class="frm form-horizontal" action="<?php echo $base_url.'inventory/add_batch.php?action=edit&id='.$_GET['id']?>" name="frmbatch" method="post">
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
            <td><label for="txtbid">Batch Id</label></td>
            <td><input class="form-control" id="txtbid" name="txtbid" type="text" value="<?php echo $batchid?>" readonly/></td>
          </tr>
          
            <td><label for="cmbcat">Category<em style="color:#F00">*</em></label></td>
            <td><select class="form-control" id="cmbcat" name="cmbcat">
                <option value="">--Select Category--</option>
                <?php getCategory($cat) ?>
              </select></td>
            <td><label for="cmbprd">Product<em style="color:#F00">*</em></label></td>  
            <td id="prd">  
            	<select class="form-control" id="cmbprd" name="cmbprd">
                <option value="">--Select Product--</option>
                	<?php //proCate($cat,$prd) ?>
                	<script type="text/javascript">
            	//view selected category's products
		  				$("#cmbcat").change(function(){
			  				var catid = $("#cmbcat").val();
							
							//alert(catid);
							if(catid!=''){
							$.get("../lib/inv_func.php?type=cmbprobycat",{catid:catid},
							function(data,status){
								if(status=="success"){
								$("#cmbprd").empty();	
			  					$("#cmbprd").append(data);
								}
							});
							}
		  				});
        			
				</script>  
              </select>
            	
            </td>
          </tr>
           <tr>
            <td><label for="txtdate">Date added<em style="color:#F00">*</em></label></td>
            <td><input class="form-control datepicker" id="txtdate" name="txtdate" value="<?php echo $date?>"/></td>
          </tr>
          <tr>
            <td><label for="txtqnty">Quantity<em style="color:#F00">*</em></label></td>
            <td><input class="form-control has-feedback" id="txtqnty" name="txtqnty" type="text" value="<?php echo $qnty?>"/></td>
          </tr>
          <tr>  
            <td><label for="txtcprice">Cost Price<em style="color:#F00">*</em></label></td>
            <td><input class="form-control" id="txtcprice" name="txtcprice" type="text" value="<?php echo $cprice?>"/></td>
            <td><label for="txtsprice">Selling Price<em style="color:#F00">*</em></label></td>
            <td><input class="form-control" id="txtsprice" name="txtsprice" type="text" value="<?php echo $sprice?>"/></td>
          </tr>
          <tr>
          	<td><label for="cmb">Supplier</label></td>
            <td><select class="form-control" id="cmbsup" name="cmbsup">
                <option value="">--Select Supplier--</option>
                <?php $sql_opt="SELECT * FROM tbl_supplier  WHERE sup_stat=1;";
                                           $result=mysqli_query($GLOBALS['conn'],$sql_opt) or die("SQL error:".mysqli_error($GLOBALS['conn']));
										   while($row=mysqli_fetch_assoc($result)){
											   $supid=$row['sup_id'];
											   $supname=$row['sup_comp'];
											   $select='';
											   if($sup==$supid){
												   $select='selected="selected"';
											   }
                                         ?>
                <option value="<?php echo $supid?>" <?php echo $select?>><?php echo $supname ?></option>
                <?php }//end while?>
              </select></td>
          </tr>
          <?php if($page_action=='add'):?>
          <tr><td><a id="showcredit" name="showcredit">Credit Purchase?</a><td></tr>
          <script type="text/javascript">
          	$('#showcredit').click(function(){
				$('#creditsview').css("display","block");
			});
          </script>
          <tr>
          	<td id="creditsview" style="display:none" colspan="2">
            	<table class="frm-tbl table table-responsive">
                	<script type="text/javascript">
                    $('#txtcprice').change(function(){
						var cprice=parseFloat($('#txtcprice').val());
						var qnty=parseInt($('#txtqnty').val());
						var tot=qnty*cprice;
						document.getElementById('txttotamnt').value=tot.toFixed(2);
					});
                    </script>
                	<tr>
                        <td><label for="txttotamnt">Total Amount<em style="color:#F00">*</em></label></td>
            			<td><input class="form-control" id="txttotamnt" name="txttotamnt" type="text" value="<?php echo $totamnt?>" readonly/></td>
                    </tr>
                	<tr>
                        <td><label for="txtpayamnt">Payed Amount<em style="color:#F00">*</em></label></td>
            			<td><input class="form-control" id="txtpayamnt" name="txtpayamnt" type="text" value="<?php echo $payamnt?>"/></td>
                    </tr>
                    <script type="text/javascript">
                    	$('#txtpayamnt').change(function(){
							var tot=parseFloat($('#txttotamnt').val());
							var payed=parseFloat($('#txtpayamnt').val());
							var credit=tot-payed;
							document.getElementById('txtcredit').value=credit.toFixed(2);
						});
                    </script>
                    <tr>
                        <td><label for="txtcredit">Credit Amount<em style="color:#F00">*</em></label></td>
            			<td><input class="form-control" id="txtcredit" name="txtcredit" type="text" value="<?php echo $credit?>" readonly/></td>
                    </tr>
                    <tr>
                        <td><label for="txtstldate">Settle Date<em style="color:#F00">*</em></label></td>
            			<td><input class="form-control datepicker2" id="txtstldate" name="txtstldate" value="<?php echo $settledate?>"/></td>
                    </tr>
                </table>
            </td>
          </tr>
          <?php endif;?>
          <tr>
            <td><label for="optstat">Status<em style="color:#F00">*</em></label></td>
            <td><input class="radio-inline" id="optstat" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>
              Enable
              <input class="radio-inline" id="optstat" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>
              Disable </td>
          </tr>
        </table>
      </div>
      <!-- end frmdiv -->
      <table class="btns tbl-horizontal  col-md-3">
        <tr>
          <td><input class="form-control btn btn-primary" type="submit" name="btnsubmit" id="btnsubmit" value="Submit" <?php if($page_action=='edit'):?> onClick="confirmUpdate('<?php echo $base_url.'inventory/add-batch.php?action=edit&amp;id='.$batchid ?>');" href="javascript:void(0);"<?php endif;?>/></td>
          <td><input class="form-control btn btn-warning" type="reset"  name="btnreset" id="btnreset" value="Reset"/></td>
        </tr>
      </table>
    </form>
    <?php endif;?>
    <!-- if($page_action == 'add' || $page_action == 'edit'): --> 
  </div>
  <!-- end inner --> 
</div>
<!-- end page-body -->
<?php include('../inc-footer.php'); ?>
</body>
</html>
<script type="text/javascript">
$( ".datepicker" ).datepicker({
		/*showOn: "button",
        buttonImage: "../images/calendarIcon.gif",
        buttonImageOnly: true,*/
		dateFormat: 'yy-mm-dd',
		maxDate: new Date() 
		});
$( ".datepicker2" ).datepicker({
		/*showOn: "button",
        buttonImage: "../images/calendarIcon.gif",
        buttonImageOnly: true,*/
		dateFormat: 'yy-mm-dd'
		});		
</script>