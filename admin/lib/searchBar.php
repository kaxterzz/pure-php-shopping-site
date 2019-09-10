<?php
require_once('../lib/connection.php');
if(isset($_GET['type'])){
	$type=$_GET['type'];
	
	switch($type){
		//View Batch
		case 'viewAllBatch':
			viewAllBatch();
		break;
		case 'searchBatchid':
			searchBatchid();
		break;
		case 'searchBatchDate':
			searchBatchDate();
		break;
		case 'searchBatchN':
			searchBatchN();
		break;
		//view customers
		case 'viewAllCus':
			viewAllCus();
		break;
		case 'viewAllOnlnCus':	
			viewAllOnlnCus();
		break;		
		case 'searchCusid':
			searchCusid();
		break;	
		case 'searchByCusfname':
			searchByCusfname();
		break;	
		case 'searchByCuslname':
			searchByCuslname();
		break;
		//view sales orders
		case 'viewAllInv':
			viewAllInv();
		break;
		case 'viewAllOnlnInv':
			viewAllOnlnInv();
		break;
		case 'searchInvid':
			searchInvid();
		break;
		case 'searchInvDate':	
			searchInvDate();
		break;	
		case 'searchByInvCusfname':	
			searchByInvCusfname();
		break;
		//view current stock
		case 'viewAllCurrentStock':
			viewAllCurrentStock();
		break;
		case 'searchCurrentPrdid':
			searchCurrentPrdid();
		break;
		case 'searchCurrentCat':
			searchCurrentCat();
		break;	
		case 'searchCurrentBrand':
			searchCurrentBrand();
		break;
		case 'searchCurrentPrdName':
			searchCurrentPrdName();
		break;
		//view on product view
		case 'viewAllProducts':	
			viewAllProducts();
		break;		
		case 'searchPrdid':
			searchPrdid();
		break;
		case 'searchCat':
			searchCat();
		break;		
		case 'searchBrand':
			searchBrand();
		break;
		case 'searchPrdName':
			searchPrdName();
		break;							
	}
}
 
function viewAllBatch(){
		$sql_select="SELECT B.batch_id,P.prd_name,B.batch_date,B.batch_qnty,B.batch_prd_cost_price,B.batch_prd_sell_price,S.sup_comp,B.batch_stat FROM tbl_batch B JOIN tbl_products P ON B.prd_id=P.prd_id JOIN tbl_supplier S ON B.sup_id=S.sup_id WHERE B.batch_stat=1;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['batch_stat'];
						if($status=='1'){
							$stat='Enable';
						}
						elseif($status=='0'){
							$stat="Disable";
						}			  
			echo'<tr>
                <td>'.$row['batch_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['batch_date'].'</td>
                <td>'.$row['batch_qnty'].'</td>
                <td>'.$row['batch_prd_cost_price'].'</td>
                <td>'.$row['batch_prd_sell_price'].'</td>
                <td>'.$row['sup_comp'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_batch.php?action=edit&amp;id='.$row['batch_id'].'" title="Edit"></a>&nbsp;&nbsp;';
			$del = '<a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_batch.php?action=delete&amp;id=".$row['batch_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';					
 }
 
function searchBatchid(){
	$batchid=$_POST['bid'];	
	$sql_select="SELECT B.batch_id,P.prd_name,B.batch_date,B.batch_qnty,B.batch_prd_cost_price,B.batch_prd_sell_price,S.sup_comp,B.batch_stat FROM tbl_batch B JOIN tbl_products P ON B.prd_id=P.prd_id JOIN tbl_supplier S ON B.sup_id=S.sup_id WHERE B.batch_id='$batchid' AND B.batch_stat=1;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['batch_stat'];
						if($status=='1'){
							$stat='Enable';
						}
						elseif($status=='0'){
							$stat="Disable";
						}			  
			echo'<tr>
                <td>'.$row['batch_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['batch_date'].'</td>
                <td>'.$row['batch_qnty'].'</td>
                <td>'.$row['batch_prd_cost_price'].'</td>
                <td>'.$row['batch_prd_sell_price'].'</td>
                <td>'.$row['sup_comp'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_batch.php?action=edit&amp;id='.$row['batch_id'].'" title="Edit"></a>&nbsp;&nbsp;';
			$del = '<a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_batch.php?action=delete&amp;id=".$row['batch_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';
} 

