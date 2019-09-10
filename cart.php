<?php 
$meta_title='Shopping Cart Details';
$c_page = 'cart';

include('inc_head.php');
session_start();
//session_destroy();
$session_id=session_id();
$msg='';
$qnty='';
$totprice='';
$subtot='';
$shipcost='';
$nettot='';
$conn = $conn;
?>
</head>

<body>

<?php include('inc_header.php');?>
<div class="container cart_main">
	<div id="msg" class=""><?php if($msg!=''){
					 echo '<p class="alert alert-warning">No Items in the cart</p>';
					 } ?></div>
	<div class="catr-itms container col-md-8 pull-left">
    	<table class="table table-rsponsive table-hover">
        	<thead>
            	<tr class="cart-menu info" >
            		<th class="pic col-md-2">Item</th>
                    <th class="desc col-md-4"></th>
                    <th class="price col-md-2">Price (Rs.)</th>
                    <th class="qnty col-md-1">Quantity</th>
                    <th class="tot col-md-2">Total (Rs.)</th>
                    <th class="remv_upd col-md-1"></th>
                   
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
						echo'<td class="price">'.$price.'</td>';
						echo'<td class="qnty">
							<select class="form-control" id="cmbqnty" data-id="'.$pro_id.'" name="cmbqnty">';
								for($i=1;$i<=$stockqnty;$i++){ 
									$select='';
									if($qnty==$i)
									$select='selected="selected"';
								  echo'<option value="'.$i.'" '.$select.'>'.$i.'</option>'; 
								 }
								  echo'</select></td>';
								  
								  $totprice=number_format((double)((int)$qnty*(double)$price),2,'.','');
								  $subtot=number_format((double)((double)$subtot+(double)$totprice),2,'.','');
								  $shipcost=10.00;
								  $nettot=number_format((double)((double)$subtot+(double)$shipcost),2,'.','');
						echo'<td class="tot">'.$totprice.'</td>';
						echo'<td class="remv_upd"> <span class="glyphicon glyphicon-download-alt" id="'.$pro_id.'" title="update" onclick="supdateqnty(this);"></span> &nbsp; <span class="glyphicon glyphicon-remove" id="'.$pro_id.'" title="remove" onclick="sremoverow(this);"></span></td>';
				   	echo'</tr>';
					}
				}
				else{ 
					$msg='No Items in the cart';
					//echo'No Items in the cart';	
				}
			}
			elseif(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid'])){
				$cid=$_SESSION['customer']['cid'];
				$sql = "SELECT * FROM  tbl_cart WHERE cus_id = '$cid'";
				$rs = mysqli_query($GLOBALS['conn'],$sql) or die(mysqli_error($GLOBALS['conn']));
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
                    echo'<td class="price">'.$price.'</td>';
                    echo'<td class="qnty">
						<select class="form-control" id="cmbqnty" data-id="'.$pro_id.'" name="cmbqnty">';
                            for($i=1;$i<=$stockqnty;$i++){ 
								$select='';
								if($qnty==$i)
								$select='selected="selected"';
                              echo'<option value="'.$i.'" '.$select.'>'.$i.'</option>'; 
							 }
                              echo'</select></td>';
							  $totprice=number_format((double)((int)$qnty*(double)$price),2,'.','');
							  $subtot=number_format((double)((double)$subtot+(double)$totprice),2,'.','');
							  $shipcost=10.00;
							  $nettot=number_format((double)((double)$subtot+(double)$shipcost),2,'.','');
                    echo'<td class="tot">'.$totprice.'</td>';
                    echo'<td class="remv_upd"><span class="glyphicon glyphicon-download-alt" id="'.$pro_id.'" title="update" onclick="ipdateqnty(this);"></span> &nbsp; <span class="glyphicon glyphicon-remove" id="'.$pro_id.'" title="remove" onclick="iremoverow(this);"></span></td>';
               echo'</tr>';
            	}//end whle
			}?>    
                
            </tbody>
        </table>
    </div><!-- cart items -->
    <?php if(!isset($_SESSION['customer'])|| !isset($_SESSION['customer']['cid']) ){ ?>
	<div class="tot-sec container col-md-4 pull-right">
    	<div class="panel panel-default">
        	<div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                          <div class="col-md-8"><b>Sub Total (Rs)</b></div>
                          <div class="col-md-4" id="subtot" style="text-align:right"><?php echo $subtot ?></div>        
                    </div>
                </div> 
                <div class="panel panel-default">
                    <div class="panel-body">
                          <div class="col-md-8"><b>Shipping cost (Rs) (minimum Rs 10)</b></div>
                          <div class="col-md-4" id="shipcost" style="text-align:right"><?php echo number_format((double)$shipcost,2,'.','') ?></div>        
                    </div>
                </div>  
                <div class="panel panel-default">
                    <div class="panel-body">
                          <div class="col-md-8"><b>Total (Rs)</b></div>
                          <div class="col-md-4" id="nettot" style="text-align:right"><?php echo $nettot ?></div>        
                    </div>
                </div>
                
                	<table class="btns tbl-horizontal table-responsive">
            			<tr>
                            <td><a class="btn btn-primary" type="button" name="btncheck" id="btncheck" href="checkout_bill_ship_info.php" value="">Checkout <span class="glyphicon glyphicon-check"></span></a></td>
                            <td><a class="btn btn-warning" role="button" id="btnshop" name="btnshop" href="index.php">Continue shopping <span class="glyphicon glyphicon-shopping-cart"></span></a></td>
                       </tr>
        </table> 
            </div><!-- panel-body --> 
         </div><!-- main panel -->          
    </div><!-- total section -->
	<?php	} 
		  elseif(isset($_SESSION['customer'])|| isset($_SESSION['customer']['cid']) ){?>
			 	<div class="tot-sec container col-md-4 pull-right">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                      <div class="col-md-8"><b>Sub Total (Rs)</b></div>
                                      <div class="col-md-4" id="subtot" style="text-align:right"><?php echo $subtot ?></div>        
                                </div>
                            </div> 
                            <div class="panel panel-default">
                                <div class="panel-body">
                                      <div class="col-md-8"><b>Shipping cost (Rs)(minimum Rs 10)</b></div>
                                      <div class="col-md-4" id="shipcost" style="text-align:right"><?php echo number_format((double)$shipcost,2,'.','') ?></div>        
                                </div>
                            </div>  
                            <div class="panel panel-default">
                                <div class="panel-body">
                                      <div class="col-md-8"><b>Total (Rs)</b></div>
                                      <div class="col-md-4" id="nettot" style="text-align:right"><?php echo $nettot ?></div>        
                                </div>
                            </div>
                            
                                <table class="btns tbl-horizontal table-responsive">
                                    <tr>
                                        <td><a class="btn btn-primary" role="button" name="btncheck" id="btncheck" href="checkout_bill_ship_info.php" value="">Checkout <span class="glyphicon glyphicon-check"></span></a></td>
                                        <td><a class="btn btn-warning" role="button" id="btnshop" name="btnshop" href="index.php">Continue shopping <span class="glyphicon glyphicon-shopping-cart"></span></a></td>
                                   </tr>
                    </table> 
                        </div><!-- panel-body --> 
                     </div><!-- main panel -->          
    		</div><!-- total section --> 
	<?php	}//end elseif	 ?>
