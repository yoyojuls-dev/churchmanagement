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
				<?php	
	             $count_giving=mysqli_query($conn,"select * from giving");
	             $count = mysqli_num_rows($count_giving);
	             
	             // Calculate total amount
	             $total_query = mysqli_query($conn,"SELECT SUM(CAST(Amount AS DECIMAL(10,2))) as total_amount FROM giving");
	             $total_result = mysqli_fetch_array($total_query);
	             $total_amount = $total_result['total_amount'] ? $total_result['total_amount'] : 0;
                 ?>	 
				   <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                             <div class="muted pull-left"><i class="icon-reorder icon-large"></i> Givings Report & Management</div>
                          <div class="muted pull-right">
								Total Givings: <span class="badge badge-info"><?php  echo $count; ?></span> | 
								Total Amount: <span class="badge badge-success">₱<?php echo number_format($total_amount, 2); ?></span>
							 </div>
						  </div>
						  
                 <h4 id="sc">Givings List & Report
					<div align="right" id="sc">Date:
						<?php
                            $date = new DateTime();
                            echo $date->format('l, F jS, Y');
                         ?></div>
				 </h4>

													
<div class="container-fluid">
  <div class="row-fluid"> 
     <div class="empty">
	     <div class="pull-right">
		   <a href="print_givings_report.php" class="btn btn-info" id="print" data-placement="left" title="Click to Print Detailed Report"><i class="icon-print icon-large"></i> Print Detailed Report</a> 		      
		   <a href="addgiving.php" class="btn btn-success" id="add" data-placement="left" title="Click to Add New Giving"><i class="icon-plus icon-large"></i> Add Giving</a> 		      
		   <script type="text/javascript">
		     $(document).ready(function(){
		     $('#print').tooltip('show');
		     $('#print').tooltip('hide');
		     $('#add').tooltip('show');
		     $('#add').tooltip('hide');
		     });
		   </script>        	   
         </div>
      </div>
    </div> 
</div>

<!-- Summary Cards -->
<div class="row-fluid">
    <div class="span3">
        <div class="well well-small">
            <h4><i class="icon-money"></i> Total Amount</h4>
            <h3 class="text-success">₱<?php echo number_format($total_amount, 2); ?></h3>
        </div>
    </div>
    <div class="span3">
        <div class="well well-small">
            <h4><i class="icon-list"></i> Total Records</h4>
            <h3 class="text-info"><?php echo $count; ?></h3>
        </div>
    </div>
    <div class="span3">
        <div class="well well-small">
            <?php 
            $avg_amount = $count > 0 ? $total_amount / $count : 0;
            ?>
            <h4><i class="icon-signal"></i> Average Amount</h4>
            <h3 class="text-warning">₱<?php echo number_format($avg_amount, 2); ?></h3>
        </div>
    </div>
    <div class="span3">
        <div class="well well-small">
            <?php 
            $current_month_query = mysqli_query($conn,"SELECT SUM(CAST(Amount AS DECIMAL(10,2))) as month_total FROM giving WHERE MONTH(paytime) = MONTH(CURDATE()) AND YEAR(paytime) = YEAR(CURDATE())");
            $current_month_result = mysqli_fetch_array($current_month_query);
            $current_month_total = $current_month_result['month_total'] ? $current_month_result['month_total'] : 0;
            ?>
            <h4><i class="icon-calendar"></i> This Month</h4>
            <h3 class="text-primary">₱<?php echo number_format($current_month_total, 2); ?></h3>
        </div>
    </div>
</div>
	
<div class="block-content collapse in">
    <div class="span12">
	<form action="" method="post">
  	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
		<thead>		
		        <tr>			        
                	<th>Member Name</th>
					<th>Mobile No.</th>
					<th>Amount</th>
					<th>Transaction Code</th>
					<th>Purpose/For</th>
					<th>Payment Method</th>
			        <th>Date & Time</th>
					<th>Actions</th>
		        </tr>
		</thead>
