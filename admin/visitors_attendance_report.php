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
	             $count_visitors=mysqli_query($conn,"select * from visitor");
	             $count = mysqli_num_rows($count_visitors);
                 ?>	 
				   <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                             <div class="muted pull-left"><i class="icon-reorder icon-large"></i> Visitors Attendance Report</div>
                          <div class="muted pull-right">
								Total Visitors Recorded: <span class="badge badge-info"><?php  echo $count; ?></span>
							 </div>
						  </div>
						  
                 <h4 id="sc">Visitors Attendance Report
					<div align="right" id="sc">Date:
						<?php
                            $date = new DateTime();
                            echo $date->format('l, F jS, Y');
                         ?></div>
				 </h4>

				 <!-- Filter Section -->
				 <div class="container-fluid">
                  <div class="row-fluid"> 
                     <div class="empty">
				         <div class="pull-left">
						   <form method="GET" action="visitors_attendance_report.php" class="form-inline">
							   <select name="event_filter" class="input-medium">
								   <option value="">All Events</option>
								   <option value="Sunday Service" <?php echo (isset($_GET['event_filter']) && $_GET['event_filter'] == 'Sunday Service') ? 'selected' : ''; ?>>Sunday Service</option>
								   <option value="Extreme Worship" <?php echo (isset($_GET['event_filter']) && $_GET['event_filter'] == 'Extreme Worship') ? 'selected' : ''; ?>>Extreme Worship</option>
								   <option value="Prayer Kesha" <?php echo (isset($_GET['event_filter']) && $_GET['event_filter'] == 'Prayer Kesha') ? 'selected' : ''; ?>>Prayer Kesha</option>
								   <option value="Others" <?php echo (isset($_GET['event_filter']) && $_GET['event_filter'] == 'Others') ? 'selected' : ''; ?>>Others</option>
							   </select>
							   <button type="submit" class="btn btn-primary"><i class="icon-filter"></i> Filter</button>
							   <a href="visitors_attendance_report.php" class="btn btn-warning"><i class="icon-refresh"></i> Reset</a>
						   </form>
					     </div>
	                     <div class="pull-right">
		                   <a href="print_visitors_attendance.php<?php echo isset($_GET['event_filter']) && $_GET['event_filter'] != '' ? '?event_filter='.$_GET['event_filter'] : ''; ?>" class="btn btn-info" id="print" data-placement="left" title="Click to Print"><i class="icon-print icon-large"></i> Print Report</a> 		      
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

				<!-- Statistics Section -->
				<?php
				$event_filter = isset($_GET['event_filter']) ? $_GET['event_filter'] : '';
				$where_clause = "";
				if ($event_filter != '') {
					$where_clause = "WHERE ministry = '$event_filter'";
				}
				
				// Get statistics
				$sunday_service = mysqli_num_rows(mysqli_query($conn,"select * from visitor where ministry = 'Sunday Service'"));
				$extreme_worship = mysqli_num_rows(mysqli_query($conn,"select * from visitor where ministry = 'Extreme Worship'"));
				$prayer_kesha = mysqli_num_rows(mysqli_query($conn,"select * from visitor where ministry = 'Prayer Kesha'"));
				$others = mysqli_num_rows(mysqli_query($conn,"select * from visitor where ministry = 'Others'"));
				?>
				
				<div class="row-fluid">
					<div class="span3">
						<div class="alert alert-info">
							<h4>Sunday Nass</h4>
							<h3><?php echo $sunday_service; ?> Visitors</h3>
						</div>
					</div>
					<div class="span3">
						<div class="alert alert-success">
							<h4>Leadership Training</h4>
							<h3><?php echo $extreme_worship; ?> Visitors</h3>
						</div>
					</div>
					<div class="span3">
						<div class="alert alert-warning">
							<h4>Daily Mass</h4>
							<h3><?php echo $prayer_kesha; ?> Visitors</h3>
						</div>
					</div>
					<div class="span3">
						<div class="alert alert-error">
							<h4>Others</h4>
							<h3><?php echo $others; ?> Visitors</h3>
						</div>
					</div>
				</div>
	
                <div class="block-content collapse in">
                    <div class="span12">
	                <form action="" method="post">
  	                <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
		                <thead>		
		                    <tr>			        
                	            <th>Visitor Name</th>
					            <th>Gender</th>
					            <th>Mobile No.</th>
					            <th>Residence</th>
			                    <th>Event Attended</th>
					            <th>Attendance Status</th>
					            <th>Date Recorded</th>
		                    </tr>
		                </thead>
                        <tbody>
                        <!-----------------------------------Content------------------------------------>
                        <?php
		                $visitor_query = mysqli_query($conn,"select * from visitor $where_clause ORDER BY id DESC")or die(mysqli_error());
		                while($row = mysqli_fetch_array($visitor_query)){
		                    $visitor_id = $row['id'];
                            // Determine attendance status based on data presence
                            $attendance_status = "Present";
                            $status_class = "label-success";
                            $status_icon = "icon-ok";
	
		                ?>
									
		                <tr>
		                    <td><?php echo $row['fname']." ".$row['sname']." ".$row['lname']; ?></td>
		                    <td><?php echo $row['Gender']; ?></td>
		                    <td><?php echo $row['mobile']; ?></td>
		                    <td><?php echo $row['Residence']; ?></td>
		                    <td><span class="label label-info"><?php echo $row['ministry']; ?></span></td>
		                    <td><span class="label <?php echo $status_class; ?>">
		                        <i class="<?php echo $status_icon; ?>"></i> <?php echo $attendance_status; ?>
		                    </span></td>
		                    <td><?php echo date('Y-m-d', strtotime($row['Birthday'])); ?></td>
                        </tr>
											
	                    <?php } ?>   

                        </tbody>
                    </table>
                    </form>	
		
			  		
                </div>
                </div>
                </div>
                </div>
                </div>
	
            </div>	
            <?php include('footer.php'); ?>
        </div>
        <?php include('script.php'); ?>
     </body>
</html>