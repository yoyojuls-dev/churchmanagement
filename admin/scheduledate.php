<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php 
// Handle form submission first
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $member_id = $_POST['member_id'];
    $certificate_number = $_POST['certificate_number'];
    $baptism_date = $_POST['baptism_date'];
    $baptized_by = $_POST['baptized_by'];
    $witnesses = $_POST['witnesses'];
    $church_location = $_POST['church_location'];
    $notes = $_POST['notes'];
    
    if ($_POST['action'] == 'create') {
        // Check if certificate number already exists
        $check_query = mysqli_query($conn, "SELECT certificate_id FROM baptismal_certificates WHERE certificate_number = '$certificate_number'");
        if (mysqli_num_rows($check_query) > 0) {
            echo "<script>alert('Certificate number already exists. Please choose a different number.'); window.location='generate_baptismal.php?member_id=$member_id';</script>";
            exit();
        }
        
        // Insert new certificate
        $insert_query = "INSERT INTO baptismal_certificates 
                        (member_id, certificate_number, baptism_date, baptized_by, witnesses, church_location, generated_by, notes) 
                        VALUES 
                        ('$member_id', '$certificate_number', '$baptism_date', '$baptized_by', '$witnesses', '$church_location', '$admin_username', '$notes')";
        
        if (mysqli_query($conn, $insert_query)) {
            mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (NOW(), '$admin_username', 'Generated baptismal certificate $certificate_number')");
            echo "<script>alert('Baptismal certificate generated successfully!'); window.location='baptismal_certificates.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error generating certificate: " . mysqli_error($conn) . "');</script>";
        }
        
    } elseif ($_POST['action'] == 'update') {
        $certificate_id = $_POST['certificate_id'];
        
        // Update existing certificate
        $update_query = "UPDATE baptismal_certificates SET 
                        certificate_number = '$certificate_number',
                        baptism_date = '$baptism_date',
                        baptized_by = '$baptized_by',
                        witnesses = '$witnesses',
                        church_location = '$church_location',
                        notes = '$notes'
                        WHERE certificate_id = '$certificate_id'";
        
        if (mysqli_query($conn, $update_query)) {
            mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (NOW(), '$admin_username', 'Updated baptismal certificate $certificate_number')");
            echo "<script>alert('Baptismal certificate updated successfully!'); window.location='baptismal_certificates.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating certificate: " . mysqli_error($conn) . "');</script>";
        }
    }
}

$edit_mode = false;
$certificate_data = null;
$member_data = null;

// Check if we're editing an existing certificate
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $edit_mode = true;
    $certificate_id = $_GET['id'];
    $cert_query = mysqli_query($conn, "SELECT bc.*, m.fname, m.lname, m.Gender, m.Birthday, m.pob, m.mobile 
                                       FROM baptismal_certificates bc 
                                       JOIN members m ON bc.member_id = m.id 
                                       WHERE bc.certificate_id = '$certificate_id'") or die(mysqli_error($conn));
    $certificate_data = mysqli_fetch_array($cert_query);
    if(!$certificate_data) {
        echo "<script>alert('Certificate not found!'); window.location='baptismal_certificates.php';</script>";
        exit();
    }
}

