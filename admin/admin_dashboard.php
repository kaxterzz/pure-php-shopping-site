<?php 
session_start();
if((!isset($_SESSION["employee"]['etype'])) || ($_SESSION["employee"]["etype"]!=="J0001" && $_SESSION["employee"]["etype"]!=="J0002" && $_SESSION["employee"]["etype"]!=="J0003")){
	header("Location:../index.php");
}
include('lib/config.php'); // attach config.php
include('lib/connection.php'); // attach db connection
include('lib/function.php');

$meta_title = "Dashboard"; // meta title
$c_page = 'dashboard'; // current page
?>
<?php include("inc-head.php"); ?>
    <!-- head section of html -->
<style>
			body{
				padding: 0;
				margin: 0;
			}
			#canvas-holder{
				width:30%;
			}
		</style>    
    </head>
    <body onLoad="">
    <?php include("inc-header.php"); 
	//send notifications if settle date of credit purchases is closer
	$tdate=date('Y-m-d');
	$date = date('Y-m-d', strtotime($tdate .' +7 day'));
	//edit
$sql="SELECT batch_id,prd_id,batch_settle_date FROM tbl_batch WHERE batch_settle_date='$date';";
	$res=mysqli_query($GLOBALS['conn'],$sql) or die("MYSQL Error:".mysqli_error($GLOBALS['conn']));
	$nor=mysqli_num_rows($res);
	if($nor!=0){
		$arr=array();
		while($row=mysqli_fetch_assoc($res)){
			array_push($arr,$row['batch_id'].' '.$row['prd_id'].' '.$row['batch_settle_date']);
		}
		$i=0;
		$resp ='+94775059818';
		$msg ='Dear Sir/Madam, Batch ';
		for($i=0;$i<$nor;$i++){
					$msg.=' '.$arr[$i];		
		};
		$msg.=' reaches the credit settlement date.Please Settle the credit amount';
		$gatewayURL = 'http://localhost:9333/ozeki?'; 
		$request = 'login=admin'; 
		$request .= '&password=abc123'; 
		$request .= '&action=sendMessage'; 
		$request .= '&messageType=SMS:TEXT'; 
		$request .= '&recepient='.urlencode($resp); 
		$request .= '&messageData='.urlencode($msg);
		$url = $gatewayURL . $request; 
		//Open the URL to send the message 
		file($url);
		$smsg="success";
		if($smsg=='success'){
			//echo "1";
		}
	}
	?>
    <!-- navbar and title bar -->

    <div class="page-body container-fluid">
      <div class="frmdiv" style="margin-top:10px">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="3" valign="top" class="col-md-12"><h2>&nbsp;</h2>
              <h2><center>Monthly Sales (<?php echo date('F, Y') ?>)</center></h2>
              <div style="width:100%;">
                <canvas id="canvas-monthly-sales" height="150" width="400"></canvas>
              </div></td>
          </tr>
          <tr>
            <td colspan="3" valign="top" class="col-md-12"><h2>&nbsp;</h2>
              <h2><center>Product Sales for <?php echo date('d F, Y') ?></center></h2>
              <div style="width:100%;">
                <canvas id="canvas-product-sales" height="150" width="400"></canvas>
              </div></td>
          </tr>
          <tr>
            <td class="col-md-4">&nbsp;</td>
            <td class="col-md-4">&nbsp;</td>
            <td class="col-md-4">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><div class="col-md-12">
                <h2><center>Monthly Salse rep sales</center></h2>
                <table width="100%" class="table table-condensed table-hover">
                <thead>
                    <tr style="background-color:#09F">
                    <th>Name Of Sales Representative</th>
                    <th>Sales Output</th>
                    
                  </tr>
                  </thead>
                <tbody>
                	<?php 
					$sql="SELECT E.emp_fname, E.emp_lname,SUM(inv_ntot) FROM tbl_invoice I, tbl_emp E WHERE I.inv_emp_id = E.emp_id GROUP BY E.emp_id;";
					$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
					$nor=mysqli_num_rows($res);
					if($nor>0){	
						while($row=mysqli_fetch_assoc($res)){ ?>
							<tr>
                            	<td><?php echo $row['emp_fname']; ?> <?php echo $row['emp_lname']; ?></td>
                                <td><?php echo $row['SUM(inv_ntot)']; ?> </td>
                            </tr>
				<?php 	}
					}
					else{ ?>
						<tr><td colspan="2">No Records Found</td></tr>	
					<?php }
					?>
                  </tbody>
              </table>
              </div></td>
            <td valign="top">
            	<div class="col-md-12">
                <h2><center>Today Stock Level</center></h2>
                <table width="100%" class="table table-condensed table-hover">
                <thead>
                    <tr  style="background-color:#09F">
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Stock Quantity</th>
                  </tr>
                  </thead>
                <tbody>
                	<?php 
					$sql="SELECT prd_id,prd_name,prd_tot_qnty FROM tbl_products WHERE prd_stat=1 GROUP BY prd_id;";
					$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
					$nor=mysqli_num_rows($res);
					if($nor>0){	
						while($row=mysqli_fetch_assoc($res)){ ?>
							<tr>
                            	<td><?php echo $row['prd_id']; ?></td>
                                <td><?php echo $row['prd_name']; ?> </td>
                                <td><?php echo $row['prd_tot_qnty']; ?> </td>
                            </tr>
				<?php 	}
					}
					else{ ?>
						<tr><td colspan="2">No Records Found</td></tr>	
					<?php }
					?>
                  </tbody>
              </table>
              </div>
             </td>
              
            <td valign="top"><div class="col-md-12">
                <h2><center>Today's Reoder Levels of Products</center></h2>
                <table width="100%" class="table table-condensed table-hover">
                <thead>
                    <tr  style="background-color:#09F">
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Stock Quantity</th>
                    <th>Product Re-order Level</th>
                  </tr>
                  </thead>
                <tbody>
                	<?php 
					$sql="SELECT prd_id,prd_name,prd_tot_qnty,prd_reorder_lvl FROM tbl_products WHERE prd_stat=1 GROUP BY prd_id;";
					$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
					$nor=mysqli_num_rows($res);
					if($nor>0){	
						while($row=mysqli_fetch_assoc($res)){ ?>
							<tr>
                            	<td><?php echo $row['prd_id']; ?></td>
                                <td><?php echo $row['prd_name']; ?> </td>
                                <td><?php echo $row['prd_tot_qnty']; ?> </td>
                                 <td><?php echo $row['prd_reorder_lvl']; ?> </td>
                            </tr>
				<?php 	}
					}
					else{ ?>
						<tr><td colspan="2">No Records Found</td></tr>	
					<?php }
					?>
                  </tbody>
              </table>
              </div></td>
          </tr>
        </table>
      </div>
    </div>
    <?php include("inc-footer.php"); ?>
