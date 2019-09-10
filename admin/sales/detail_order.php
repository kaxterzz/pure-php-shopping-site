<?php
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
$meta_title = "View Product Details of Sales Orders"; // title on the browser tab
$c_page = '';// highligting the navbar tab based on the current page
//--------------------------------------------------------
$page_action = '';
$invid=$_POST['invid'];
$page_title='View Product Details of Sales Order '.$invid;
$prdid='';
$prd='';
$qnty='';
$price='';
$tot='';
?>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-title clearfix">
        	<center><h1 class="pull-left"><?php echo $page_title ?></h1></center><!-- Title of the page loaded according to the action on URL-->
        </div><!--end modal-title -->
      </div><!-- modal-header -->
      <div class="modal-body">
                    <div id="form_msg">
                    </div>
             <div class="frmdiv">
                    <table class="frm-tbl table table-responsive">
                        <thead>
                        	<th class="col-md-2">Product ID</th>
                        	<th class="col-md-3">Product Name </th>
                            <th class="col-md-2">Unit Price</th>
                            <th class="col-md-1">Quantity</th>
                            <th class="col-md-2">Total Price</th>
                            <th class="col-md-1"></th>
                            <th class="col-md-1"></th>
                        </thead>
                        <tbody><!-- edit -->
                        <?php $sql_select="SELECT I.prd_id,P.prd_name,I.prd_u_price,inv_prd_qnty,inv_prd_tot FROM tbl_inv_info I,tbl_products P WHERE I.prd_id=P.prd_id AND inv_id='$invid';";
							  $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error());
							  while($row=mysqli_fetch_assoc($result)){
								  
						?>	<tr>
                        	<td><?php echo $prdid=$row['prd_id'];?></td>
                        	<td><?php echo $prd=$row['prd_name'];?></td>
                            <td><?php echo $price=$row['prd_u_price'];?></td>
                            <td><?php echo $qnty=$row['inv_prd_qnty'];?></td>
                            <td><?php echo $tot=$row['inv_prd_tot'];?></td>
                            
                            <td>
                                <a class="glyphicon glyphicon-pencil link-edit" href="<?php echo $base_url ?>sales/edit-order.php?id=<?php echo $invid ?>" title="Edit"> Edit</a>
                        	</td>
                            <td>
                            	<a class="glyphicon glyphicon-remove link-delete" onclick="deleteprd(this);" id="<?php echo $prdid?>|<?php echo $invid?>" title="Delete"> Delete</a>
                            </td>
                            </tr>
                            <?php }// close while loop ?>
                        </tbody>
                    </table>    
                    </div><!-- end frmdiv -->             
      </div><!-- end modal body -->
      <div class="modal-footer"></div>
    </div><!-- modal-content -->

  </div><!-- modal-dialog -->
<script type="text/javascript">
function deleteprd(obj){ // removing item from the invoice
		var id = obj.id;
		var dataArr = id.split("|");
		var pid=dataArr[0];
		var invid=dataArr[1];
		$.jAlert({'type':'confirm',
		'title':'Confirmation',
		'theme':'yellow',
		'confirmQuestion': 'Are you sure you want to Delete Product '+dataArr[0]+'?',
		'onConfirm':function(){
			delItem(pid,invid);
		}
	});
}

function delItem(pid,invid){
	$.get("../lib/sales_func.php?type=delprdorder",{pid:pid,invid:invid},function(data,status){
		if(status=='success'){
				//alert(data);
				var dataArr = data.split("|");
					if(dataArr[0]=="1"){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-warning">'+dataArr[1]+'</p>');
						setTimeout(function(){ $(".close").click() },3000);
						window.location.reload();	
					}
					else if(dataArr[0]=="2" ){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
					}
		}
	});
}
</script>  