// Check if we're generating for a specific member
if(isset($_GET['member_id']) && !empty($_GET['member_id'])) {
    $member_id = $_GET['member_id'];
    $member_query = mysqli_query($conn, "SELECT * FROM members WHERE id = '$member_id'") or die(mysqli_error($conn));
    $member_data = mysqli_fetch_array($member_query);
    if(!$member_data) {
        echo "<script>alert('Member not found!'); window.location='baptismal_certificates.php';</script>";
        exit();
    }
}
?>
    <body>
		<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('sidebar.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <i class="icon-certificate icon-large"></i> 
                                    <?php echo $edit_mode ? 'Edit Baptismal Certificate' : 'Generate Baptismal Certificate'; ?>
                                </div>
                                <div class="muted pull-right">
                                    <a href="baptismal_certificates.php" class="btn btn-info" title="Back to Certificates List">
                                        <i class="icon-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    
                                    <?php if(!$edit_mode && !$member_data): ?>
                                    <!-- Member Selection Form -->
                                    <div class="alert alert-info">
                                        <strong>Step 1:</strong> Select a member to generate their baptismal certificate.
                                    </div>
                                    
                                    <form method="GET" class="form-horizontal">
                                        <div class="control-group">
                                            <label class="control-label" for="member_select">Select Member:</label>
                                            <div class="controls">
                                                <select name="member_id" id="member_select" class="input-xlarge" required>
                                                    <option value="">Choose a member...</option>
                                                    <?php
                                                    $members_query = mysqli_query($conn, "SELECT m.id, m.fname, m.lname, m.mobile,
                                                                                         (SELECT COUNT(*) FROM baptismal_certificates bc WHERE bc.member_id = m.id) as has_cert
                                                                                         FROM members m 
                                                                                         ORDER BY m.fname, m.lname") or die(mysqli_error($conn));
                                                    while($member = mysqli_fetch_array($members_query)) {
                                                        $disabled = $member['has_cert'] > 0 ? 'disabled' : '';
                                                        $suffix = $member['has_cert'] > 0 ? ' (Already has certificate)' : '';
                                                        echo "<option value='{$member['id']}' $disabled>{$member['fname']} {$member['lname']} - {$member['mobile']}$suffix</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="icon-arrow-right"></i> Continue
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <?php else: ?>
                                    <!-- Certificate Generation/Edit Form -->
                                    <?php 
                                    $current_member = $edit_mode ? $certificate_data : $member_data;
                                    ?>
                                    
                                    <div class="alert alert-info">
                                        <strong><?php echo $edit_mode ? 'Editing' : 'Generating'; ?> certificate for:</strong> 
                                        <?php echo $current_member['fname'] . ' ' . $current_member['lname']; ?>
                                        <?php if($edit_mode): ?>
                                        <span class="pull-right">
                                            <a href="print_baptismal_certificate.php?id=<?php echo $certificate_data['certificate_id']; ?>" 
                                               class="btn btn-mini btn-info" target="_blank">
                                                <i class="icon-print"></i> Preview Certificate
                                            </a>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <form method="POST" class="form-horizontal">
                                        <input type="hidden" name="member_id" value="<?php echo $edit_mode ? $certificate_data['member_id'] : $member_data['id']; ?>">
                                        <?php if($edit_mode): ?>
                                        <input type="hidden" name="certificate_id" value="<?php echo $certificate_data['certificate_id']; ?>">
                                        <input type="hidden" name="action" value="update">
                                        <?php else: ?>
                                        <input type="hidden" name="action" value="create">
                                        <?php endif; ?>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Member Name:</label>
                                            <div class="controls">
                                                <span class="input-xlarge uneditable-input">
                                                    <?php echo $current_member['fname'] . ' ' . $current_member['lname']; ?>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="certificate_number">Certificate Number:</label>
                                            <div class="controls">
                                                <input type="text" name="certificate_number" id="certificate_number" 
                                                       class="input-xlarge" 
                                                       value="<?php echo $edit_mode ? $certificate_data['certificate_number'] : 'BC-' . date('Y') . '-' . sprintf('%03d', rand(1,999)); ?>" 
                                                       required>
                                                <span class="help-block">Unique certificate identifier</span>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="baptism_date">Baptism Date:</label>
                                            <div class="controls">
                                                <input type="date" name="baptism_date" id="baptism_date" 
                                                       class="input-xlarge" 
                                                       value="<?php echo $edit_mode ? $certificate_data['baptism_date'] : ''; ?>" 
                                                       required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="baptized_by">Baptized By:</label>
                                            <div class="controls">
                                                <input type="text" name="baptized_by" id="baptized_by" 
                                                       class="input-xlarge" 
                                                       value="<?php echo $edit_mode ? $certificate_data['baptized_by'] : 'Fr. Parish Priest'; ?>" 
                                                       required>
                                                <span class="help-block">Name of the officiating priest/minister</span>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="witnesses">Witnesses:</label>
                                            <div class="controls">
                                                <textarea name="witnesses" id="witnesses" 
                                                          class="input-xlarge" rows="3" 
                                                          placeholder="Enter witness names separated by commas"><?php echo $edit_mode ? $certificate_data['witnesses'] : ''; ?></textarea>
                                                <span class="help-block">Names of baptism witnesses</span>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="church_location">Church Location:</label>
                                            <div class="controls">
                                                <input type="text" name="church_location" id="church_location" 
                                                       class="input-xlarge" 
                                                       value="<?php echo $edit_mode ? $certificate_data['church_location'] : 'Parish Church'; ?>" 
                                                       required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="notes">Notes:</label>
                                            <div class="controls">
                                                <textarea name="notes" id="notes" 
                                                          class="input-xlarge" rows="3" 
                                                          placeholder="Additional notes or comments"><?php echo $edit_mode ? $certificate_data['notes'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" class="btn btn-success btn-large">
                                                    <i class="icon-save icon-large"></i> 
                                                    <?php echo $edit_mode ? 'Update Certificate' : 'Generate Certificate'; ?>
                                                </button>
                                                <a href="baptismal_certificates.php" class="btn btn-large">
                                                    <i class="icon-remove"></i> Cancel
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>