</div><!-- main container -->
 <?php include('admin/inc-footer.php'); ?>  
</body>
</html>
<script type="text/javascript">

function supdateqnty(obj){ //updating item of cart by session
	var pid = obj.id;
	$.jAlert({'type':'confirm',
	'title':'Confirmation',
	'theme':'yellow',
	'confirmQuestion': 'Are you sure you want to Update the Quantity of '+pid+'?',
	'onConfirm':function(){
			sess_setQty(obj);
		}
	});
}

function sess_setQty(obj){
	var pid=obj.id;
	var qnty=obj.parentNode.parentNode.cells[3].childNodes[1].value;
	var price=obj.parentNode.parentNode.cells[2].innerHTML;
	
	$.get("lib/site_functions.php?type=updqnty_sess",{pid:pid,qnty:qnty,price:price},function(data,status){
		if(status=='success'){
			//alert(data);
			var dataArr = data.split("|");
			if(dataArr[0]=='1'){
				var totprice=dataArr[1];
				obj.parentNode.parentNode.cells[4].innerHTML=totprice;
				
				var mytable = document.getElementById("cart_tbl");
				var count=mytable.rows.length;
				var arr=new Array();//alert(count);
				var i=0;
				while(i<count){
					var tot=mytable.rows[i].cells[4].innerHTML;
					arr[i] =Array(tot);
					i++;
				}
				var ship=document.getElementById('shipcost').innerHTML;//alert(ship);
				$.get("lib/site_functions.php?type=calSubtotNettot_cus",{ship:ship,darr:arr},function(data,status){
					if(status=='success'){
						//alert(data);
						var dataArr = data.split("|");
						if(dataArr[0]=='1'){
							var subtot=dataArr[1];
							var nettot=dataArr[2];
							document.getElementById('subtot').innerHTML=subtot;
							document.getElementById('nettot').innerHTML=nettot;
							
							$("#msg").css("display","block");
							$("#msg").html('<p class="alert alert-success">Cart Qunatity of '+pid+' updated successfully</p>');
						}
					}
				});
					
			}
		}
	});	
}
function sremoverow(obj){ // removing item of cart made by session
	var pid = obj.id;
	$.jAlert({'type':'confirm',
	'title':'Confirmation',
	'theme':'yellow',
	'confirmQuestion': 'Are you sure you want to Delete Product '+pid+'?',
	'onConfirm':function(){
			sess_delItem(obj);
		}
	});
}

