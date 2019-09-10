<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
include('../lib/function.php');
$meta_title = "Credit Purchases Details";
$c_page = 'purchases';
//--------------------------------------------------------
$page_action = '';
$page_title='View Credit Purchases Details';
$bid='';
$pid='';
$pname='';
$qnty='';
$settledate='';
$tot='';
$payamnt='';
$credit='';
$newcredit='';
$stat='';
$frm_err_msg='';

if(isset($_GET['action'])){
	$page_action=$_GET['action'];
	if($page_action=='edit'){
		$page_title='Edit Credit Purchases Details';	
		if(isset($_GET['id'])){
			$prid=$_GET['id'];
			$sql_all="SELECT B.batch_id,P.prd_id,P.prd_name,B.batch_qnty,B.batch_pay_amount,B.batch_credit_amount,B.batch_settle_date,B.batch_on_credit FROM tbl_products P,tbl_batch B WHERE B.prd_id=P.prd_id AND B.batch_on_credit=1;";
			$result=mysqli_query($conn,$sql_all) or die("MYSQL Error:".mysqli_error());
			$row=mysqli_fetch_assoc($result);
			$bid=$row['batch_id'];
			$pid=$row['prd_id'];
			$pname=$row['prd_name'];
			$qnty=$row['batch_qnty'];
			$settledate=$row['batch_settle_date'];
			$tot=$row['batch_pay_amount'];
			$credit=$row['batch_credit_amount'];
			$stat=$row['batch_on_credit'];
			if(isset($_POST['btnsubmit']) && ($_POST['btnsubmit'] == "Submit")){
				$stat=$_POST['optstat'];
				$newcredit=$_POST['txtnewcredit'];
				$sql_update="UPDATE tbl_batch SET batch_credit_amount='$newcredit',batch_on_credit='$stat' WHERE batch_id='$bid';";
					mysqli_query($conn,$sql_update) or die("Mysql error".mysqli_error());
					header('Location:'.$base_url.'purchases/credit_pur.php?id='.$bid.'&s=1');	
			}
		}//isset id
	}//edit action
	
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
                 <?php if($page_action == 'edit'): ?>
                <div class="page-top-action pull-right"><a class="btn btn-primary" href="<?php echo $base_url?>purchases/credit_pur.php">View Credit Purchases</a></div>
                <?php endif;?>
    		</div><!-- end page-title -->
            <?php if($page_action == ''): ?>
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
                        	<th>Batch ID</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Credit Amount</th>
                            <th>Settling Date</th>
                            <th>Settle status</th>
                            <th></th>
                        </thead>
                        <tbody>
                        <?php $sql_select="SELECT B.batch_id,P.prd_id,P.prd_name,B.batch_qnty,B.batch_pay_amount,B.batch_credit_amount,B.batch_settle_date,B.batch_on_credit FROM tbl_products P,tbl_batch B WHERE B.prd_id=P.prd_id AND B.batch_on_credit=1;";
							  $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error());
							  while($row=mysqli_fetch_assoc($result)){
								  
						?>	<tr>
                        	<td><?php echo $bid=$row['batch_id'];?></td>
                        	<td><?php echo $pid=$row['prd_id'];?></td>
                        	<td><?php echo $pname=$row['prd_name'];?></td>
                            <td><?php echo $qnty=$row['batch_qnty'];?></td>
                            <td><?php echo $tot=$row['batch_pay_amount'];?></td>
                            <td><?php echo $credit=$row['batch_credit_amount'];?></td>
                            <td><?php echo $settledate=$row['batch_settle_date'];?></td>
                            <td><?php $stat=$row['batch_on_credit'];?>
                            <?php if($stat=='1')
									$stat='On credit';
								  elseif($stat=='0')
								  $stat='Settled';
								  echo $stat;
							?>
                            
							</td>
                            <td>
                        <a class="glyphicon glyphicon-download-alt" href="<?php echo $base_url ?>purchases/credit_pur.php?action=edit&id=<?php echo $bid ?>" id="<?php echo $prid?>" title="Update">UpdateSettlement</a>
                        	</td>
                            <td>
                        	</td>
                            </tr>
                            <?php }// close while loop ?>
                        </tbody>
                    </table>    
                    </div><!-- end frmdiv -->
                	<?php elseif($page_action=='edit'):?>
                 	<form class="frm form-horizontal" action="<?php echo $base_url.'purchases/credit_pur.php?action=edit&id='.$_GET['id']?>" name="frmexp" method="post">
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
                            	<td><label for="txtbid">Batch ID</label></td>
                                <td><input class="form-control" id="txtbid" name="txtbid" type="text" value="<?php echo $bid?>" readonly/></td>
                            </tr>
                             <tr>
                            	<td><label for="txtpid">Product ID</label></td>
                                <td><input class="form-control" id="txtpid" name="txtpid" type="text" value="<?php echo $pid?>" readonly/></td>   
                            </tr>
                            <tr>
                            	<td><label for="txtpname">Product Name</label></td>
                                <td><input class="form-control" id="txtpname" name="txtpname" type="text" value="<?php echo $pname?>" readonly/></td>   
                            </tr>
                            <tr>
                            	<td><label for="txtqnty">Quantity</label></td>
                                <td><input class="form-control" id="txtqnty" name="txtqnty" type="text" value="<?php echo $qnty?>" readonly/></td>   
                            </tr>
                            <tr>
                            	<td><label for="txtdate">Settling Date</label></td>
                                <td><input class="form-control" id="txtdate" name="txtdate" type="text" value="<?php echo $settledate?>" readonly/></td>   
                            </tr>
                            <tr>
                            	<td><label for="txttotamnt">Total Amount</label></td>
            					<td><input class="form-control" id="txttotamnt" name="txttotamnt" type="text" value="<?php echo $tot?>" readonly/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtcredit">Credit Amount</label></td>
            					<td><input class="form-control" id="txtcredit" name="txtcredit" type="text" value="<?php echo $credit?>" readonly/></td>
                            </tr>
                            <tr>
                            	<td><label for="txtpayamnt">Settled Amount<em style="color:#F00">*</em></label></td>
            					<td><input class="form-control" id="txtpayamnt" name="txtpayamnt" type="text" value="<?php echo $payamnt?>"/></td>
                            </tr>
                            <script type="text/javascript">
                    			$('#txtpayamnt').change(function(){
									var credit=parseFloat($('#txtcredit').val());
									var payed=parseFloat($('#txtpayamnt').val());
									var newcredit=credit-payed;
									document.getElementById('txtnewcredit').value=newcredit.toFixed(2);
								});
                    </script>
                             <tr>
                            	<td><label for="txtnewcredit">New Credit Amount</label></td>
            					<td><input class="form-control" id="txtnewcredit" name="txtnewcredit" type="text" value="<?php echo $newcredit?>" readonly/></td>
                            </tr>
							<tr>
                                <td><label for="optstat">Settle Status<em style="color:#F00">*</em>&nbsp;&nbsp;<span style="color:#00f;font-size:x-small;">Please set the status if credit Settled</span></label></td>
                                <td><input class="radio-inline" id="optstat" name="optstat" type="radio" value="1" <?php if($stat=='1'):?>checked='checked'<?php endif ?>checked/>On Credit
                                <input class="radio-inline" id="optstat" name="optstat" type="radio" value="0" <?php if($stat=='0'):?>checked='checked'<?php endif ?>/>Settled
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
        </div><!-- end container inner -->
</div><!-- end page body container fluid -->            
<?php include('../inc-footer.php'); ?>
</body>
</html>