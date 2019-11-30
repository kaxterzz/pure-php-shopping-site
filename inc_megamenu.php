<div class="mega">
	
<div class="navbar navbar-default">
    	<!--<div class="container">-->
        	<div class="navbar-header">
            	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navi2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a href="" class="navbar-brand"><img src="images/logo.jpg" class="img-responsive"/></a>-->
            </div><!-- end navbar-header-->
            <!-- collection of navigations -->
            <div class="collapse navbar-collapse" id="navi2">
            	<div class="col-md-8">
            	<ul class="nav navbar-nav">
                	
				    <li class="dropdown dp1">
                    	<a href="#" class="dropdown-toggle" data-toggle="dp1">Smart Casual <b class="caret"></b></a>
						<ul class="dropdown-menu mega-menu">
                             <?php 
									$sql="SELECT cat_id,cat_name FROM tbl_category WHERE cat_stat=1 AND cat_super_cat='Smart Casual'";
									$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
									while($row=mysqli_fetch_assoc($res)){
									?>
						    <li class="mega-menu-column">
						    <ul>
						       <li class="nav-header"><a href="show_prd.php?catid=<?php echo $catid=$row['cat_id'];?>"><?php echo($row['cat_name']);?></a></li>
                               
                                	<!--<img src="admin/images/products/<?php echo $row['prd_img_path']; ?>">-->
								 
						    </ul>
						    </li>  <?php }?>   
						</ul><!-- dropdown-menu -->
                    </li>
                    <li class="dropdown dp2">
                        <a href="#" class="dropdown-toggle" data-toggle="dp2">Trousers <b class="caret"></b></a>                      

						<ul class="dropdown-menu mega-menu">
    						
                            <?php 
								$sql="SELECT cat_id,cat_name FROM tbl_category WHERE cat_stat=1 AND cat_super_cat='Trousers'";
								$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
								while($row=mysqli_fetch_assoc($res)){
									?>
						    <li class="mega-menu-column">
						    <ul>
						        <li class="nav-header"><a href="show_prd.php?catid=<?php echo($row['cat_id']);?>"><?php echo($row['cat_name']);?></a></li>
						       <!-- <img src="http://placehold.it/150x120">-->
								
						    </ul>
						    </li> <?php }?>    
						</ul><!-- dropdown-menu -->
						
					</li><!-- /.dropdown -->
				    <li class="dropdown dp3">
                        <a href="#" class="dropdown-toggle" data-toggle="dp3">Casual Wears <b class="caret"></b></a>                      

						<ul class="dropdown-menu mega-menu">
    						
                            <?php 
								$sql="SELECT cat_id,cat_name FROM tbl_category WHERE cat_stat=1 AND cat_super_cat='Casual Wears'";
								$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
								while($row=mysqli_fetch_assoc($res)){
									?>
						    <li class="mega-menu-column">
						    <ul>
						        <li class="nav-header"><a href="show_prd.php?catid=<?php echo($row['cat_id']);?>"><?php echo($row['cat_name']);?></a></li>
						       <!-- <img src="http://placehold.it/150x120">-->
								
						    </ul>
						    </li> <?php }?>    
						</ul><!-- dropdown-menu -->
						
					</li><!-- /.dropdown -->    
                    <li class="dropdown dp4">
                        <a href="#" class="dropdown-toggle" data-toggle="dp4">Foot Wears <b class="caret"></b></a>                      

						<ul class="dropdown-menu mega-menu">
    						
                            <?php 
								$sql="SELECT cat_id,cat_name FROM tbl_category WHERE cat_stat=1 AND cat_super_cat='Foot Wears'";
								$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
								while($row=mysqli_fetch_assoc($res)){
									?>
						    <li class="mega-menu-column">
						    <ul>
						        <li class="nav-header"><a href="show_prd.php?catid=<?php echo($row['cat_id']);?>"><?php echo($row['cat_name']);?></a></li>
						       <!-- <img src="http://placehold.it/150x120">-->
								
						    </ul>
						    </li> <?php }?>    
						</ul><!-- dropdown-menu -->
						
					</li><!-- /.dropdown -->
                    
                    
				</ul>
                </div><!-- col-md-8 -->
                <div class="col-md-4">
                   <!--<li class=" pull-right" style="list-style:none"> <div class="search-bar">
                	<form class="navbar-form" role="search">
                		<div class="form-group">
                 	 		<input type="text" class="form-control" placeholder="Search">
                		 </div>
                		<button type="submit" class="btn btn-primary">Submit</button>
                       
              		</form>
            	</div><!-- end search-bar --><!--</li>-->
                </div><!-- col-md-4-->
            </div><!-- end navi2 -->
        <!--</div><!-- end container -->
    </div><!-- end navbar -->
</div><!-- end container -->    

<script type="text/javascript">
jQuery(document).ready(function(){
    $(".dropdown").hover(
        function() { $('.dropdown-menu', this).fadeIn("slow");
        },
        function() { $('.dropdown-menu', this).fadeOut("slow");
    });
});
</script>