</body>
    </html>
<script type="text/javascript">

<?php 
$num_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); 

$arr_lbl = array();
$arr_salse_online = array();
$arr_salse_offline = array();

for($i=1;$i<=$num_days;$i++){	
	array_push($arr_lbl,'Day '.$i);	
	
	$sql1 = "SELECT DATE(inv_date),SUM(inv_ntot) FROM tbl_invoice WHERE DAY(inv_date)='$i' AND MONTH(inv_date)='".date('m')."' AND YEAR(inv_date)='".date('Y')."' AND inv_online='1' GROUP BY DATE(inv_date);"; //monthly sales online
	
	$res1=mysqli_query($GLOBALS['conn'],$sql1) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
	$nor1=mysqli_num_rows($res1);
	
	if($nor1>0){	
		$row1=mysqli_fetch_assoc($res1);
		array_push($arr_salse_online,$row1['SUM(inv_ntot)']);		
	}else{
		array_push($arr_salse_online,0);		
	}
	
	//off
	$sql2 = "SELECT DATE(inv_date),SUM(inv_ntot) FROM tbl_invoice WHERE DAY(inv_date)='$i' AND MONTH(inv_date)='".date('m')."' AND YEAR(inv_date)='".date('Y')."' AND inv_online='0' GROUP BY inv_date;"; //monthly sales online
	
	$res2=mysqli_query($GLOBALS['conn'],$sql2) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
	$nor2=mysqli_num_rows($res2);
	
	if($nor2>0){	
		$row2=mysqli_fetch_assoc($res2);
		array_push($arr_salse_offline,$row2['SUM(inv_ntot)']);		
	}else{
		array_push($arr_salse_offline,0);		
	}
	
	
}


?>


var barSalesChartData = {
	labels : <?php echo json_encode($arr_lbl) ?>,
	datasets : [
		{
			label: "Monthly Online Sales",
			fillColor : "rgba(0, 153, 204,0.2)",
			strokeColor : "rgba(76,77,197,1)",
			pointColor : "rgba(220,220,220,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#4c4dc5",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data :<?php echo json_encode($arr_salse_online) ?>
		}
		,{
			label: "Monthly offline  Sales",
			fillColor : "rgba(70,70,197,0.2)",
			strokeColor : "rgba(76,77,197,1)",
			pointColor : "rgba(220,220,220,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#4c4dc5",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : <?php echo json_encode($arr_salse_offline) ?>
		}
	]

}

<?php 
$arr_items= array();
$arr_dsalse = array();
$today=date('y-m-d');//".date('y-m-d')."
$sql="SELECT I.prd_id,P.prd_name,SUM(inv_prd_qnty),SUM(inv_prd_tot) FROM tbl_products P,tbl_inv_info I WHERE I.prd_id=P.prd_id AND I.inv_date='$today' GROUP BY prd_id;";
$res=mysqli_query($GLOBALS['conn'],$sql) or die("SQL Error:".mysqli_error($GLOBALS['conn']));
while($row=mysqli_fetch_assoc($res)){
	
	array_push($arr_items,$row['prd_name']);	
	array_push($arr_dsalse,number_format($row['SUM(inv_prd_tot)'],2,'.',''));	

}

?>

//bar chart for daily product sales
var barChartData = {
	labels : <?php echo json_encode($arr_items) ?>,
	datasets : [
		{
			fillColor : "rgba(253,65,0,0.5)",
			strokeColor : "rgba(220,220,220,0)",
			highlightFill: "rgba(253,65,0,0.75)",
			highlightStroke: "rgba(220,220,220,0)",
			data : <?php echo json_encode($arr_dsalse) ?>
		}
	]

}

window.onload = function(){
	var ctx = document.getElementById("canvas-monthly-sales").getContext("2d");
	window.myLine = new Chart(ctx).Bar(barSalesChartData, {
		responsive: true
	});
	
	var ctx = document.getElementById("canvas-product-sales").getContext("2d");
	window.myBar = new Chart(ctx).Bar(barChartData, {
		responsive : true
	});
	startTime();
}
	</script>