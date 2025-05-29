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
	             $count_members=mysqli_query($conn,"select * from members");
	             $count = mysqli_num_rows($count_members);
                 ?>	 
				   <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                             <div class="muted pull-left"><i class="icon-reorder icon-large"></i> Dedication Certificate List</div>
                          <div class="muted pull-right">
								Number of Members: <span class="badge badge-info"><?php  echo $count; ?></span>
							 </div>
						  </div>
						  
                 <h4 id="sc">Dedication Certificates
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
		   <a href="print_all_dedication.php" class="btn btn-info" id="print" data-placement="left" title="Click to Print All"><i class="icon-print icon-large"></i> Print All Certificates</a> 		      
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
  	<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
		<thead>		
		        <tr>			        
                	<th>Name</th>
					<th>Gender</th>
					<th>Date of Birth</th>
					<th>Residence</th>
					<th>Ministry</th>
                    <th>Mobile No.</th>
                    <th>Certificate Status</th>
                    <th>Actions</th>
                   		
                    				
		    </tr>
		</thead>
<tbody>
<!-----------------------------------Content------------------------------------>
<?php
		$members_query = mysqli_query($conn,"select * from members ORDER BY fname ASC")or die(mysqli_error());
		while($row = mysqli_fetch_array($members_query)){
		$member_id = $row['id'];
		$full_name = $row['fname']." ".$row['lname'];
		
		// Check if dedication certificate has been validated
		$validation_query = mysqli_query($conn,"SELECT * FROM dedication_certificates WHERE member_id = '$member_id'");
		$validation_row = mysqli_fetch_array($validation_query);
		$is_validated = mysqli_num_rows($validation_query) > 0;
		?>
									
		<tr>
		    <td><?php echo $full_name; ?></td>
			<td><?php echo $row['Gender']; ?></td>
			<td><?php echo date('F j, Y', strtotime($row['Birthday'])); ?></td>
			<td><?php echo $row['Residence']; ?></td>
			<td><?php echo $row['ministry']; ?></td>	
            <td><?php echo $row['mobile']; ?></td>
            <td>
            	<?php if($is_validated): ?>
            		<span class="badge badge-success">Validated</span>
            		<br><small>By: <?php echo $validation_row['validated_by']; ?></small>
            		<br><small>Date: <?php echo date('M j, Y', strtotime($validation_row['validation_date'])); ?></small>
            	<?php else: ?>
            		<span class="badge badge-warning">Pending</span>
            	<?php endif; ?>
            </td>
            <td>
            	<div class="btn-group">
            		<a href="print_dedication.php?member_id=<?php echo $member_id; ?>" class="btn btn-primary btn-small" title="Print Certificate" target="_blank">
            			<i class="icon-print"></i> Print
            		</a>
            		<?php if(!$is_validated): ?>
            		<a href="javascript:void(0)" onclick="validateCertificate(<?php echo $member_id; ?>, '<?php echo $full_name; ?>')" class="btn btn-success btn-small" title="Validate Certificate">
            			<i class="icon-check"></i> Validate
            		</a>
            		<?php else: ?>
            		<a href="javascript:void(0)" onclick="revokeValidation(<?php echo $member_id; ?>, '<?php echo $full_name; ?>')" class="btn btn-danger btn-small" title="Revoke Validation">
            			<i class="icon-remove"></i> Revoke
            		</a>
            		<?php endif; ?>
            		<a href="edit_dedication.php?member_id=<?php echo $member_id; ?>" class="btn btn-info btn-small" title="Edit Certificate Details">
            			<i class="icon-edit"></i> Edit
            		</a>
            	</div>
            </td>
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

<!-- Validation Modal -->
<div id="validationModal" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Validate Dedication Certificate</h3>
    </div>
    <div class="modal-body">
        <p>Are you sure you want to validate the dedication certificate for <strong id="memberName"></strong>?</p>
        <form id="validationForm">
            <input type="hidden" id="memberId" name="member_id">
            <div class="control-group">
                <label class="control-label">Validation Notes (Optional):</label>
                <div class="controls">
                    <textarea name="notes" class="span5" rows="3" placeholder="Add any special notes about this dedication..."></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dedication Date:</label>
                <div class="controls">
                    <input type="date" name="dedication_date" class="span3" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="confirmValidation()">Validate Certificate</button>
    </div>
</div>

<!-- Revoke Modal -->
<div id="revokeModal" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Revoke Certificate Validation</h3>
    </div>
    <div class="modal-body">
        <p>Are you sure you want to revoke the validation for <strong id="revokeMemberName"></strong>'s dedication certificate?</p>
        <input type="hidden" id="revokeMemberId">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="confirmRevoke()">Revoke Validation</button>
    </div>
</div>

<script type="text/javascript">
function validateCertificate(memberId, memberName) {
    $('#memberId').val(memberId);
    $('#memberName').text(memberName);
    $('#validationModal').modal('show');
}

function revokeValidation(memberId, memberName) {
    $('#revokeMemberId').val(memberId);
    $('#revokeMemberName').text(memberName);
    $('#revokeModal').modal('show');
}

function confirmValidation() {
    var formData = $('#validationForm').serialize();
    
    $.ajax({
        type: 'POST',
        url: 'validate_dedication.php',
        data: formData,
        success: function(response) {
            $('#validationModal').modal('hide');
            if(response == 'success') {
                $.jGrowl("Certificate validated successfully", { header: 'Success' });
                setTimeout(function(){ 
                    window.location.reload(); 
                }, 1500);
            } else {
                $.jGrowl("Error validating certificate", { header: 'Error' });
            }
        },
        error: function() {
            $.jGrowl("Error validating certificate", { header: 'Error' });
        }
    });
}

function confirmRevoke() {
    var memberId = $('#revokeMemberId').val();
    
    $.ajax({
        type: 'POST',
        url: 'revoke_dedication.php',
        data: {member_id: memberId},
        success: function(response) {
            $('#revokeModal').modal('hide');
            if(response == 'success') {
                $.jGrowl("Certificate validation revoked", { header: 'Success' });
                setTimeout(function(){ 
                    window.location.reload(); 
                }, 1500);
            } else {
                $.jGrowl("Error revoking validation", { header: 'Error' });
            }
        },
        error: function() {
            $.jGrowl("Error revoking validation", { header: 'Error' });
        }
    });
}
</script>

<?php include('footer.php'); ?>
</div>
<?php include('script.php'); ?>
 </body>
</html>