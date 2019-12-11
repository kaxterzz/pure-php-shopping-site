<?php
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
$meta_title = "Daily Stock Report";
session_start();
include('../inc-head.php');//attach inc-head.php
$date=$_POST['dailystock'];
?>
</head>

<body>
	<div class="container-fluid">
    	<div id="upper-bannar">
        	<table class="table table-condensed">
            	<tr>
                	<th rowspan="4"  class="col-md-1">
               		 	<img class="img-responsive" src="../images/logo.png" width="75%"/>
                    </th>    
                    
                </tr>
                <tr>
                	
                	<td class="col-md-10" style="padding-bottom:0px;border-top:0px"><h1 style="margin:0px;color:#2E8AE6;font-family:Georgia, 'Times New Roman', Times, serif;">AMAYA FASHION</h1></td>
                </tr>
                <tr>
                	
                	<td style="border-top:0px;padding:0px 0px 0px;font-size:16px">No.720, Rajamaha Vihara Mw, Kelaniya</td>	 
                </tr>
                <tr>
                	
                	<td style="border-top:0px;padding:0px 0px 0px;font-size:16px">Tel.No: +94 773 518787</td>
                </tr>
            </table>
            <hr>
        </div><!-- upper-bannar-->
        <div class="container">
        	<div id="topic">
            	<h4><?php echo $date ?> Daily Stock Report</h4>
            </div>
        	<table class="table table-bordered tblreports"  style="border-color:#000">
            	<thead>
                <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity Available</th>
                </tr>
                </thead>
                <tbody id="daily_stock_details">
                <?php 
					$sql="SELECT prd_id,prd_name,prd_tot_qnty FROM tbl_products WHERE prd_stat=1 GROUP BY prd_id;";
					$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
					$nor=mysqli_num_rows($res);
					if($nor>0){	
						while($row=mysqli_fetch_assoc($res)){
							
							
							?>
							<tr>
                            	<td><?php echo $row['prd_id'] ?></td>
                                <td><?php echo $row['prd_name'] ?></td>
                                <td style="text-align:right"><?php echo $row['prd_tot_qnty'] ?></td>
                            </tr>
                            
					<?php	
						

						}	//end while
					}//end if
					elseif($nor==0){
						echo '<tr><td colspan="4"><center>No Records found</center></td></tr>';	
					}
				?>
                </tbody>
                
            </table>
             <div class="container printbar">
            	<button id="btnprint" name="btnprint" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-print"></span> Print</button>
            </div>
        </div><!-- end container -->
    </div><!-- cantainer-fluid-->
    <?php include('../inc-footer.php'); ?>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(e) {
        /* var tbody = document.getElementById("daily_sales_details");
		 var row_count = tbody.rows.length;
		 var i = 0;
		 var tot=0; 			
		 while(i<row_count){
			alert( tbody.rows[i].childNodes[7].innerHTML);
			tot += parseFloat(tbody.rows[i].childNodes[7].innerHTML);
			i++;
		}
		document.getElementById("totsal").innerHTML = tot.toFixed(2);*/
		//alert( tot.toFixed(2));
     });
	 
	 $("#btnprint").click(function(){				
			  $(this).hide();
			  window.print();
			  $(this).show();
		  });
</script>