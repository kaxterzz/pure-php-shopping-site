<?php 
session_start(); 
$session_id=session_id();
$meta_title='Amaya Fashion';
$c_page = '';
?>
<?php include('inc_head.php');?>
</head>

<body>
<?php include('inc_header.php');?>
<?php include('inc_megamenu.php'); ?>
<!--<div class="container">-->
<div class="modal fade" id="ModelWindow">
<div class="loadExt"></div>
</div><!-- /.modalprdDetails -->
<div class="next container">
	<div id="msg"></div>
	<div class="row">
		<div class="prd col-md-12">	
         	<?php
				$catid=$_GET['catid'];
				$sql="SELECT prd_id,prd_name,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE cat_id='$catid' AND prd_tot_qnty>prd_reorder_lvl";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("mysqli_ Error:".mysqli_error($GLOBALS['conn']));
				if(mysqli_num_rows($res)==0){
					echo ("There are no Products to display");
					}
				else{	
				while($row=mysqli_fetch_assoc($res)){
					$prdid=$row['prd_id'];
					$qnty=$row['prd_tot_qnty'];
					$aprice=$row['prd_price'];
					$price=floor($aprice);// extract only the whole part of the float number
					
					
				?>   
                
          <!--<td class="col-md-5">-->      
        	<div class="prd_panel panel panel-primary col-md-4 col-md-offset-1">
            <div class="label label-success price_tag"><span class="glyphicon glyphicon-tag"></span> RS <?php echo $price ?></div>
            
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo $pname=$row['prd_name'] ?>   <div class="label label-warning instock">IN STOCK <big><?php echo $qnty?></big></div></div>
                </div><!-- end panel-heading-->
                <div class="panel-body">
                	<ul style="list-style:none;padding-left:0px">
                    	<li><a href=""><img class="" src="<?php echo $base_url.'/admin/images/products/'.$row['prd_img_path']?>" width="350px" height="250px"/></a></li>
                        
                    </ul>
                </div><!-- end panel-body -->
                
                <div class="panel-footer">
                <div class="row"><center>
                <a class="btn btn-primary btnLoadPrdData" role="button" id="btnview" name="btnview" data-type="view" data-id="<?php echo $prdid ?>" type="button" data-toggle="modal" data-target="#ModelWindow">View Details <span class="glyphicon glyphicon-eye-open"></span></a>
                <!--<a class="btn btn-primary" role="button" id="btncart" name="btncart" href="cart.php?action=cadd&prdid=<?php //echo $prdid ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>-->
                <a class="btn btn-warning" role="button" id="<?php echo $prdid ?>" name="btnaddwish" onClick="addWishlist(this);" data-id="<?php echo $prdid ?>">Add to Wishlist<span class="glyphicon glyphicon-heart"></span></a></center>
                </div><!-- footer row-->
               </div><!-- panel footer -->
            </div><!-- end panel -->
          <!--</td>
          
        	<?php }//end while 
			 }//end else
        	?>
         </tr>   
    
</table>-->
	</div><!--end prd -->

    </div><!-- end row -->
</div><!-- end next container-->
 <?php include('admin/inc-footer.php'); ?>
</body>
</html>
<script>
	
function addWishlist(obj){
	var pid=obj.id;
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
						$("#msg").css("display","block");
						//$("#form_msg").css("background-color","#00ff00");
						$("#msg").html('<p class="alert alert-success">'+dataArr[1]+'</p>');
						
					}
					else if(dataArr[0]=="2"){
						$("#msg").css("display","block");
						//$("#form_msg").css("background-color","#00ff00");
						$("#msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
					}
					else if(dataArr[0]=="3" ){
						$("#msg").css("display","block");
						//$("#form_msg").css("background-color","#ff0000");
						$("#msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
					}
					else if(dataArr[0]=="4" ){
						$("#msg").css("display","block");
						$("#msg").html('<p class="alert alert-danger">'+dataArr[1]+'</p>');
						window.location='login.php';
					}
					
			}
		});

}

</script>