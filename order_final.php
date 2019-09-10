<?php 
$meta_title='Checkout Details';
$c_page = 'checkout';
include('inc_head.php');
session_start();
$session_id = session_id();
$msg='';
$id=$_GET['id'];
?>
</head>
<body>
<?php include('inc_header.php');?>
<div class="container">
	<div id="msg" class=""></div>
	<div class="container">
    	<table class="table table-responsive table-hover">
        	<thead>
            	<tr class="bg-info" >
            		<th class=""><center><h2>Your Order has been successfully Processed</h2></center></th>  
                </tr>
                <tr class="bg-primary" >
            		<th class=""><center><h2>Thank you for your Purchase !!!</h2></center></th>  
                </tr>
            </thead>
            <tbody>
            	<tr>
            		<td><center><h4>You will receive an Order Invoice through the email. Invoice ID:<?php echo $id ?></h4></center></td>
                </tr>
                <tr>
                	<td><center><a type="button" class="btn btn-primary" href="index.php" >Continue Shopping <span class="glyphicon glyphicon-shopping-cart"></span></a></center></td>
                </tr>    
    		 </tbody>     
       </table>
    </div>           
</div><!-- main container -->
    <?php include('admin/inc-footer.php'); ?>
 </body>
</html>   