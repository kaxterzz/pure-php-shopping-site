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
<div class="modal fade" id="ModelWindow">
<div class="loadExt"></div>
</div><!-- /.modalprdDetails -->
<div class="next container">
	<div id="msg"></div>
<div class="container"><!-- corousal Container --->
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="admin/images/slider-1.jpg" alt="Promotion1" width="100%" height="345">
        <div class="carousel-caption">
          <h3></h3>
          <p></p>
        </div>
      </div>

	  <div class="item">
        <img src="admin/images/slider-2.jpg" alt="Promotion3" width="100%" height="345">
        <div class="carousel-caption">
          <h3></h3>
          <p></p>
        </div>
      </div>

      <div class="item">
        <img src="admin/images/slider-3.jpg" alt="Promotion3" width="100%" height="345">
        <div class="carousel-caption">
          <h3></h3>
          <p></p>
        </div>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div><!-- end corousal Container --->
<div class="container next2" style="margin-top:25px">
<div class="row">
		<div class="catview col-md-2">
        		<div id="musix">
                    <a href="#" class="list-group-item active">Smart Casual
                    </a>
                    <ul class="list-group">
						<?php 
							$sql="SELECT C.cat_id,C.cat_name,COUNT(prd_id) FROM tbl_category C,tbl_products P WHERE C.cat_id=P.cat_id AND C.cat_super_cat='Smart Casual' GROUP BY cat_id;";
							$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							while($row=mysqli_fetch_assoc($res)){
						?>
                        <li class="list-group-item"><?php echo $row['cat_name']; ?>
      <span class="label label-success pull-right"><?php echo $row['COUNT(prd_id)']; ?></span>
                        </li>
                        <?php }?>
                    </ul>
                </div><!-- end Smart Casual -->
                <!-- /.div -->
                <div id="electronics">
                    <a href="#" class="list-group-item active">Trousers
                    </a>
                    <ul class="list-group">
<?php 
							$sql="SELECT C.cat_id,C.cat_name,COUNT(prd_id) FROM tbl_category C,tbl_products P WHERE C.cat_id=P.cat_id AND C.cat_super_cat='Trousers' GROUP BY cat_id;";
							$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							while($row=mysqli_fetch_assoc($res)){
						?>
                        <li class="list-group-item"><?php echo $row['cat_name']; ?>
      <span class="label label-danger pull-right"><?php echo $row['COUNT(prd_id)']; ?></span>
                        </li>
                        <?php }?>
                    </ul>
                </div><!-- end Trousers -->
                <!-- /.div -->
                <div id="light">
                    <a href="#" class="list-group-item active ">Casual Wears
                    </a>
                    <ul class="list-group">
