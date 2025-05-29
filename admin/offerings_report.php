<?php include('header.php'); ?>
<?php include('session.php'); ?>
    <body>
		<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('sidebar.php'); ?>
			
				<div class="span9" id="content">
                     <div class="row-fluid">
					 
					  <script type="text/javascript">
		              $(document).ready(function(){
		              $('#add').tooltip('show');
		              $('#add').tooltip('hide');
		              });
		             </script> 
					 <div id="sc" align="center"><image src="images/sclogo.png" width="45%" height="45%"/></div>
				
				<!-- Summary Cards -->
				<div class="row-fluid" style="margin-bottom: 20px;">
					<?php
					// Get summary statistics
					$total_offerings = mysqli_query($conn,"SELECT SUM(CAST(Amount as DECIMAL(10,2))) as total FROM offering");
					$total_amount = mysqli_fetch_array($total_offerings)['total'];
					
					$count_offerings = mysqli_query($conn,"SELECT COUNT(*) as count FROM offering");
					$total_count = mysqli_fetch_array($count_offerings)['count'];
					
					$this_month = mysqli_query($conn,"SELECT SUM(CAST(Amount as DECIMAL(10,2))) as monthly FROM offering WHERE MONTH(paytime) = MONTH(CURRENT_DATE()) AND YEAR(paytime) = YEAR(CURRENT_DATE())");
					$monthly_amount = mysqli_fetch_array($this_month)['monthly'];
					?>
					
					<div class="span4">
						<div class="alert alert-info">
							<h4>Total Offerings</h4>
							<h3>₱<?php echo number_format($total_amount, 2); ?></h3>
						</div>
					</div>
					<div class="span4">
						<div class="alert alert-success">
							<h4>This Month</h4>
							<h3>₱<?php echo number_format($monthly_amount, 2); ?></h3>
						</div>
					</div>
					<div class="span4">
						<div class="alert alert-warning">
							<h4>Total Records</h4>
							<h3><?php echo $total_count; ?></h3>
						</div>
					</div>
				</div>
				
				<?php	
	             $count_student=mysqli_query($conn,"select * from offering");
	             $count = mysqli_num_rows($count_student);
                 ?>	 
				   <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                             <div class="muted pull-left"><i class="icon-reorder icon-large"></i> Offerings Report</div>
                          <div class="muted pull-right">
								Number of Offerings: <span class="badge badge-info"><?php  echo $count; ?></span>
							 </div>
						  </div>
						  
                 <h4 id="sc">Offerings Report
					<div align="right" id="sc">Date:
						<?php
                            $date = new DateTime();
                            echo $date->format('l, F jS, Y');
                         ?></div>
				 </h4>

				<!-- Filter Options -->
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="span12">
							<form method="GET" class="form-inline" style="margin-bottom: 15px;">
								<div class="control-group">
									<label class="control-label">Filter by Date Range:</label>
									<div class="controls">
										<input type="date" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>" class="input-small">
										<span>to</span>
										<input type="date" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" class="input-small">
										<button type="submit" class="btn btn-primary"><i class="icon-filter"></i> Filter</button>
										<a href="offerings_report.php" class="btn btn-default">Clear</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
													
				<div class="container-fluid">
				  <div class="row-fluid"> 
				     <div class="empty">
					     <div class="pull-right">
						   <a href="print_offerings_report.php<?php echo isset($_GET['start_date']) && isset($_GET['end_date']) ? '?start_date='.$_GET['start_date'].'&end_date='.$_GET['end_date'] : ''; ?>" class="btn btn-info" id="print" data-placement="left" title="Click to Print"><i class="icon-print icon-large"></i> Print Report</a> 		      
						   <script type="text/javascript">
						     $(document).ready(function(){
						     $('#print').tooltip('show');
						     $('#print').tooltip('hide');
						     });
						   </script>        	   
				         </div>
				      </div>
				    </div> 
				</div>
	
				<div class="block-content collapse in">
				    <div class="span12">
					<form action="" method="post">
				  	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="example">
						<thead>		
						        <tr>			        
				                	<th>Member Name</th>
									<th>Mobile No.</th>
									<th>Transaction Code</th>
									<th>Amount</th>
									<th>Transaction Type</th>
							       	<th>Date & Time</th>
			                   		
			                    				
						    </tr>
						</thead>
						<tbody>
						<!-----------------------------------Content------------------------------------>
						<?php
						// Build query based on filters
						$where_clause = "WHERE offering.offeringid != ''";
						if (isset($_GET['start_date']) && !empty($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['end_date'])) {
							$start_date = $_GET['start_date'];
							$end_date = $_GET['end_date'];
							$where_clause .= " AND DATE(offering.paytime) BETWEEN '$start_date' AND '$end_date'";
						}
						
						$student_query = mysqli_query($conn,"SELECT members.fname, members.lname, members.mobile, offering.* 
							FROM members  
							LEFT OUTER JOIN offering ON members.id = offering.na 
							$where_clause
							ORDER BY offering.paytime DESC") or die(mysqli_error());
						
						$total_filtered = 0;
						while($row = mysqli_fetch_array($student_query)){
							$username = $row['offeringid'];
							$total_filtered += floatval($row['Amount']);
						?>
										
						<tr>
							<td><?php echo $row['fname']." ".$row['lname']; ?></td>
						    <td><?php echo $row['mobile']; ?></td>
							<td><?php echo $row['Trcode']; ?></td>
							<td class="text-right">₱<?php echo number_format($row['Amount'], 2); ?></td>
							<td><?php echo $row['type'] ? $row['type'] : 'N/A'; ?></td>
							<td><?php echo date('M d, Y h:i A', strtotime($row['paytime'])); ?></td>
				        </tr>
										
						<?php } ?>   
				
						</tbody>
						<tfoot>
							<tr style="background-color: #f9f9f9; font-weight: bold;">
								<td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
								<td class="text-right"><strong>₱<?php echo number_format($total_filtered, 2); ?></strong></td>
								<td colspan="2"></td>
							</tr>
						</tfoot>
					</table>
					</form>	
					
					<!-- Monthly Summary Chart -->
					<div class="row-fluid" style="margin-top: 30px;">
						<div class="span12">
							<div class="block">
								<div class="navbar navbar-inner block-header">
									<div class="muted pull-left"><i class="icon-bar-chart"></i> Monthly Offerings Summary</div>
								</div>
								<div class="block-content collapse in">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Month</th>
												<th>Number of Offerings</th>
												<th>Total Amount</th>
												<th>Average Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$monthly_query = mysqli_query($conn,"
												SELECT 
													YEAR(paytime) as year,
													MONTH(paytime) as month,
													MONTHNAME(paytime) as month_name,
													COUNT(*) as count,
													SUM(CAST(Amount as DECIMAL(10,2))) as total,
													AVG(CAST(Amount as DECIMAL(10,2))) as average
												FROM offering 
												GROUP BY YEAR(paytime), MONTH(paytime)
												ORDER BY YEAR(paytime) DESC, MONTH(paytime) DESC
												LIMIT 12
											") or die(mysqli_error());
											
											while($monthly_row = mysqli_fetch_array($monthly_query)) {
											?>
											<tr>
												<td><?php echo $monthly_row['month_name'] . ' ' . $monthly_row['year']; ?></td>
												<td><?php echo $monthly_row['count']; ?></td>
												<td>₱<?php echo number_format($monthly_row['total'], 2); ?></td>
												<td>₱<?php echo number_format($monthly_row['average'], 2); ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Transaction Type Summary -->
					<div class="row-fluid" style="margin-top: 20px;">
						<div class="span12">
							<div class="block">
								<div class="navbar navbar-inner block-header">
									<div class="muted pull-left"><i class="icon-pie-chart"></i> Transaction Type Summary</div>
								</div>
								<div class="block-content collapse in">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Transaction Type</th>
												<th>Count</th>
												<th>Total Amount</th>
												<th>Percentage</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$type_query = mysqli_query($conn,"
												SELECT 
													COALESCE(type, 'Not Specified') as transaction_type,
													COUNT(*) as count,
													SUM(CAST(Amount as DECIMAL(10,2))) as total,
													(SUM(CAST(Amount as DECIMAL(10,2))) / (SELECT SUM(CAST(Amount as DECIMAL(10,2))) FROM offering) * 100) as percentage
												FROM offering 
												GROUP BY type
												ORDER BY total DESC
											") or die(mysqli_error());
											
											while($type_row = mysqli_fetch_array($type_query)) {
											?>
											<tr>
												<td><?php echo $type_row['transaction_type']; ?></td>
												<td><?php echo $type_row['count']; ?></td>
												<td>₱<?php echo number_format($type_row['total'], 2); ?></td>
												<td><?php echo number_format($type_row['percentage'], 1); ?>%</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				</div>
				</div>
				</div>
				</div>
		
		</div>	
		<?php include('footer.php'); ?>
		</div>
		<?php include('script.php'); ?>
		
		<script>
		$(document).ready(function() {
			$('#example').dataTable({
				"order": [[ 5, "desc" ]], // Sort by date column descending
				"pageLength": 25,
				"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
			});
		});
		</script>
	 </body>
</html>