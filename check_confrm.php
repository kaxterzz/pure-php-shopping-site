<?php 
$meta_title='Checkout Details';
$c_page = 'checkout';
include('inc_head.php');
session_start();
$session_id = session_id();
$msg='';
$qnty='';
$totprice='';
$subtot='';
$shipcost='';
$nettot='';
$card_hold_name='';
$card_no='';
$card_type='';
$exp_date='';
$cvc='';
?>
</head>
<body>
<?php include('inc_header.php');?>
<div class="container items_main">
	<div id="msg" class=""><?php if($msg!=''){
					 echo '<p class="alert alert-warning">No Items in the cart</p>';
					 } ?></div>
	<div class="catr-itms container col-md-6 ">
    	<table class="table table-responsive table-hover">
        	<thead>
            	<tr class="cart-menu bg-info" >
            		<th class="pic col-md-3">Item</th>
                    <th class="desc col-md-4"></th>
                    <th class="price col-md-2" style="text-align:right">Price (Rs.)</th>
                    <th class="qnty col-md-1" style="text-align:center">Quantity</th>
                    <th class="tot col-md-2" style="text-align:right">Total (Rs.)</th>   
                </tr>
            </thead>
            <tbody id="cart_tbl">
            <?php 
			if(!isset($_SESSION['customer'])|| !isset($_SESSION['customer']['cid']) ){ 
				//$session_id = session_id();
				$sql = "SELECT * FROM  tbl_cart WHERE session_id = '$session_id'";
				$rs = mysqli_query($GLOBALS['conn'],$sql) or die(mysqli_error($GLOBALS['conn']));
				$rows=mysqli_num_rows($rs);
				if($rows>0){
					while($row = mysqli_fetch_assoc($rs)){
					$pro_id = $row['prd_id'];
					$qnty  = $row['cart_qnty'];
				//get date from prduct table
					//select the product details from products table
					$sql1="SELECT prd_name,brand_id,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE prd_id='$pro_id';";
					$res1 = mysqli_query($GLOBALS['conn'],$sql1) or die(mysqli_error($GLOBALS['conn']));
					$row1=mysqli_fetch_assoc($res1);
					$prd_name=$row1['prd_name'];
					$brand=$row1['brand_id'];
					$img=$row1['prd_img_path'];
					$stockqnty=$row1['prd_tot_qnty'];
					$price=$row1['prd_price'];
					$sql2="SELECT brand_name FROM tbl_brand WHERE brand_id='$brand';";
					$res2 = mysqli_query($GLOBALS['conn'],$sql2) or die(mysqli_error($GLOBALS['conn']));
					$row2=mysqli_fetch_assoc($res2);
					$bname=$row2['brand_name'];
			
					echo'<tr>';
						echo'<td class="pic"><img class="img-responsive" src="'.$base_url.'/admin/images/products/'.$img.'"/></td>';
						echo'<td class="desc">
						<table class="tbl tbl-responsive">
							<tr>
								<td><label for="prdid">Product ID:</label></td>
								<td><p id="prdid" name="prdid">'.$pro_id.'</p></td>
							</tr>
							<tr>
								<td><label for="prdname">Product Name:</label></td>
								<td><p id="prdname" name="prdname">'.$prd_name.'</p></td>
							</tr>
							<tr>
								<td><label for="prdbrand">Brand:</label></td>
								<td><p id="prdbrand" name="prdbrand">'.$bname.'</p></td>
							</tr>
							<tr>
								<td><label id="stock" name="stock"><span style="color:#060">IN STOCK '.$stockqnty.'</span></label>
							</tr>
						</table>
						</td>';
						echo'<td class="price" style="text-align:right">'.$price.'</td>';
						echo'<td class="qnty" style="text-align:center">'.$qnty.'</td>';
								  
								  $totprice=number_format((double)((int)$qnty*(double)$price),2,'.','');
								  $subtot=number_format((double)((double)$subtot+(double)$totprice),2,'.','');
								  $shipcost=10.00;
						echo'<td class="tot" style="text-align:right">'.$totprice.'</td>';
				   	echo'</tr>';
					}//end while 
					$sql2="SELECT ship_cost FROM tbl_ship_info S,tbl_province P WHERE S.ship_prov=P.prov_id AND S.session_id='$session_id'";
					$rs = mysqli_query($GLOBALS['conn'],$sql2) or die(mysqli_error($GLOBALS['conn']));
					$row = mysqli_fetch_assoc($rs);
					$shipcost=$row['ship_cost'];
					$nettot=number_format((double)((double)$subtot+(double)$shipcost),2,'.','');
					?>
                    </tbody>
					<tfoot id="cart_calc" class="bg-info">
                	<tr>
                    	<th colspan="4" style="text-align:right" id="txtgtot">Sub Total (Rs)</th>
                        <td><?php echo $subtot ?></td>
                    </tr>
                    <tr>
                    	<th colspan="4" style="text-align:right" id="txtship">Shipping Cost (Rs)</th>
                        <td><?php echo $shipcost ?></td>
                    </tr>
                    <tr>
                    	<th colspan="4" style="text-align:right" id="txtntot">Net Total (Rs)</th>
                        <td><?php echo $nettot ?></td>
                    </tr>
                </tfoot>
                
                 
		<?php }
				else{ 
					$msg='No Items in the cart';
					//echo'No Items in the cart';	
				}?>
				 </table>
   			 </div><!-- cart items -->
			<div class="container-fluid col-md-offset-3">
	<div id="msg"></div>
	<form class="frm form-horizontal" action="" name="frmcheck" method="post">

	<div class="pay-form container col-md-8">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title"><h4>Payment Gateway</h4></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
            	<div id="msgb"></div>
             	<div class="form-horizontal" role="form" id="frmbill">
                    	<div class="form-group" >
                        	<label for="txtcard_hold_name" class="col-sm-3 control-label">Card Hold Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtcard_hold_name" name="txtcard_hold_name" placeholder="" class="form-control" value="<?php echo $card_hold_name ?>"/>
                       		 </div>   
                        </div><!-- end card hold name grp -->
                        <div class="form-group" >
                        	<label for="txtcard_no" class="col-sm-3 control-label">Card No<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtcard_no" name="txtcard_no" placeholder="" class="form-control" value="<?php echo $card_no ?>"/>
                       		 </div>   
                        </div><!-- end card no grp -->
                        <div class="form-group" >
                        	<label for="txtcard_type" class="col-sm-3 control-label">Card Type<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<select class="form-control" id="cardType" name="cardType">
                                    	<option value="">--Select Cardtype--</option>
                                    	<option value="visa">Visa</option>
                                      <!--<option value="amex">American Express</option> 
                                      <option value="jcb">JCB</option> -->
                                      <option value="master">MasterCard</option>
                                     
                                    </select>
                       		 </div>   
                        </div><!-- end card type grp -->
                        <div class="form-group" >
                        	<label for="txtexpenses_date" class="col-sm-3 control-label">Expire Date<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<!--<input type="text" id="txtexp_date" name="txtexp_date" placeholder="" class="form-control monthpicker" value="<?php //echo $exp_date ?>"/>-->
                                   <select name="ccExpM" id="ccExpM" class="form-control"> 
                                    	<option value="">--Select Month--</option>
									<?php                                     
                                    for($i =1; $i < 13; $i++)  
                                    
                                    { echo '<option value="'.$i.'">' . $i . '</option>'; }  
                                    
                                    ?>                                      
                                    </select>  
                                    <select name="ccExpY" id="ccExpY" class="form-control">
                                    	<option value="">--Select Year--</option>
								   <?php                                  
                                     for($i = 2019; $i < 2030; $i++)     
                                
                                     { echo '<option value="'.$i.'">' . $i . '</option>'; }
                                   ?> 
                                   </select>
                       		 </div>   
                        </div><!-- end expenses grp -->
                        <div class="form-group" >
                        	<label for="txtcvc" class="col-sm-3 control-label">CVC<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="password" id="txtcvc" name="txtcvc" placeholder="" class="form-control" value="<?php echo $cvc ?>"/>
                       		 </div>   
                        </div><!-- end cvc grp -->
                        <div class="form-group" >
                        	<label for="txtamount" class="col-sm-3 control-label">Amount<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtamount" name="txtamount" placeholder="" class="form-control" value="<?php echo $nettot ?>"/>
                       		 </div>   
                        </div><!-- end amount grp -->
                      </div><!-- end form horizontal -->   
            </div><!-- panel-body --> 
            <div class="panel-footer">
            	<table class"btns tbl-horizontal table-responsive">
            	<tr>
          		 	<td>
                    <input name="action" type="hidden" value="pay">
                    <button type="button" class="btn btn-primary" id="btnpay" name="btnpay" onClick="placeOrder_Sess();">Pay <span class="glyphicon glyphicon-ok"></span></button></button></td>
                    <td>&nbsp;</td>
                    <td><a class="btn btn-warning" role="button" id="btncancel" name="btncancel" href="cart.php">Cancel <span class="glyphicon glyphicon-remove"></span></a></td>
                 	
          		</tr>
             </table>  
       </form> 
            </div><!-- panel-footer -->
         </div><!-- main panel -->    
    </div><!-- pay-form -->
</div><!-- main container --> 	
	<?php 	}
			elseif(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid'])){
				$cid=$_SESSION['customer']['cid'];
				$sql = "SELECT * FROM  tbl_cart WHERE cus_id = '$cid'";
				$rs = mysqli_query($GLOBALS['conn'],$sql) or die(mysqli_error($GLOBALS['conn']));
				$rows=mysqli_num_rows($rs);
				if($rows>0){
				while($row = mysqli_fetch_assoc($rs)){
					$pro_id = $row['prd_id'];
					$qnty  = $row['cart_qnty'];
					//select the product details from products table
					$sql1="SELECT prd_name,brand_id,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE prd_id='$pro_id';";
					$res1 = mysqli_query($GLOBALS['conn'],$sql1) or die(mysqli_error($GLOBALS['conn']));
					$row1=mysqli_fetch_assoc($res1);
					$prd_name=$row1['prd_name'];
					$brand=$row1['brand_id'];
					$img=$row1['prd_img_path'];
					$stockqnty=$row1['prd_tot_qnty'];
					$price=$row1['prd_price'];
					$sql2="SELECT brand_name FROM tbl_brand WHERE brand_id='$brand';";
					$res2 = mysqli_query($GLOBALS['conn'],$sql2) or die(mysqli_error($GLOBALS['conn']));
					$row2=mysqli_fetch_assoc($res2);
					$bname=$row2['brand_name'];
			
            	echo'<tr>';
                	echo'<td class="pic"><img class="img-responsive" src="'.$base_url.'/admin/images/products/'.$img.'"/></td>';
                    echo'<td class="desc">
					<table class="tbl tbl-responsive">
						<tr>
							<td><label for="prdid">Product ID:</label></td>
                            <td><p id="prdid" name="prdid">'.$pro_id.'</p></td>
						</tr>
						<tr>
							<td><label for="prdname">Product Name:</label></td>
                            <td><p id="prdname" name="prdname">'.$prd_name.'</p></td>
						</tr>
						<tr>
							<td><label for="prdbrand">Brand:</label></td>
                            <td><p id="prdbrand" name="prdbrand">'.$bname.'</p></td>
						</tr>
						<tr>
							<td><label id="stock" name="stock"><span style="color:#060">INSTOCK '.$stockqnty.'</span></label>
						</tr>
					</table>
					</td>';
                    echo'<td class="price" style="text-align:right">'.$price.'</td>';
                    echo'<td class="qnty" style="text-align:center">'.$qnty.'</td>';
							  $totprice=number_format((double)((int)$qnty*(double)$price),2,'.','');
							  $subtot=number_format((double)((double)$subtot+(double)$totprice),2,'.','');
							  $shipcost=10.00;
							  
                    echo'<td class="tot" style="text-align:right">'.$totprice.'</td>';
               echo'</tr>';
            	}//end whle 
					$sql2="SELECT ship_cost FROM tbl_ship_info S,tbl_province P WHERE S.ship_prov=P.prov_id AND S.cus_id='$cid'";
					$rs = mysqli_query($GLOBALS['conn'],$sql2) or die(mysqli_error($GLOBALS['conn']));
					$row = mysqli_fetch_assoc($rs);
					$shipcost=$row['ship_cost'];
					$nettot=number_format((double)((double)$subtot+(double)$shipcost),2,'.','');
				?>
                </tbody>
				<tfoot id="cart_calc" class="bg-info">
                	<tr>
                    	<th colspan="4" style="text-align:right">Sub Total (Rs)</th>
                        <td style="text-align:right" id="txtgtot"><?php echo $subtot ?></td>
                    </tr>
                    <tr>
                    	<th colspan="4" style="text-align:right">Shipping Cost (Rs)</th>
                        <td style="text-align:right" id="txtship"><?php echo $shipcost ?></td>
                    </tr>
                    <tr>
                    	<th colspan="4" style="text-align:right">Net Total (Rs)</th>
                        <td style="text-align:right" id="txtntot"><?php echo $nettot ?></td>
                    </tr>
                </tfoot>
	<?php	}
			else{ 
					$msg='No Items in the cart';
					//echo'No Items in the cart';	
				}
	 	?>   
        </table>
    </div><!-- cart items -->
    <div class="container-fluid col-md-offset-3">
	<div id="msg"></div>
	<form class="frm form-horizontal" action="<?php echo $base_url.'check_confrm.php'?>" name="frmcheck" method="post">

	<div class="pay-form container col-md-8">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<div class="panel-title"><h4>Payment Gateway</h4></div><!-- panel-title -->
            </div><!-- panel-header-->
        	<div class="panel-body">
            	<div id="msgb"></div>
             	<div class="form-horizontal" role="form" id="frmbill">
                    	<div class="form-group" >
                        	<label for="txtcard_hold_name" class="col-sm-3 control-label">Card Hold Name<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtcard_hold_name" name="txtcard_hold_name" class="form-control" value="<?php echo $card_hold_name ?>"/>
                       		 </div>   
                        </div><!-- end card hold name grp -->
                        <div class="form-group" >
                        	<label for="txtcard_no" class="col-sm-3 control-label">Card No<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtcard_no" name="txtcard_no" class="form-control" value="<?php echo $card_no ?>"/>
                       		 </div>   
                        </div><!-- end card no grp -->
                        <div class="form-group" >
                        	<label for="txtcard_type" class="col-sm-3 control-label">Card Type<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<select class="form-control" id="cardType" name="cardType">
                                    	<option value="">--Select Cardtype--</option>
                                    	<option value="visa">Visa</option>
                                      <!--<option value="amex">American Express</option> 
                                      <option value="jcb">JCB</option> -->
                                      <option value="master">MasterCard</option>
                                     
                                    </select>
                       		 </div>   
                        </div><!-- end card type grp -->
                        <div class="form-group" >
                        	<label for="txtexpenses_date" class="col-sm-3 control-label">Expire Date<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<!--<input id="txtexp_date" name="txtexp_date" placeholder="" class="form-control" value="<?php //echo $exp_date ?>"/>-->
                                    <select name="ccExpM" id="ccExpM" class="form-control"> 
                                    	<option value="">--Select Month--</option>
									<?php                                     
                                    for($i =1; $i < 13; $i++)  
                                    
                                    { echo '<option value="'.$i.'">' . $i . '</option>'; }  
                                    
                                    ?>                                      
                                    </select>  
                                    <select name="ccExpY" id="ccExpY" class="form-control">
                                    	<option value="">--Select Year--</option>
								   <?php                                  
                                     for($i = 2019; $i < 2030; $i++)     
                                
                                     { echo '<option value="'.$i.'">' . $i . '</option>'; }
                                   ?> 
                                   </select>
                       		 </div>   
                        </div><!-- end expenses grp -->
                        <div class="form-group" >
                        	<label for="txtcvc" class="col-sm-3 control-label">CVC<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="password" id="txtcvc" name="txtcvc" class="form-control" value="<?php echo $cvc ?>"/>
                       		 </div>   
                        </div><!-- end cvc grp -->
                        <div class="form-group" >
                        	<label for="txtamount" class="col-sm-3 control-label">Amount<em style="color:#F00">*</em></label>
                        	<div class="col-sm-7">   
                            		<input type="text" id="txtamount" name="txtamount" class="form-control" value="<?php echo $nettot ?>"/>
                       		 </div>   
                        </div><!-- end amount grp -->
                      </div><!-- end form horizontal -->   
            </div><!-- panel-body --> 
            <div class="panel-footer">
            	<table class"btns tbl-horizontal table-responsive">
            	<tr>
          		 	<td>
                    <input name="action" type="hidden" value="pay">
                    <button type="button" class="btn btn-primary" id="btnpay" name="btnpay" onClick="placeOrder_Cus();">Pay <span class="glyphicon glyphicon-ok"></span></button></td>
                    <td>&nbsp;</td>
                    <td><a class="btn btn-warning" role="button" id="btncancel" name="btncancel" href="cart.php">Cancel <span class="glyphicon glyphicon-remove"></span></a></td>
                 	
          		</tr>
             </table>  
       </form> 
            </div><!-- panel-footer -->
         </div><!-- main panel -->    
    </div><!-- pay-form -->
</div><!-- main container -->
<?php	}
		?>  
   </div><!-- container items_main --> 
    <?php include('admin/inc-footer.php'); ?>
 </body>