function searchBatchDate(){
	$batchdate=$_POST['date'];
	$sql_select="SELECT B.batch_id,P.prd_name,B.batch_date,B.batch_qnty,B.batch_prd_cost_price,B.batch_prd_sell_price,S.sup_comp,B.batch_stat FROM tbl_batch B JOIN tbl_products P ON B.prd_id=P.prd_id JOIN tbl_supplier S ON B.sup_id=S.sup_id WHERE B.batch_date='$batchdate' AND B.batch_stat=1;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['batch_stat'];
						if($status=='1'){
							$stat='Enable';
						}
						elseif($status=='0'){
							$stat="Disable";
						}			  
			echo'<tr>
                <td>'.$row['batch_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['batch_date'].'</td>
                <td>'.$row['batch_qnty'].'</td>
                <td>'.$row['batch_prd_cost_price'].'</td>
                <td>'.$row['batch_prd_sell_price'].'</td>
                <td>'.$row['sup_comp'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_batch.php?action=edit&amp;id='.$row['batch_id'].'" title="Edit"></a>&nbsp;&nbsp;';
			$del = '<a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_batch.php?action=delete&amp;id=".$row['batch_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';
}

function searchBatchN(){
	$N=$_POST['n'];
	if($N!=''){
	$sql_select="SELECT B.batch_id,P.prd_name,B.batch_date,B.batch_qnty,B.batch_prd_cost_price,B.batch_prd_sell_price,S.sup_comp,B.batch_stat FROM tbl_batch B JOIN tbl_products P ON B.prd_id=P.prd_id JOIN tbl_supplier S ON B.sup_id=S.sup_id WHERE B.batch_stat=1 ORDER BY batch_id DESC LIMIT ".$N.";";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['batch_stat'];
						if($status=='1'){
							$stat='Enable';
						}
						elseif($status=='0'){
							$stat="Disable";
						}			  
			echo'<tr>
                <td>'.$row['batch_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['batch_date'].'</td>
                <td>'.$row['batch_qnty'].'</td>
                <td>'.$row['batch_prd_cost_price'].'</td>
                <td>'.$row['batch_prd_sell_price'].'</td>
                <td>'.$row['sup_comp'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_batch.php?action=edit&amp;id='.$row['batch_id'].'" title="Edit"></a>&nbsp;&nbsp;';
			$del = '<a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_batch.php?action=delete&amp;id=".$row['batch_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';
	}//if
}