<?php 
							$sql="SELECT C.cat_id,C.cat_name,COUNT(prd_id) FROM tbl_category C,tbl_products P WHERE C.cat_id=P.cat_id AND C.cat_super_cat='Casual Wears' GROUP BY cat_id;";
							$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							while($row=mysqli_fetch_assoc($res)){
						?>
                        <li class="list-group-item"><?php echo $row['cat_name']; ?>
      <span class="label label-primary pull-right"><?php echo $row['COUNT(prd_id)']; ?></span>
                        </li>
                        <?php }?>
                    </ul>
                </div><!-- end Casual Wears -->
                <div id="electronics">
                    <a href="#" class="list-group-item active ">Foot Wears
                    </a>
                    <ul class="list-group">

                       <?php 
							$sql="SELECT C.cat_id,C.cat_name,COUNT(prd_id) FROM tbl_category C,tbl_products P WHERE C.cat_id=P.cat_id AND C.cat_super_cat='Foot Wears' GROUP BY cat_id;";
							$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
							while($row=mysqli_fetch_assoc($res)){
						?>
                        <li class="list-group-item"><?php echo $row['cat_name']; ?>
      <span class="label label-info pull-right"><?php echo $row['COUNT(prd_id)']; ?></span>
                        </li>
                        <?php }?>
                    </ul>
                </div><!-- end Foot Wears -->
        </div><!-- col-md-4-->
		<div class="prd col-md-10"><!-- Feature product view -->
        	<div class="col-md-offset-1" style="margin-bottom:30px;background-color:#FC0;padding:5px"><em><h2 style="color:#06C">Featured Products</h2></em></div>	
         	<?php
				$sql="SELECT prd_id,prd_name,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE prd_id='P0000002' AND prd_tot_qnty>prd_reorder_lvl;";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
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
        	<div class="prd_panel panel panel-primary col-md-4 col-md-offset-1">
            <div class="label label-success price_tag"><span class="glyphicon glyphicon-tag"></span> RS <?php echo $price ?></div>
            
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo $pname=$row['prd_name'] ?>   <div class="label label-warning instock">IN STOCK <big><?php echo $qnty?></big></div></div>
                </div><!-- end panel-heading-->
                <div class="panel-body">
                	<ul style="list-style:none;padding-left:0px">
                    	<li><a href=""><img class=""  src="<?php echo $base_url.'/admin/images/products/'.$row['prd_img_path']?>" width="250px" height="200px"/></a></li>
                        
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
        	<?php }//end while 
			 }//end else
        	?>    
    
    		<!-- Feature product view2 -->	
         	<?php
				$sql="SELECT prd_id,prd_name,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE prd_id='P0000007' AND prd_tot_qnty>prd_reorder_lvl";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
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
        	<div class="prd_panel panel panel-primary col-md-4 col-md-offset-1">
            <div class="label label-success price_tag"><span class="glyphicon glyphicon-tag"></span> RS <?php echo $price ?></div>
            
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo $pname=$row['prd_name'] ?>   <div class="label label-warning instock">IN STOCK <big><?php echo $qnty?></big></div></div>
                </div><!-- end panel-heading-->
                <div class="panel-body">
                	<ul style="list-style:none;padding-left:0px">
                    	<li><a href=""><img width="250px" height="200px" src="<?php echo $base_url.'/admin/images/products/'.$row['prd_img_path']?>"/></a></li>
                        
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
        	<?php }//end while 
			 }//end else
        	?>    

    		<!-- Feature product view3 -->	
         	<?php
				$sql="SELECT prd_id,prd_name,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE prd_id='P0000005' AND prd_tot_qnty>prd_reorder_lvl";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
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
        	<div class="prd_panel panel panel-primary col-md-4 col-md-offset-1">
            <div class="label label-success price_tag"><span class="glyphicon glyphicon-tag"></span> RS <?php echo $price ?></div>
            
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo $pname=$row['prd_name'] ?>   <div class="label label-warning instock">IN STOCK <big><?php echo $qnty?></big></div></div>
                </div><!-- end panel-heading-->
                <div class="panel-body">
                	<ul style="list-style:none;padding-left:0px">
                    	<li><a href=""><img class="" width="250px" height="200px" src="<?php echo $base_url.'/admin/images/products/'.$row['prd_img_path']?>"/></a></li>
                        
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
        	<?php }//end while 
			 }//end else
        	?> 	

			    		<!-- Feature product view4 -->	
         	<?php
				$sql="SELECT prd_id,prd_name,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE prd_id='P0000003' AND prd_tot_qnty>prd_reorder_lvl";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
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
        	<div class="prd_panel panel panel-primary col-md-4 col-md-offset-1">
            <div class="label label-success price_tag"><span class="glyphicon glyphicon-tag"></span> RS <?php echo $price ?></div>
            
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo $pname=$row['prd_name'] ?>   <div class="label label-warning instock">IN STOCK <big><?php echo $qnty?></big></div></div>
                </div><!-- end panel-heading-->
                <div class="panel-body">
                	<ul style="list-style:none;padding-left:0px">
                    	<li><a href=""><img class="" width="250px" height="200px" src="<?php echo $base_url.'/admin/images/products/'.$row['prd_img_path']?>"/></a></li>
                        
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
        	<?php }//end while 
			 }//end else
        	?> 
            
                		<!-- Feature product view5 -->	
         	<?php
				$sql="SELECT prd_id,prd_name,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE prd_id='P0000003' AND prd_tot_qnty>prd_reorder_lvl";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
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
        	<div class="prd_panel panel panel-primary col-md-4 col-md-offset-1">
            <div class="label label-success price_tag"><span class="glyphicon glyphicon-tag"></span> RS <?php echo $price ?></div>
            
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo $pname=$row['prd_name'] ?>   <div class="label label-warning instock">IN STOCK <big><?php echo $qnty?></big></div></div>
                </div><!-- end panel-heading-->
                <div class="panel-body">
                	<ul style="list-style:none;padding-left:0px">
                    	<li><a href=""><img class="" width="250px" height="200px" src="<?php echo $base_url.'/admin/images/products/'.$row['prd_img_path']?>"/></a></li>
                        
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
        	<?php }//end while 
			 }//end else
        	?> 
            
                		<!-- Feature product view6 -->	
         	<?php
				$sql="SELECT prd_id,prd_name,prd_img_path,prd_tot_qnty,prd_price FROM tbl_products WHERE prd_id='P0000003' AND prd_tot_qnty>prd_reorder_lvl";
				$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
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
        	<div class="prd_panel panel panel-primary col-md-4 col-md-offset-1">
            <div class="label label-success price_tag"><span class="glyphicon glyphicon-tag"></span> RS <?php echo $price ?></div>
            
            	<div class="panel-heading">
                	<div class="panel-title"><?php echo $pname=$row['prd_name'] ?>   <div class="label label-warning instock">IN STOCK <big><?php echo $qnty?></big></div></div>
                </div><!-- end panel-heading-->
                <div class="panel-body">
                	<ul style="list-style:none;padding-left:0px">
                    	<li><a href=""><img class="" width="250px" height="200px" src="<?php echo $base_url.'/admin/images/products/'.$row['prd_img_path']?>"/></a></li>
                        
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
        	<?php }//end while 
			 }//end else
        	?> 
    </div><!-- end row -->
</div><!--end container next2 -->   
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