</html>   
<script type="text/javascript">
function placeOrder_Cus(){
	var cardholder=document.getElementById('txtcard_hold_name').value;//alert(cardholder);
	var cardno=document.getElementById('txtcard_no').value;
	var cardtype=document.getElementById('cardType').value;//alert(cardtype);
	var ccExpM=document.getElementById('ccExpM').value;
	var ccExpY=document.getElementById('ccExpY').value;
	var cvc=document.getElementById('txtcvc').value;
		var arr = new Array();
		var invtable = document.getElementById("cart_tbl");  
		var row_count = invtable.rows.length; 
		var gtot = document.getElementById("txtgtot").innerHTML;
		var ship = document.getElementById("txtship").innerHTML;
		var ntot = document.getElementById("txtntot").innerHTML;
		i = 0;
		while(i<row_count){
			var proid = invtable.rows[i].childNodes[1].childNodes[1].childNodes[1].childNodes[0].childNodes[3].childNodes[0].innerHTML;
			var uprice = invtable.rows[i].childNodes[2].innerHTML; 
			var qnty = invtable.rows[i].childNodes[3].innerHTML; 
			var tot = invtable.rows[i].childNodes[4].innerHTML;
			arr[i] = Array(proid,uprice,qnty,tot)
			i++;
		}	//alert(arr);
		
		
		$.post("lib/site_functions.php?type=addinv_cus",{gtot:gtot,ship:ship,ntot:ntot,parr:arr,cardholder:cardholder,cardno:cardno,cardtype:cardtype,ccExpM:ccExpM,ccExpY:ccExpY,cvc:cvc},function(data,status){
			if(status=="success"){
				//alert(data);
				var arr = data.split("|");
				if(arr[0]==1){
					$("#msg").css("display","block");
					$("#msg").html("<p class='alert alert-success'>"+arr[1]+"</p>");
					setTimeout(function(){window.location.href="order_final.php?id="+arr[2]},500);
				}
				else if(arr[0]==2){
					$("#msg").css("display","block");
					$("#msg").html("<p class='alert alert-danger'>"+arr[1]+"</p>");
				}
				else if(arr[0]==3 || arr[0]==4 || arr[0]==5 || arr[0]==6 || arr[0]==7 || arr[0]==8 || arr[0]==9 || arr[0]==10 || arr[0]==11){
					$("#msgb").css("display","block");
					$("#msgb").html("<p class='alert alert-danger'>"+arr[1]+"</p>");	
				}
				else{
					$("#msg").css("display","block");
					$("#msg").html("<p class='alert alert-danger'>Something wrong in php,please contact developer</p>");
				}
			}
		});
}