function sess_delItem(obj){
	var index = obj.parentNode.parentNode.rowIndex;
	var pid=obj.id;
	
		var tot=obj.parentNode.parentNode.cells[4].innerHTML;
		var subtot=document.getElementById('subtot').innerHTML;
		var ship=document.getElementById('shipcost').innerHTML;
		$.get("lib/site_functions.php?type=remvcartitem_sess",{pid:pid},function(data,status){
			if(status=='success'){
				if(data=='1'){
					var mytable = document.getElementById("cart_tbl");
					mytable.deleteRow(index-1);
					$.get("lib/site_functions.php?type=caltotonremv",{tot:tot,subtot:subtot,ship:ship},function(data,status){
						if(status=='success'){
							//alert(data);
							var dataArr = data.split("|");
							if(dataArr[0]=='1'){
								var subtot=dataArr[1];
								var nettot=dataArr[2];
								document.getElementById('subtot').innerHTML=subtot;
								document.getElementById('nettot').innerHTML=nettot;
								
								$("#msg").css("display","block");
								$("#msg").html('<div class="alert alert-warning alert-dismissible">Successfully Product '+pid+' deleted from Cart</p>');
							}
						}
					});		
					
				}
			}
		});
}

function ipdateqnty(obj){ //updating item of cart by logged customer
	var pid = obj.id;
	//alert(pid);
	$.jAlert({'type':'confirm',
	'title':'Confirmation',
	'theme':'yellow',
	'confirmQuestion': 'Are you sure you want to Update the Quantity of '+pid+'?',
	'onConfirm':function(){
			logged_setQty(obj);
		}
	});
}

function logged_setQty(obj){ 
		var pid=obj.id;//updating item of cart by logged customer
		var qnty=obj.parentNode.parentNode.cells[3].childNodes[1].value;
		var price=obj.parentNode.parentNode.cells[2].innerHTML;
		//alert(qnty);
		$.get("lib/site_functions.php?type=updqnty_cus",{pid:pid,qnty:qnty,price:price},function(data,status){
			if(status=='success'){
				//alert(data);
				var dataArr = data.split("|");
				if(dataArr[0]=='1'){
					var totprice=dataArr[1];
					obj.parentNode.parentNode.cells[4].innerHTML=totprice;
					
					var mytable = document.getElementById("cart_tbl");
					var count=mytable.rows.length;
					var arr=new Array();//alert(count);
					var i=0;
					while(i<count){
						var tot=mytable.rows[i].cells[4].innerHTML;
						arr[i] =Array(tot);
						i++;
					}
					var ship=document.getElementById('shipcost').innerHTML;//alert(ship);
					$.get("lib/site_functions.php?type=calSubtotNettot_cus",{ship:ship,darr:arr},function(data,status){
						if(status=='success'){
							//alert(data);
							var dataArr = data.split("|");
							if(dataArr[0]=='1'){
								var subtot=dataArr[1];
								var nettot=dataArr[2];
								document.getElementById('subtot').innerHTML=subtot;
								document.getElementById('nettot').innerHTML=nettot;
								
								$("#msg").css("display","block");
								$("#msg").html('<p class="alert alert-success">Cart Qunatity of '+pid+' updated successfully</p>');
							}
						}
					});
					
				}
			}
		});
	
}
	
function iremoverow(obj){ // removing item of cart made by logged customer
	var pid = obj.id;
	$.jAlert({'type':'confirm',
	'title':'Confirmation',
	'theme':'yellow',
	'confirmQuestion': 'Are you sure you want to Delete Product '+pid+'?',
	'onConfirm':function(){
			logged_delItem(obj);
		}
	});
}

function logged_delItem(obj){ // removing item of cart made by logged customer
		var index = obj.parentNode.parentNode.rowIndex;
		var pid=obj.id;
		var tot=obj.parentNode.parentNode.cells[4].innerHTML;
		var subtot=document.getElementById('subtot').innerHTML;
		var ship=document.getElementById('shipcost').innerHTML;
		$.get("lib/site_functions.php?type=remvcartitem_cus",{pid:pid},function(data,status){
			if(status=='success'){
				if(data=='1'){
					var mytable = document.getElementById("cart_tbl");
					mytable.deleteRow(index-1);
					$.get("lib/site_functions.php?type=caltotonremv",{tot:tot,subtot:subtot,ship:ship},function(data,status){
						if(status=='success'){
							//alert(data);
							var dataArr = data.split("|");
							if(dataArr[0]=='1'){
								var subtot=dataArr[1];
								var nettot=dataArr[2];
								document.getElementById('subtot').innerHTML=subtot;
								document.getElementById('nettot').innerHTML=nettot;
								
								$("#msg").css("display","block");
								$("#msg").html('<div class="alert alert-warning alert-dismissible">Successfully Product '+pid+' deleted from Cart</p>');
							}
						}
					});	
					
				}
			}
		});
}
</script>