function viewAllCus(){
	$sql_select="SELECT * FROM tbl_customer;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['cus_stat'];
						if($status=='1'){
							$stat='Active';
						}
						elseif($status=='0'){
							$stat="Deactive";
						}			  
			echo'<tr>
                <td>'.$row['cus_id'].'</td>
                <td>'.$row['cus_fname'].'</td>
                <td>'.$row['cus_lname'].'</td>';
				$gender=$row['cus_gen'];
						if($gender=='1'){
							$gen='Male';
						}
						elseif($gender=='0'){
							$gen="Female";
						}
           echo'<td>'.$gen.'</td>
                <td>'.$row['cus_add'].' '.$row['cus_add2'].' '.$row['cus_city'].'</td>
                <td>'.$row['cus_tel'].'</td>
                <td>'.$row['cus_email'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_cus.php?action=edit&amp;id='.$row['cus_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_cus.php?action=delete&amp;id=".$row['cus_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';
}

function viewAllOnlnCus(){
$sql_select="SELECT * FROM tbl_customer WHERE cus_online='1';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['cus_stat'];
						if($status=='1'){
							$stat='Active';
						}
						elseif($status=='0'){
							$stat="Deactive";
						}			  
			echo'<tr>
                <td>'.$row['cus_id'].'</td>
                <td>'.$row['cus_fname'].'</td>
                <td>'.$row['cus_lname'].'</td>';
                $gender=$row['cus_gen'];
						if($gender=='1'){
							$gen='Male';
						}
						elseif($gender=='0'){
							$gen="Female";
						}
           echo'<td>'.$gen.'</td>
                <td>'.$row['cus_add'].' '.$row['cus_add2'].' '.$row['cus_city'].'</td>
                <td>'.$row['cus_tel'].'</td>
                <td>'.$row['cus_email'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_cus.php?action=edit&amp;id='.$row['cus_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_cus.php?action=delete&amp;id=".$row['cus_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchCusid(){
	$cid=$_POST['cid'];
	$sql_select="SELECT * FROM tbl_customer WHERE cus_id='$cid';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['cus_stat'];
						if($status=='1'){
							$stat='Active';
						}
						elseif($status=='0'){
							$stat="Deactive";
						}			  
			echo'<tr>
                <td>'.$row['cus_id'].'</td>
                <td>'.$row['cus_fname'].'</td>
                <td>'.$row['cus_lname'].'</td>';
                $gender=$row['cus_gen'];
						if($gender=='1'){
							$gen='Male';
						}
						elseif($gender=='0'){
							$gen="Female";
						}
           echo'<td>'.$gen.'</td>
                <td>'.$row['cus_add'].' '.$row['cus_add2'].' '.$row['cus_city'].'</td>
                <td>'.$row['cus_tel'].'</td>
                <td>'.$row['cus_email'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_cus.php?action=edit&amp;id='.$row['cus_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_cus.php?action=delete&amp;id=".$row['cus_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchByCusfname(){
	$fname=$_POST['fname'];
	$sql_select="SELECT * FROM tbl_customer WHERE cus_fname LIKE '$fname%';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['cus_stat'];
						if($status=='1'){
							$stat='Active';
						}
						elseif($status=='0'){
							$stat="Deactive";
						}			  
			echo'<tr>
                <td>'.$row['cus_id'].'</td>
                <td>'.$row['cus_fname'].'</td>
                <td>'.$row['cus_lname'].'</td>';
                $gender=$row['cus_gen'];
						if($gender=='1'){
							$gen='Male';
						}
						elseif($gender=='0'){
							$gen="Female";
						}
           echo'<td>'.$gen.'</td>
                <td>'.$row['cus_add'].' '.$row['cus_add2'].' '.$row['cus_city'].'</td>
                <td>'.$row['cus_tel'].'</td>
                <td>'.$row['cus_email'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_cus.php?action=edit&amp;id='.$row['cus_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_cus.php?action=delete&amp;id=".$row['cus_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchByCuslname(){
	$lname=$_POST['lname'];
	$sql_select="SELECT * FROM tbl_customer WHERE cus_lname LIKE '$lname%';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){
					$status=$row['cus_stat'];
						if($status=='1'){
							$stat='Active';
						}
						elseif($status=='0'){
							$stat="Deactive";
						}			  
			echo'<tr>
                <td>'.$row['cus_id'].'</td>
                <td>'.$row['cus_fname'].'</td>
                <td>'.$row['cus_lname'].'</td>';
                $gender=$row['cus_gen'];
						if($gender=='1'){
							$gen='Male';
						}
						elseif($gender=='0'){
							$gen="Female";
						}
           echo'<td>'.$gen.'</td>
                <td>'.$row['cus_add'].' '.$row['cus_add2'].' '.$row['cus_city'].'</td>
                <td>'.$row['cus_tel'].'</td>
                <td>'.$row['cus_email'].'</td>';
				
            echo '<td>'.$stat.'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_cus.php?action=edit&amp;id='.$row['cus_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_cus.php?action=delete&amp;id=".$row['cus_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function viewAllInv(){
	$sql_select="SELECT I.inv_id,C.cus_fname,C.cus_lname,I.inv_date,I.inv_gtot,I.inv_disc,I.inv_ntot,I.inv_emp_id FROM tbl_invoice I,tbl_customer C WHERE I.inv_cus_id=C.cus_id;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['inv_id'].'</td>
                <td>'.$row['cus_fname'].' '.$row['cus_lname'].'</td>
                <td>'.$row['inv_date'].'</td>';
           echo '<td>'.$row['inv_gtot'].'</td>
                <td>'.$row['inv_disc'].'</td>
                <td>'.$row['inv_ntot'].'</td>
				<td>'.$row['inv_emp_id'].'</td>';
			echo '<td>';
			echo '<a class="btnLoadOrderPrdData" role="button" id="btnviewprdorder" name="btnviewprdorder" data-type="view" data-id="'.$row['inv_id'].'" type="button" data-toggle="modal" data-target="#ModelWindow"><span class="glyphicon glyphicon-eye-open"></span> View Details</a></td>';
            echo '</tr>';
   	 }//end while
	}//end else
   echo '<a class="glyphicon glyphicon-pencil link-edit" href="add_cus.php?action=edit&amp;id='.$row['cus_id'].'" title="Edit"></a></td>';
		echo'</table>';	
}

function viewAllOnlnInv(){
	$sql_select="SELECT I.inv_id,C.cus_fname,C.cus_lname,I.inv_date,I.inv_gtot,I.inv_disc,I.inv_ntot,I.inv_emp_id FROM tbl_invoice I,tbl_customer C WHERE I.inv_cus_id=C.cus_id AND inv_online='1';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['inv_id'].'</td>
                <td>'.$row['cus_fname'].' '.$row['cus_lname'].'</td>
                <td>'.$row['inv_date'].'</td>';
           echo '<td>'.$row['inv_gtot'].'</td>
                <td>'.$row['inv_disc'].'</td>
                <td>'.$row['inv_ntot'].'</td>
				<td>'.$row['inv_emp_id'].'</td>';
			echo '<td>';
			echo '<a class="btnLoadOrderPrdData" role="button" id="btnviewprdorder" name="btnviewprdorder" data-type="view" data-id="'.$row['inv_id'].'" type="button" data-toggle="modal" data-target="#ModelWindow"><span class="glyphicon glyphicon-eye-open"></span> View Details</a></td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';		
}

function searchInvid(){
	$invid=$_POST['invid'];
	$sql_select="SELECT I.inv_id,C.cus_fname,C.cus_lname,I.inv_date,I.inv_gtot,I.inv_disc,I.inv_ntot,I.inv_emp_id FROM tbl_invoice I,tbl_customer C WHERE I.inv_cus_id=C.cus_id AND inv_id='$invid';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['inv_id'].'</td>
                <td>'.$row['cus_fname'].' '.$row['cus_lname'].'</td>
                <td>'.$row['inv_date'].'</td>';
           echo '<td>'.$row['inv_gtot'].'</td>
                <td>'.$row['inv_disc'].'</td>
                <td>'.$row['inv_ntot'].'</td>
				<td>'.$row['inv_emp_id'].'</td>';
			echo '<td>';
			echo '<a class="btnLoadOrderPrdData" role="button" id="btnviewprdorder" name="btnviewprdorder" data-type="view" data-id="'.$row['inv_id'].'" type="button" data-toggle="modal" data-target="#ModelWindow"><span class="glyphicon glyphicon-eye-open"></span> View Details</a></td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchInvDate(){
	$date=$_POST['date'];
	$sql_select="SELECT I.inv_id,C.cus_fname,C.cus_lname,I.inv_date,I.inv_gtot,I.inv_disc,I.inv_ntot,I.inv_emp_id FROM tbl_invoice I,tbl_customer C WHERE I.inv_cus_id=C.cus_id AND inv_date='$date';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['inv_id'].'</td>
                <td>'.$row['cus_fname'].' '.$row['cus_lname'].'</td>
                <td>'.$row['inv_date'].'</td>';
           echo '<td>'.$row['inv_gtot'].'</td>
                <td>'.$row['inv_disc'].'</td>
                <td>'.$row['inv_ntot'].'</td>
				<td>'.$row['inv_emp_id'].'</td>';
			echo '<td>';
			echo '<a class="btnLoadOrderPrdData" role="button" id="btnviewprdorder" name="btnviewprdorder" data-type="view" data-id="'.$row['inv_id'].'" type="button" data-toggle="modal" data-target="#ModelWindow"><span class="glyphicon glyphicon-eye-open"></span> View Details</a></td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchByInvCusfname(){
$fname=$_POST['fname'];
	$sql_select="SELECT I.inv_id,C.cus_fname,C.cus_lname,I.inv_date,I.inv_gtot,I.inv_disc,I.inv_ntot,I.inv_emp_id FROM tbl_invoice I,tbl_customer C WHERE I.inv_cus_id=C.cus_id AND C.cus_fname LIKE '$fname%';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['inv_id'].'</td>
                <td>'.$row['cus_fname'].' '.$row['cus_lname'].'</td>
                <td>'.$row['inv_date'].'</td>';
           echo '<td>'.$row['inv_gtot'].'</td>
                <td>'.$row['inv_disc'].'</td>
                <td>'.$row['inv_ntot'].'</td>
				<td>'.$row['inv_emp_id'].'</td>';
			echo '<td>';
			echo '<a class="btnLoadOrderPrdData" role="button" id="btnviewprdorder" name="btnviewprdorder" data-type="view" data-id="'.$row['inv_id'].'" type="button" data-toggle="modal" data-target="#ModelWindow"><span class="glyphicon glyphicon-eye-open"></span> View Details</a></td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function viewAllCurrentStock(){
		 $sql_select="SELECT P.prd_id,P.prd_name,C.cat_name,BR.brand_name,P.prd_img_path,P.prd_tot_qnty,B.batch_prd_cost_price,P.prd_price,S.sup_comp FROM tbl_batch B,tbl_products P,tbl_supplier S,tbl_category C,tbl_brand BR WHERE B.prd_id=P.prd_id AND B.sup_id=S.sup_id AND P.cat_id=C.cat_id AND P.brand_id=BR.brand_id AND P.prd_stat=1 GROUP BY P.prd_id;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_tot_qnty'].'</td>
				<td>'.$row['batch_prd_cost_price'].'</td>
				<td>'.$row['prd_price'].'</td>
				<td>'.$row['sup_comp'].'</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';		
}
function searchCurrentPrdid(){
	$prdid=$_POST['pid'];
	$sql_select="SELECT P.prd_id,P.prd_name,C.cat_name,BR.brand_name,P.prd_img_path,P.prd_tot_qnty,B.batch_prd_cost_price,P.prd_price,S.sup_comp FROM tbl_batch B,tbl_products P,tbl_supplier S,tbl_category C,tbl_brand BR WHERE B.prd_id=P.prd_id AND B.sup_id=S.sup_id AND P.cat_id=C.cat_id AND P.brand_id=BR.brand_id AND P.prd_stat=1 AND P.prd_id='$prdid' GROUP BY P.prd_id;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_tot_qnty'].'</td>
				<td>'.$row['batch_prd_cost_price'].'</td>
				<td>'.$row['prd_price'].'</td>
				<td>'.$row['sup_comp'].'</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';			
}

function searchCurrentCat(){
	$cat=$_POST['cat'];
	$sql_select="SELECT P.prd_id,P.prd_name,C.cat_name,BR.brand_name,P.prd_img_path,P.prd_tot_qnty,B.batch_prd_cost_price,P.prd_price,S.sup_comp FROM tbl_batch B,tbl_products P,tbl_supplier S,tbl_category C,tbl_brand BR WHERE B.prd_id=P.prd_id AND B.sup_id=S.sup_id AND P.cat_id=C.cat_id AND P.brand_id=BR.brand_id AND P.prd_stat=1 AND P.cat_id='$cat' GROUP BY P.prd_id;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_tot_qnty'].'</td>
				<td>'.$row['batch_prd_cost_price'].'</td>
				<td>'.$row['prd_price'].'</td>
				<td>'.$row['sup_comp'].'</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';		
}

function searchCurrentBrand(){
	$brand=$_POST['brand'];
	$sql_select="SELECT P.prd_id,P.prd_name,C.cat_name,BR.brand_name,P.prd_img_path,P.prd_tot_qnty,B.batch_prd_cost_price,P.prd_price,S.sup_comp FROM tbl_batch B,tbl_products P,tbl_supplier S,tbl_category C,tbl_brand BR WHERE B.prd_id=P.prd_id AND B.sup_id=S.sup_id AND P.cat_id=C.cat_id AND P.brand_id=BR.brand_id AND P.prd_stat=1 AND P.brand_id='$brand' GROUP BY P.prd_id;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_tot_qnty'].'</td>
				<td>'.$row['batch_prd_cost_price'].'</td>
				<td>'.$row['prd_price'].'</td>
				<td>'.$row['sup_comp'].'</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchCurrentPrdName(){
	$prdname=$_POST['prdname'];
	$sql_select="SELECT P.prd_id,P.prd_name,C.cat_name,BR.brand_name,P.prd_img_path,P.prd_tot_qnty,B.batch_prd_cost_price,P.prd_price,S.sup_comp FROM tbl_batch B,tbl_products P,tbl_supplier S,tbl_category C,tbl_brand BR WHERE B.prd_id=P.prd_id AND B.sup_id=S.sup_id AND P.cat_id=C.cat_id AND P.brand_id=BR.brand_id AND P.prd_stat=1 AND P.prd_name LIKE '$prdname%' GROUP BY P.prd_id;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_tot_qnty'].'</td>
				<td>'.$row['batch_prd_cost_price'].'</td>
				<td>'.$row['prd_price'].'</td>
				<td>'.$row['sup_comp'].'</td>';
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function viewAllProducts(){
$sql_select="SELECT P.prd_id,P.prd_name,P.cat_id,C.cat_name,B.brand_name,P.prd_img_path,P.prd_reorder_lvl,P.prd_stat FROM tbl_category C JOIN tbl_products P ON C.cat_id=P.cat_id JOIN tbl_brand B ON P.brand_id=B.brand_id WHERE P.prd_stat=1;";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_reorder_lvl'].'</td>
				<td>'.$row['prd_stat'].'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="edit_product.php?id='.$row['prd_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_product.php?action=delete&amp;id=".$row['prd_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>'; 	
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';		
}

function searchPrdid(){
$pid=$_POST['pid'];		
$sql_select="SELECT P.prd_id,P.prd_name,P.cat_id,C.cat_name,B.brand_name,P.prd_img_path,P.prd_reorder_lvl,P.prd_stat FROM tbl_category C JOIN tbl_products P ON C.cat_id=P.cat_id JOIN tbl_brand B ON P.brand_id=B.brand_id WHERE P.prd_stat=1 AND  p.prd_id='$pid';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_reorder_lvl'].'</td>
				<td>'.$row['prd_stat'].'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="edit_product.php?id='.$row['prd_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_product.php?action=delete&amp;id=".$row['prd_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>'; 	
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchCat(){
$cat=$_POST['cat'];		
$sql_select="SELECT P.prd_id,P.prd_name,P.cat_id,C.cat_name,B.brand_name,P.prd_img_path,P.prd_reorder_lvl,P.prd_stat FROM tbl_category C JOIN tbl_products P ON C.cat_id=P.cat_id JOIN tbl_brand B ON P.brand_id=B.brand_id WHERE P.prd_stat=1 AND  C.cat_id='$cat';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_reorder_lvl'].'</td>
				<td>'.$row['prd_stat'].'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="edit_product.php?id='.$row['prd_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_product.php?action=delete&amp;id=".$row['prd_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>'; 	
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchBrand(){
$brand=$_POST['brand'];		
$sql_select="SELECT P.prd_id,P.prd_name,P.cat_id,C.cat_name,B.brand_name,P.prd_img_path,P.prd_reorder_lvl,P.prd_stat FROM tbl_category C JOIN tbl_products P ON C.cat_id=P.cat_id JOIN tbl_brand B ON P.brand_id=B.brand_id WHERE P.prd_stat=1 AND  B.brand_id='$brand';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_reorder_lvl'].'</td>
				<td>'.$row['prd_stat'].'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="edit_product.php?id='.$row['prd_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_product.php?action=delete&amp;id=".$row['prd_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>'; 	
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}

function searchPrdName(){
$prdname=$_POST['prdname'];	
$sql_select="SELECT P.prd_id,P.prd_name,P.cat_id,C.cat_name,B.brand_name,P.prd_img_path,P.prd_reorder_lvl,P.prd_stat FROM tbl_category C JOIN tbl_products P ON C.cat_id=P.cat_id JOIN tbl_brand B ON P.brand_id=B.brand_id WHERE P.prd_stat=1 AND  P.prd_name LIKE '$prdname%';";
		 $result=mysqli_query($conn,$sql_select) or die("MYSQL Error:".mysqli_error()); 
		echo '<table class="table table-responsive">';					  
		$nor=mysqli_num_rows($result);
			if($nor==0)
				echo "No Records Found";
			
			else{	
				while($row=mysqli_fetch_assoc($result)){			  
			echo'<tr>
                <td>'.$row['prd_id'].'</td>
                <td>'.$row['prd_name'].'</td>
                <td>'.$row['cat_name'].'</td>';
           echo '<td>'.$row['brand_name'].'</td>
                <td><img class="img-responsive" src="../images/products/'.$row['prd_img_path'].'" width="120px" height="100px"/></td>
                <td>'.$row['prd_reorder_lvl'].'</td>
				<td>'.$row['prd_stat'].'</td>';
			echo '<td>';
			echo '<a class="glyphicon glyphicon-pencil link-edit" href="edit_product.php?id='.$row['prd_id'].'" title="Edit"></a></td>';
			$del = '<td><a class="glyphicon glyphicon-remove link-delete" onclick="confirmDelete(';
			$del .= "'view_product.php?action=delete&amp;id=".$row['prd_id']."'";
			$del .= ');" href="javascript:void(0);" title="Delete"></a>';
			echo $del;
			echo '</td>'; 	
            echo '</tr>';
   	 }//end while
	}//end else
   
		echo'</table>';	
}
?>