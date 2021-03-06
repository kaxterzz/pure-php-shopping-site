<?php
include('../lib/config.php'); // attach config.php
include('../lib/connection.php'); // attach db connection
$meta_title = "Yearly Sales Report";
session_start();
include('../inc-head.php');//attach inc-head.php
$date=$_POST['yearlylysales'];
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
                	
                	<td class="col-md-10" style="padding-bottom:0px;border-top:0px"><h1 style="margin:0px;color:#2E8AE6;font-family:Georgia, 'Times New Roman', Times, serif;">BINNY TRADERS</h1></td>
                </tr>
                <tr>
                	
                	<td style="border-top:0px;padding:0px 0px 0px;font-size:16px">No.44, Ambagamuwa road, Gampola</td>	 
                </tr>
                <tr>
                	
                	<td style="border-top:0px;padding:0px 0px 0px;font-size:16px">Tel.No: +94 81 2352302</td>
                </tr>
            </table>
            <hr>
        </div><!-- upper-bannar-->
        <div class="container">
        	<div id="topic">
            	<h4>Sales Report <?php echo $date ?></h4>
            </div>
        	<table class="table table-bordered tblreports"  style="border-color:#000">
            	<thead>
                <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-6">Month</th>
                <th class="col-md-5">Sales Amount(Rs)</th>
                </tr>
                </thead>
                <tbody id="yearly_sales_details">
                <?php 
					$sql="SELECT MONTH(inv_date),SUM(inv_ntot) FROM tbl_invoice WHERE YEAR(inv_date)='$date'
GROUP BY MONTH(inv_date);";
					$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
					$nor=mysqli_num_rows($res);
					$i=1;
					$ntot=0;
					if($nor>0){	
						while($row=mysqli_fetch_assoc($res)){
							?>
							<tr>
                            	<td class="col-md-1" style="text-align:center">
								<?php if($i<=$nor){
										echo $i;
										$i++;
									}?></td>
                                <td class="col-md-6" style="text-align:center">
								<?php
								 $month=$row['MONTH(inv_date)']; 
								 $newmonth=''; //month to display on title
									switch($month){
										case 1:
										  $newmonth= "January";
										  break;
										case 2:
										  $newmonth= "February";
										  break;
										case 3:
										  $newmonth= "March";
										  break;
										case 4:
										  $newmonth= "April";
										  break;
										case 5:
										  $newmonth= "May";
										  break;
										case 6:
										  $newmonth= "June";
										  break;
										case 7:
										  $newmonth= "July";
										  break;
										case 8:
										  $newmonth= "August";
										  break;
										case 9:
										  $newmonth= "September";
										  break;
										case 10:
										  $newmonth= "October";
										  break;
										case 11:
										  $newmonth= "November";
										  break;
										case 12:
										  $newmonth= "December";
										  break;
										default:
										  $newmonth='Incorrect month selection';
									  } 
								 echo $newmonth ?>
                                 </td>
                                <td class="col-md-5" style="text-align:right"><?php echo number_format((double)$row['SUM(inv_ntot)'],2,'.',',')?></td>
                            </tr>
                            
					<?php	
						$ntot=(double)((double)$ntot+$row['SUM(inv_ntot)']);// get the summesion of all netsales
						
						}	//end while
					}//end if
					elseif($nor==0){
						echo '<tr><td colspan="4"><center>No Records found</center></td></tr>';	
					}
				?>
                </tbody>
                <tfoot>
                	<tr>
                    	<th colspan="2" style="text-align:right">Total Sales</th>
                        <th id="totsal" style="text-align:right"><?php echo number_format($ntot,2,'.',',');?></th>
                    </tr>
                </tfoot>
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
	 $("#btnprint").click(function(){				
			  $(this).hide();
			  window.print();
			  $(this).show();
		  });
</script>