<tbody>
<!-----------------------------------Content------------------------------------>
<?php
		$giving_query = mysqli_query($conn,"
		    SELECT g.*, m.fname, m.lname, m.mobile as member_mobile 
		    FROM giving g 
		    LEFT JOIN members m ON g.na = m.id 
		    ORDER BY g.paytime DESC
		") or die(mysqli_error());
		
		while($row = mysqli_fetch_array($giving_query)){
		    $givingid = $row['givingid'];
		    
		    // Handle member name
		    $member_name = 'Unknown Member';
		    if (!empty($row['fname']) && !empty($row['lname'])) {
		        $member_name = $row['fname'] . ' ' . $row['lname'];
		    }
		    
		    // Handle mobile number display
		    $display_mobile = !empty($row['member_mobile']) ? $row['member_mobile'] : $row['na'];
		    
		    // Format amount
		    $amount = floatval($row['Amount']);
		    
		    // Format date
		    $formatted_date = date('M d, Y', strtotime($row['paytime']));
		    $formatted_time = date('h:i A', strtotime($row['paytime']));
	
		?>
									
		<tr>
		    <td><strong><?php echo htmlspecialchars($member_name); ?></strong></td>
		    <td><?php echo htmlspecialchars($display_mobile); ?></td>
		    <td class="text-right"><span class="label <?php echo $amount >= 1000 ? 'label-success' : 'label-info'; ?>">₱<?php echo number_format($amount, 2); ?></span></td>
		    <td><code><?php echo htmlspecialchars($row['Trcode']); ?></code></td>
		    <td><?php echo htmlspecialchars($row['ya'] ? $row['ya'] : 'General Fund'); ?></td>
		    <td>
		        <?php 
		        $payment_method = !empty($row['type']) ? $row['type'] : 'Cash';
		        $badge_class = '';
		        switch(strtolower($payment_method)) {
		            case 'gcash': $badge_class = 'badge-info'; break;
		            case 'maya': $badge_class = 'badge-warning'; break;
		            case 'bdo': case 'bank': $badge_class = 'badge-important'; break;
		            default: $badge_class = 'badge-inverse';
		        }
		        ?>
		        <span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($payment_method); ?></span>
		    </td>
		    <td>
		        <?php echo $formatted_date; ?><br>
		        <small class="muted"><?php echo $formatted_time; ?></small>
		    </td>
		    <td>
		        <div class="btn-group">
		            <a href="#" class="btn btn-mini btn-info" title="View Details" data-toggle="tooltip">
		                <i class="icon-eye-open"></i>
		            </a>
		            <a href="#" class="btn btn-mini btn-warning" title="Edit Record" data-toggle="tooltip">
		                <i class="icon-edit"></i>
		            </a>
		        </div>
		    </td>
        </tr>
											
	<?php } ?>   

</tbody>
</table>
</form>	

<!-- Pagination or Load More could be added here for large datasets -->
		
</div>
</div>

<!-- Recent Givings by Purpose/Category -->
<div class="row-fluid">
    <div class="span6">
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><i class="icon-pie-chart"></i> Top Giving Categories</div>
            </div>
            <div class="block-content collapse in">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Purpose/Category</th>
                            <th>Count</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $category_query = mysqli_query($conn,"
                            SELECT 
                                COALESCE(NULLIF(ya, ''), 'General Fund') as purpose,
                                COUNT(*) as count,
                                SUM(CAST(Amount AS DECIMAL(10,2))) as total
                            FROM giving 
                            GROUP BY COALESCE(NULLIF(ya, ''), 'General Fund')
                            ORDER BY total DESC 
                            LIMIT 5
                        ");
                        while($cat = mysqli_fetch_array($category_query)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cat['purpose']); ?></td>
                            <td><span class="badge badge-info"><?php echo $cat['count']; ?></span></td>
                            <td class="text-right"><strong>₱<?php echo number_format($cat['total'], 2); ?></strong></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="span6">
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><i class="icon-calendar"></i> Monthly Trends</div>
            </div>
            <div class="block-content collapse in">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Records</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $monthly_query = mysqli_query($conn,"
                            SELECT 
                                DATE_FORMAT(paytime, '%Y-%m') as month,
                                DATE_FORMAT(paytime, '%M %Y') as month_name,
                                COUNT(*) as count,
                                SUM(CAST(Amount AS DECIMAL(10,2))) as total
                            FROM giving 
                            WHERE paytime >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                            GROUP BY DATE_FORMAT(paytime, '%Y-%m')
                            ORDER BY month DESC
                            LIMIT 6
                        ");
                        while($monthly = mysqli_fetch_array($monthly_query)) {
                        ?>
                        <tr>
                            <td><?php echo $monthly['month_name']; ?></td>
                            <td><span class="badge badge-info"><?php echo $monthly['count']; ?></span></td>
                            <td class="text-right"><strong>₱<?php echo number_format($monthly['total'], 2); ?></strong></td>
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
<?php include('footer.php'); ?>
</div>
<?php include('script.php'); ?>

<script>
// Additional JavaScript for enhanced functionality
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Add some basic filtering/search functionality
    $('#example').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "pageLength": 25,
        "order": [[ 6, "desc" ]], // Sort by date column by default
        "columnDefs": [
            { "orderable": false, "targets": 7 } // Disable sorting on Actions column
        ]
    });
});
</script>

<style>
.well h4 {
    margin-top: 0;
    color: #666;
}
.well h3 {
    margin-bottom: 0;
}
.text-success { color: #5cb85c !important; }
.text-info { color: #5bc0de !important; }
.text-warning { color: #f0ad4e !important; }
.text-primary { color: #428bca !important; }
.table th {
    background-color: #f5f5f5;
}
.badge-info { background-color: #5bc0de; }
.badge-warning { background-color: #f0ad4e; }
.badge-important { background-color: #d9534f; }
.badge-inverse { background-color: #333; }
code {
    color: #d14;
    background-color: #f7f7f9;
    border: 1px solid #e1e1e8;
}
</style>

</body>
</html>