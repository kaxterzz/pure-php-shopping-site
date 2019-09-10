<?php
include('lib/config.php'); // attach config.php
include('admin/lib/connection.php'); // attach db connection
$meta_title = "Product Details"; // title on the browser tab
$c_page = '';// highligting the navbar tab based on the current page
session_start();
$session_id=session_id();
//--------------------------------------------------------
$page_action = '';
$page_title='';
$pid=$_POST['prdid'];
$prd='';
$qnty='';
$img='';
$price='';
$ftype='';
$fdata='';
//$frm_err_msg='';

?>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-title clearfix">
        	<h1 class="pull-left">Product Details</h1><!-- Title of the page loaded according to the action on URL-->
        </div><!--end modal-title -->
      </div><!-- modal-header -->
      <div class="modal-body">
                	<form class="frm form-horizontal" action="" name="frmcat" method="post">
                    <div id="form_msg">
                    </div>
              
             <div class="frmdiv clearfix">
                		<table class="frm-tbl table table-responsive">
                            <tr>
                             <?php $sql="SELECT * FROM tbl_products WHERE prd_id='$pid';";
								  $res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
								  $row=mysqli_fetch_assoc($res);
								  $prd=$row['prd_name'];
								  $qnty=$row['prd_tot_qnty'];
								  $img=$row['prd_img_path'];
								  $price=$row['prd_price'];
								  //$price=$row[];
							?>
                            	<td><label for="pid">Product Id</label></td>
                                <td><p id="pid" name="pid"><?php echo $pid?></p></td>
                                <td rowspan="3"><img src="<?php echo $base_url.'/admin/images/products/'.$img?>" class="" width="350px" height="250px"/></td>
                            </tr>
                            <tr>
                            	<td><label for="prd">Product Name</label></td>
                                <td><p id="prd" name="prd"><?php echo $prd?></p></td>
                          
                            </tr><?php ?>
							<tr>
                                <td><label for="stat">Status</label></td>
                                <td><label id="stat" name="stat"><span style="color:#060">IN STOCK <?php echo $qnty?></span></label>
                                <select class="form-control" id="cmbqnty" name="cmbqnty">
                                	<?php for($i=1;$i<=$qnty;$i++){ ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option><?php }?>
                                  	</select><td>
                               						
                               </tr>
                               <tr> 
                                <td><label for="price">Price</label></td>
           					 	<td><p id="price" name="price"><div class="label label-success pricetag"><span class="glyphicon glyphicon-tag"></span> RS <?php echo number_format((double)$price,2) ?></div></p></td>
                               </tr>
                                <tr> 
                                <td><label for="ftype">Features</label></td>
                                </tr>
                                <?php $sql="SELECT * FROM tbl_prd_info WHERE prd_id='$pid' AND pi_stat=1;";
									  $res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
									  while($row=mysqli_fetch_assoc($res)){
								?>
                                <tr>
                                
           					 	<td><label id="ftype" name="ftype"><span style="color:#06F"><?php echo $ftype=$row['pi_type']?> :</span></label></td>
                                <td><p id="fdata" name="fdata"><span style="color:#06F"><?php echo $fdata=$row['pi_data']?></p></span></td>
                                </tr>
                                <?php }?>
                               </tr>
                        </table>
                     </div><!-- end frmdiv -->  
                     <table class=" btns tbl-horizontal col-md-3">
							<tr>
                            	<td><button class="form-control btn btn-primary" type="button" name="btnaddcart" id="btnaddcart" value="">Add to Cart <span class='glyphicon glyphicon-shopping-cart'></span></button></td>
                                <td><button class="form-control btn btn-warning" type="button"  name="btnaddwish" id="btnaddwish" value="">Add to Wishlist <span class="glyphicon glyphicon-heart"></span></button></td>
                            </tr>
                        </table>   
                         	
                    </form>   
                     
                    
      </div><!-- end modal body -->
      <div class="modal-footer"></div>
    </div><!-- modal-content -->

  </div><!-- modal-dialog -->
  
<script type="text/javascript">
$('#btnaddcart').click(function(){ // add to cart
	var url="lib/site_functions.php?type=cartadd&action=cadd";
	var pid=$('#pid').html();
	//alert(pid);
	var qnty=$('#cmbqnty').val();
	$.get(url,{pid:pid,qnty:qnty},function(data,status){
		//alert(status);
		if(status=='success'){
			//alert(data);
			var dataArr = data.split("|");
			//alert(dataArr[0]);
					if(dataArr[0]=="1" || dataArr[0]=="2"){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-success">'+dataArr[1]+'</p>');
						setTimeout(function(){ $(".close").click() },3000);	
					}
					else if(dataArr[0]=="3" ){
						$("#form_msg").css("display","block");
						//$("#form_msg").css("background-color","#ff0000");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
					}
					
			}
		});
	});

$('#btnaddwish').click(function(){
	var pid=$('#pid').html();
	//alert(pid);
	var url='lib/site_functions.php?type=wishadd';
	//alert(url);
	$.get(url,{pid:pid},function(data,status){
		//alert(status);
		if(status=='success'){
			//alert(data);
			var dataArr = data.split("|");
			//alert(dataArr[0]);
					if(dataArr[0]=="1"){
						$("#form_msg").css("display","block");
						//$("#form_msg").css("background-color","#00ff00");
						$("#form_msg").html('<p class="alert alert-success">'+dataArr[1]+'</p>');
						setTimeout(function(){ $(".close").click() },3000);	
					}
					else if(dataArr[0]=="2"){
						$("#form_msg").css("display","block");
						//$("#form_msg").css("background-color","#00ff00");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
						setTimeout(function(){ $(".close").click() },3000);	
					}
					else if(dataArr[0]=="3" ){
						$("#form_msg").css("display","block");
						//$("#form_msg").css("background-color","#ff0000");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
					}
					else if(dataArr[0]=="4" ){
						$("#form_msg").css("display","block");
						$("#form_msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
						window.location='login.php';
					}
					
			}
		});
	});

</script>