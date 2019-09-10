<?php 
session_start();
if((!isset($_SESSION['customer'])) || (!isset($_SESSION['customer']['cid']))){
	header("Location:login.php");
}
$session_id=session_id();
$meta_title='WishList Details';
$c_page = 'wishlist';
include('inc_head.php');

$msg='';
?>
</head>

<body>
<?php include('inc_header.php');?>
<div class="container">
	<div id="msg" class="alert alert-dismissible"><?php if($msg!=''){
					 echo '<p class="alert alert-warning alert-dismissible">No Items in the Wishlist</p>';
					 } ?></div>
	<div class="cart-items container">
    	<table class="table table-rsponsive table-hover">
        	<thead>
            	<tr class="cart-menu info" >
            		<th class="pic col-md-2">Item</th>
                    <th class="desc col-md-4"></th>
                    <th class="date col-md-2">Date Added</th>
                    <th class="addcart col-md-2"></th>
                    <th class="remv col-md-1"></th>
                </tr>
            </thead>
            <tbody id='wishlist_tbl'>
				<?php 
                 
					$cid=$_SESSION['customer']['cid'];
					$sql = "SELECT * FROM  tbl_wishlist WHERE cus_id= '$cid';";
					$rs = mysqli_query($GLOBALS['conn'],$sql) or die(mysqli_error($GLOBALS['conn']));
					$rows=mysqli_num_rows($rs);
					if($rows>0){
						while($row = mysqli_fetch_assoc($rs)){
						$pro_id = $row['prd_id'];
						$datetime=$row['date_time'];
						$sql1="SELECT prd_name,brand_id,prd_img_path,prd_tot_qnty FROM tbl_products WHERE prd_id='$pro_id';";
						$res1 = mysqli_query($GLOBALS['conn'],$sql1) or die(mysqli_error($GLOBALS['conn']));
						$row1=mysqli_fetch_assoc($res1);
						$prd_name=$row1['prd_name'];
						$brand=$row1['brand_id'];
						$img=$row1['prd_img_path'];
						$stockqnty=$row1['prd_tot_qnty'];
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
						</tr>';
						
							$sql3="SELECT pi_id,pi_type,pi_data FROM tbl_prd_info WHERE prd_id='$pro_id' AND pi_stat=1;";
							$res3 = mysqli_query($GLOBALS['conn'],$sql3) or die(mysqli_error($GLOBALS['conn']));
							while($row3 = mysqli_fetch_assoc($res3)){
								echo'<tr>
									<td><label for="pitype_"'.$row3['pi_id'].'">'.$row3['pi_type'].':</label></td>
									<td><p id="pdata" name="pdata_"'.$row3['pi_id'].'">'.$row3['pi_data'].'</p></td>	
								</tr>';	
							}
						
						echo'<tr>
							<td><label for="prdbrand">Price:</label></td>
                            <td><p id="prdprice" name="prdprice">Rs.5000</p></td>
						</tr>
						<tr>
							<td><label id="stock" name="stock"><span style="color:#060">INSTOCK '.$stockqnty.'</span></label>
						</tr>
					</table>
					</td>';
					echo '<td class="date">'.$datetime.'</td>';
					echo '<td class="addcart"><button class="form-control btn btn-primary" type="button" name="btnaddcart" id="'.$pro_id.'" onclick="addcart(this);"/> Add to Cart <span class="glyphicon glyphicon-shopping-cart"></span></button></td>
                    <td class="remv"><button class="form-control btn btn-warning" type="button" name="btndel" id="'.$pro_id.'" onclick="deleteitem(this);">Delete <span class="glyphicon glyphicon-trash"></span></button></td>';
						}//end main while
					}// end if
					elseif($rows==0)
						$msg="No items in the Wishlist";
				
                ?>
            	
            </tbody>
        </table>
    </div><!-- cart items -->
</div><!-- main container -->
 <?php include('admin/inc-footer.php'); ?>
</body>
</html>
<script type="text/javascript">
function addcart(obj){ // add to cart
	var index = obj.parentNode.parentNode.rowIndex;
	var pid=obj.id;
	//alert(pid);
	var url="lib/site_functions.php?type=cartadd&action=cadd";
	var qnty='1';
	$.get(url,{pid:pid,qnty:qnty},function(data,status){
		//alert(status);
		if(status=='success'){
			//alert(data);
			var dataArr = data.split("|");
			//alert(dataArr[0]);
					if(dataArr[0]=="1" || dataArr[0]=="2"){
						var mytable = document.getElementById("wishlist_tbl");
						mytable.deleteRow(index-1);	
						$("#msg").css("display","block");
						$("#msg").html('<p class="alert alert-success alert-dismissible">'+dataArr[1]+'</p>');	
					}
					else if(dataArr[0]=="3" ){
						$("#msg").css("display","block");
						$("#msg").html('<p class=" alert alert-danger alert-dismissible">'+dataArr[1]+'</p>');
					}
					
			}
		});
	}
	
function deleteitem(obj){ //delete item from wishlist
	var pid=obj.id;
	$.jAlert({'type':'confirm',
	'title':'Confirmation',
	'theme':'yellow',
	'confirmQuestion': 'Are you sure you want to Delete Product '+pid+'?',
	'onConfirm':function(){
			delItem(obj);
		}
	});
}	
function delItem(obj){
	var index = obj.parentNode.parentNode.rowIndex;
	var pid=obj.id;
	//alert(index);
	$.get("lib/site_functions.php?type=remvwishlistitem",{pid:pid},function(data,status){
			if(status=='success'){
				if(data=='1'){
					var mytable = document.getElementById("wishlist_tbl");
					mytable.deleteRow(index-1);	
					$("#msg").css("display","block");
					$("#msg").html('<div class="alert alert-warning alert-dismissible">Successfully Product '+pid+' deleted from Wishlist</p>');
				}
			}
		});
}

</script>