function placeOrder_Sess(){
	var cardholder=document.getElementById('txtcard_hold_name').value;//alert(cardholder);
	var cardno=document.getElementById('txtcard_no').value;
	var cardtype=document.getElementById('cardType').value;//alert(cardtype);
	var ccExpM=document.getElementById('ccExpM').value;
	var ccExpY=document.getElementById('ccExpY').value;
	var cvc=document.getElementById('txtcvc').value;
		var arr = new Array();
		var invtable = document.getElementById("cart_tbl");  
		var row_count = invtable.rows.length; 
		var gtot = document.getElementById("txtgtot").innerHTML;
		var ship = document.getElementById("txtship").innerHTML;
		var ntot = document.getElementById("txtntot").innerHTML;
		i = 0;
		while(i<row_count){
			var proid = invtable.rows[i].childNodes[1].childNodes[1].childNodes[1].childNodes[0].childNodes[3].childNodes[0].innerHTML;
			var uprice = invtable.rows[i].childNodes[2].innerHTML; 
			var qnty = invtable.rows[i].childNodes[3].innerHTML; 
			var tot = invtable.rows[i].childNodes[4].innerHTML;
			arr[i] = Array(proid,uprice,qnty,tot)
			i++;
		}	//alert(arr);
		
		
		$.post("lib/site_functions.php?type=addinv_sess",{gtot:gtot,ship:ship,ntot:ntot,parr:arr,cardholder:cardholder,cardno:cardno,cardtype:cardtype,ccExpM:ccExpM,ccExpY:ccExpY,cvc:cvc},function(data,status){
			if(status=="success"){
				var arr = data.split("|");
				if(arr[0]==1){
					$("#msg").css("display","block");
					$("#msg").html("<p class='alert alert-success'>"+arr[1]+"</p>");
					setTimeout(function(){window.location.href="order_final.php?id="+arr[2]},500);
				}
				else if(arr[0]==2){
					$("#msg").css("display","block");
					$("#msg").html("<p class='alert alert-danger'>"+arr[1]+"</p>");
				}
				else if(arr[0]==3 || arr[0]==4 || arr[0]==5 || arr[0]==6 || arr[0]==7 || arr[0]==8 || arr[0]==9 || arr[0]==10 || arr[0]==11){
					$("#msgb").css("display","block");
					$("#msgb").html("<p class='alert alert-danger'>"+arr[1]+"</p>");	
				}
				else{
					$("#msg").css("display","block");
					$("#msg").html("<p class='alert alert-danger'>Something wrong in php,please contact developer</p>");
				}
			}
		});
}
</script> 