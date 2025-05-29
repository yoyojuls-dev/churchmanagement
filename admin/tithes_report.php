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
		              $('#print').tooltip('show');
		              $('#print').tooltip('hide');
		              });
		             </script> 
					 
					 <div id="sc" align="center"><image src="images/sclogo.png" width="45%" height="45%"/></div>
					 
					 <h2 align="center">Tithes Report</h2>
					 
					 <!-- Filter Options -->
					 <div class="row-fluid">
					     <div class="span12">
					         <form method="GET" class="form-horizontal">
					             <div class="control-group">
					                 <label class="control-label">Date Range:</label>
					                 <div class="controls">
					                     <input type="date" name="date_from" value="<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>" class="input-medium">
					                     <span>to</span>
					                     <input type="date" name="date_to" value="<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>" class="input-medium">
					                     <button type="submit" class="btn btn-primary">Filter</button>
					                     <a href="tithes_report.php" class="btn">Clear</a>
					                 </div>
					             </div>
					         </form>
					     </div>
					 </div>
					 
					 <?php
					 // Build date filter query
					 $date_filter = "";
					 if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
					     $date_from = $_GET['date_from'];
					     $date_filter .= " AND DATE(paytime) >= '$date_from'";
					 }
					 if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
					     $date_to = $_GET['date_to'];
					     $date_filter .= " AND DATE(paytime) <= '$date_to'";
					 }
					 
					 // Get summary statistics
					 $summary_query = mysqli_query($conn, "SELECT 
					     COUNT(*) as total_records,
					     SUM(amount) as total_amount,
					     AVG(amount) as average_amount,
					     MIN(amount) as min_amount,
					     MAX(amount) as max_amount
					     FROM tithe WHERE 1=1 $date_filter") or die(mysqli_error());
					 $summary = mysqli_fetch_array($summary_query);
					 
					 // Get monthly breakdown
					 $monthly_query = mysqli_query($conn, "SELECT 
					     DATE_FORMAT(paytime, '%Y-%m') as month,
					     COUNT(*) as count,
					     SUM(amount) as total
					     FROM tithe WHERE 1=1 $date_filter
					     GROUP BY DATE_FORMAT(paytime, '%Y-%m')
					     ORDER BY month DESC") or die(mysqli_error());
					 
					 // Get transaction type breakdown
					 $type_query = mysqli_query($conn, "SELECT 
					     ttype,
					     COUNT(*) as count,
					     SUM(amount) as total
					     FROM tithe WHERE 1=1 $date_filter
					     GROUP BY ttype
					     ORDER BY total DESC") or die(mysqli_error());
					 
					 // Get purpose breakdown
					 $purpose_query = mysqli_query($conn, "SELECT 
					     purpose,
					     COUNT(*) as count,
					     SUM(amount) as total
					     FROM tithe WHERE 1=1 $date_filter
					     GROUP BY purpose
					     ORDER BY total DESC") or die(mysqli_error());
					 ?>
					 
					 <!-- Summary Cards -->
					 <div class="row-fluid">
					     <div class="span3">
					         <div class="block">
					             <div class="block-content">
					                 <h3 align="center">₱<?php echo number_format($summary['total_amount'], 2); ?></h3>
					                 <p align="center"><strong>Total Tithes</strong></p>
					             </div>
					         </div>
					     </div>
					     <div class="span3">
					         <div class="block">
					             <div class="block-content">
					                 <h3 align="center"><?php echo $summary['total_records']; ?></h3>
					                 <p align="center"><strong>Total Records</strong></p>
					             </div>
					         </div>
					     </div>
					     <div class="span3">
					         <div class="block">
					             <div class="block-content">
					                 <h3 align="center">₱<?php echo number_format($summary['average_amount'], 2); ?></h3>
					                 <p align="center"><strong>Average Amount</strong></p>
					             </div>
					         </div>
					     </div>
					     <div class="span3">
					         <div class="block">
					             <div class="block-content">
					                 <h3 align="center">₱<?php echo number_format($summary['max_amount'], 2); ?></h3>
					                 <p align="center"><strong>Highest Amount</strong></p>
					             </div>
					         </div>
					     </div>
					 </div>
					 
					 <!-- Monthly Breakdown -->
					 <div class="row-fluid">
					     <div class="span6">
					         <div id="block_bg" class="block">
					             <div class="navbar navbar-inner block-header">
					                 <div class="muted pull-left"><i class="icon-calendar"></i> Monthly Breakdown</div>
					             </div>
					             <div class="block-content collapse in">
					                 <table class="table table-striped">
					                     <thead>
					                         <tr>
					                             <th>Month</th>
					                             <th>Count</th>
					                             <th>Total Amount</th>
					                         </tr>
					                     </thead>
					                     <tbody>
					                         <?php while($month_row = mysqli_fetch_array($monthly_query)): ?>
					                         <tr>
					                             <td><?php echo date('F Y', strtotime($month_row['month'] . '-01')); ?></td>
					                             <td><?php echo $month_row['count']; ?></td>
					                             <td>₱<?php echo number_format($month_row['total'], 2); ?></td>
					                         </tr>
					                         <?php endwhile; ?>
					                     </tbody>
					                 </table>
					             </div>
					         </div>
					     </div>
					     
					     <!-- Transaction Type Breakdown -->
					     <div class="span6">
					         <div id="block_bg" class="block">
					             <div class="navbar navbar-inner block-header">
					                 <div class="muted pull-left"><i class="icon-credit-card"></i> By Transaction Type</div>
					             </div>
					             <div class="block-content collapse in">
					                 <table class="table table-striped">
					                     <thead>
					                         <tr>
					                             <th>Transaction Type</th>
					                             <th>Count</th>
					                             <th>Total Amount</th>
					                         </tr>
					                     </thead>
					                     <tbody>
					                         <?php while($type_row = mysqli_fetch_array($type_query)): ?>
					                         <tr>
					                             <td><?php echo $type_row['ttype']; ?></td>
					                             <td><?php echo $type_row['count']; ?></td>
					                             <td>₱<?php echo number_format($type_row['total'], 2); ?></td>
					                         </tr>
					                         <?php endwhile; ?>
					                     </tbody>
					                 </table>
					             </div>
					         </div>
					     </div>
					 </div>
					 
					 <!-- Purpose Breakdown -->
					 <div class="row-fluid">
					     <div class="span12">
					         <div id="block_bg" class="block">
					             <div class="navbar navbar-inner block-header">
					                 <div class="muted pull-left"><i class="icon-list"></i> By Purpose</div>
					             </div>
					             <div class="block-content collapse in">
					                 <table class="table table-striped">
					                     <thead>
					                         <tr>
					                             <th>Purpose</th>
					                             <th>Count</th>
					                             <th>Total Amount</th>
					                             <th>Percentage</th>
					                         </tr>
					                     </thead>
					                     <tbody>
					                         <?php while($purpose_row = mysqli_fetch_array($purpose_query)): 
					                             $percentage = ($purpose_row['total'] / $summary['total_amount']) * 100;
					                         ?>
					                         <tr>
					                             <td><?php echo $purpose_row['purpose']; ?></td>
					                             <td><?php echo $purpose_row['count']; ?></td>
					                             <td>₱<?php echo number_format($purpose_row['total'], 2); ?></td>
					                             <td><?php echo number_format($percentage, 1); ?>%</td>
					                         </tr>
					                         <?php endwhile; ?>
					                     </tbody>
					                 </table>
					             </div>
					         </div>
					     </div>
					 </div>
					 
					 <!-- Detailed Records -->
					 <?php
					 $detailed_query = mysqli_query($conn, "SELECT * FROM tithe WHERE 1=1 $date_filter ORDER BY paytime DESC") or die(mysqli_error());
					 $detailed_count = mysqli_num_rows($detailed_query);
					 ?>
					 
					 <div class="row-fluid">
					     <div class="span12">
					         <div id="block_bg" class="block">
					             <div class="navbar navbar-inner block-header">
					                 <div class="muted pull-left"><i class="icon-list-alt"></i> Detailed Records (<?php echo $detailed_count; ?>)</div>
					                 <div class="muted pull-right">
					                     <a href="print_tithe_report.php<?php echo !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''; ?>" 
					                        class="btn btn-info" target="_blank">
					                         <i class="icon-print"></i> Print Report
					                     </a>
					                 </div>
					             </div>
					             <div class="block-content collapse in">
					                 <table class="table table-striped" id="tithes-table">
					                     <thead>
					                         <tr>
					                             <th>Date</th>
					                             <th>Name</th>
					                             <th>Gender</th>
					                             <th>Amount</th>
					                             <th>Transaction Code</th>
					                             <th>Type</th>
					                             <th>Purpose</th>
					                             <th>Mobile</th>
					                         </tr>
					                     </thead>
					                     <tbody>
					                         <?php while($detail_row = mysqli_fetch_array($detailed_query)): ?>
					                         <tr>
					                             <td><?php echo date('M d, Y', strtotime($detail_row['paytime'])); ?></td>
					                             <td><?php echo $detail_row['name']; ?></td>
					                             <td><?php echo $detail_row['gender']; ?></td>
					                             <td>₱<?php echo number_format($detail_row['amount'], 2); ?></td>
					                             <td><?php echo $detail_row['trcode']; ?></td>
					                             <td><?php echo $detail_row['ttype']; ?></td>
					                             <td><?php echo $detail_row['purpose']; ?></td>
					                             <td><?php echo $detail_row['na']; ?></td>
					                         </tr>
					                         <?php endwhile; ?>
					                     </tbody>
					                 </table>
					             </div>
					         </div>
					     </div>
					 </div>
					 
					 <h4 id="sc">Generated on: 
					     <?php
					         $date = new DateTime();
					         echo $date->format('l, F jS, Y \a\t g:i A');
					     ?>
					 </h4>
					 
				</div>
			</div>
		</div>
		
		<?php include('footer.php'); ?>
		<?php include('script.php'); ?>
		
		<script>
		$(document).ready(function() {
		    $('#tithes-table').dataTable({
		        "bPaginate": true,
		        "bLengthChange": true,
		        "bFilter": true,
		        "bSort": true,
		        "bInfo": true,
		        "bAutoWidth": false,
		        "pageLength": 20,
		        "order": [[ 0, "desc" ]]
		    });
		});
		</script>
		
    </body>
</html>