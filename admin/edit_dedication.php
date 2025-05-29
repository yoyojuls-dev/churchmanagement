<?php include('header.php'); ?>
<?php include('session.php'); ?>

<?php
// Check if dedication ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: dedication_certificates.php");
    exit();
}

$dedication_id = $_GET['id'];

// Handle form submission for updates
if(isset($_POST['update'])) {
    $child_fname = mysqli_real_escape_string($conn, $_POST['child_fname']);
    $child_mname = mysqli_real_escape_string($conn, $_POST['child_mname']);
    $child_lname = mysqli_real_escape_string($conn, $_POST['child_lname']);
    $child_gender = mysqli_real_escape_string($conn, $_POST['child_gender']);
    $child_birthdate = mysqli_real_escape_string($conn, $_POST['child_birthdate']);
    $child_birthplace = mysqli_real_escape_string($conn, $_POST['child_birthplace']);
    $father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
    $mother_name = mysqli_real_escape_string($conn, $_POST['mother_name']);
    $parents_address = mysqli_real_escape_string($conn, $_POST['parents_address']);
    $parents_mobile = mysqli_real_escape_string($conn, $_POST['parents_mobile']);
    $dedication_date = mysqli_real_escape_string($conn, $_POST['dedication_date']);
    $officiant = mysqli_real_escape_string($conn, $_POST['officiant']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $member_id = mysqli_real_escape_string($conn, $_POST['member_id']);
    
    // Update database
    $update_query = "UPDATE dedication SET 
        child_fname = '$child_fname',
        child_mname = '$child_mname',
        child_lname = '$child_lname',
        child_gender = '$child_gender',
        child_birthdate = '$child_birthdate',
        child_birthplace = '$child_birthplace',
        father_name = '$father_name',
        mother_name = '$mother_name',
        parents_address = '$parents_address',
        parents_mobile = '$parents_mobile',
        dedication_date = '$dedication_date',
        officiant = '$officiant',
        remarks = '$remarks',
        member_id = " . (empty($member_id) ? "NULL" : "'$member_id'") . "
        WHERE dedication_id = '$dedication_id'";
    
    $result = mysqli_query($conn, $update_query);
    
    if($result) {
        // Log the activity
        $certificate_number = $_POST['certificate_number']; // Hidden field
        mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (NOW(), '$admin_username', 'Updated dedication certificate: $certificate_number')");
        echo "<script>alert('Dedication certificate updated successfully!'); window.location='dedication_certificates.php';</script>";
    } else {
        echo "<script>alert('Error updating certificate: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch existing dedication data
$dedication_query = mysqli_query($conn, "SELECT * FROM dedication WHERE dedication_id = '$dedication_id'") or die(mysqli_error($conn));
$dedication_data = mysqli_fetch_array($dedication_query);

if(!$dedication_data) {
    echo "<script>alert('Dedication certificate not found!'); window.location='dedication_certificates.php';</script>";
    exit();
}

// Fetch members for dropdown
$members_query = mysqli_query($conn, "SELECT id, fname, lname FROM members ORDER BY fname, lname");
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
                                <i class="icon-edit icon-large"></i> Edit Dedication Certificate
                            </div>
                            <div class="muted pull-right">
                                <a href="dedication_certificates.php" class="btn btn-info">
                                    <i class="icon-arrow-left icon-white"></i> Back to Certificates
                                </a>
                                <a href="print_dedication_certificate.php?id=<?php echo $dedication_id; ?>" class="btn btn-success" target="_blank">
                                    <i class="icon-eye-open icon-white"></i> View Certificate
                                </a>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                
                                <!-- Certificate Info Alert -->
                                <div class="alert alert-info">
                                    <h4><i class="icon-info-sign"></i> Editing Certificate</h4>
                                    <strong>Certificate Number:</strong> <?php echo $dedication_data['certificate_number']; ?><br>
                                    <strong>Created:</strong> <?php echo date('F j, Y g:i A', strtotime($dedication_data['created_date'])); ?><br>
                                    <strong>Status:</strong> <span class="badge badge-success"><?php echo ucfirst($dedication_data['status']); ?></span>
                                </div>
                                
                                <form method="POST" class="form-horizontal">
                                    <!-- Hidden fields -->
                                    <input type="hidden" name="certificate_number" value="<?php echo $dedication_data['certificate_number']; ?>">
                                    
                                    <!-- Child Information -->
                                    <fieldset>
                                        <legend><i class="icon-user"></i> Child Information</legend>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_fname">First Name *</label>
                                            <div class="controls">
                                                <input type="text" id="child_fname" name="child_fname" class="input-large" required value="<?php echo htmlspecialchars($dedication_data['child_fname']); ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_mname">Middle Name</label>
                                            <div class="controls">
                                                <input type="text" id="child_mname" name="child_mname" class="input-large" value="<?php echo htmlspecialchars($dedication_data['child_mname']); ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_lname">Last Name *</label>
                                            <div class="controls">
                                                <input type="text" id="child_lname" name="child_lname" class="input-large" required value="<?php echo htmlspecialchars($dedication_data['child_lname']); ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_gender">Gender *</label>
                                            <div class="controls">
                                                <select id="child_gender" name="child_gender" class="input-medium" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" <?php echo ($dedication_data['child_gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                    <option value="Female" <?php echo ($dedication_data['child_gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_birthdate">Date of Birth *</label>
                                            <div class="controls">
                                                <input type="date" id="child_birthdate" name="child_birthdate" class="input-medium" required value="<?php echo $dedication_data['child_birthdate']; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_birthplace">Place of Birth *</label>
                                            <div class="controls">
                                                <input type="text" id="child_birthplace" name="child_birthplace" class="input-large" required value="<?php echo htmlspecialchars($dedication_data['child_birthplace']); ?>">
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <!-- Parents Information -->
                                    <fieldset>
                                        <legend><i class="icon-group"></i> Parents Information</legend>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="father_name">Father's Full Name *</label>
                                            <div class="controls">
                                                <input type="text" id="father_name" name="father_name" class="input-xlarge" required value="<?php echo htmlspecialchars($dedication_data['father_name']); ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="mother_name">Mother's Full Name *</label>
                                            <div class="controls">
                                                <input type="text" id="mother_name" name="mother_name" class="input-xlarge" required value="<?php echo htmlspecialchars($dedication_data['mother_name']); ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="parents_address">Address *</label>
                                            <div class="controls">
                                                <textarea id="parents_address" name="parents_address" class="input-xlarge" rows="3" required><?php echo htmlspecialchars($dedication_data['parents_address']); ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="parents_mobile">Mobile Number *</label>
                                            <div class="controls">
                                                <input type="text" id="parents_mobile" name="parents_mobile" class="input-medium" required pattern="[0-9]{11}" placeholder="09XXXXXXXXX" value="<?php echo htmlspecialchars($dedication_data['parents_mobile']); ?>">
                                                <span class="help-inline">Format: 09XXXXXXXXX</span>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="member_id">Existing Member</label>
                                            <div class="controls">
                                                <select id="member_id" name="member_id" class="input-large">
                                                    <option value="">Select if parent is a member</option>
                                                    <?php while($member = mysqli_fetch_array($members_query)): ?>
                                                    <option value="<?php echo $member['id']; ?>" <?php echo ($dedication_data['member_id'] == $member['id']) ? 'selected' : ''; ?>>
                                                        <?php echo $member['fname'] . ' ' . $member['lname']; ?>
                                                    </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <!-- Dedication Details -->
                                    <fieldset>
                                        <legend><i class="icon-calendar"></i> Dedication Details</legend>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="dedication_date">Dedication Date *</label>
                                            <div class="controls">
                                                <input type="date" id="dedication_date" name="dedication_date" class="input-medium" required value="<?php echo $dedication_data['dedication_date']; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="officiant">Officiant *</label>
                                            <div class="controls">
                                                <input type="text" id="officiant" name="officiant" class="input-large" required placeholder="e.g., Fr. John Smith" value="<?php echo htmlspecialchars($dedication_data['officiant']); ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="remarks">Remarks/Notes</label>
                                            <div class="controls">
                                                <textarea id="remarks" name="remarks" class="input-xlarge" rows="3" placeholder="Any special notes or remarks"><?php echo htmlspecialchars($dedication_data['remarks']); ?></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <!-- Change History -->
                                    <fieldset>
                                        <legend><i class="icon-time"></i> Certificate Information</legend>
                                        <div class="row-fluid">
                                            <div class="span6">
                                                <div class="alert alert-info">
                                                    <strong>Original Creation:</strong><br>
                                                    Date: <?php echo date('F j, Y g:i A', strtotime($dedication_data['created_date'])); ?><br>
                                                    Certificate #: <?php echo $dedication_data['certificate_number']; ?>
                                                </div>
                                            </div>
                                            <div class="span6">
                                                <div class="alert alert-warning">
                                                    <strong>Important:</strong><br>
                                                    Changes will be reflected immediately on the certificate.<br>
                                                    Consider reprinting after updates.
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <div class="form-actions">
                                        <button type="submit" name="update" class="btn btn-warning btn-large">
                                            <i class="icon-ok icon-white"></i> Update Certificate
                                        </button>
                                        <a href="dedication_certificate.php" class="btn btn-large">Cancel</a>
                                        <a href="print_dedication_certificate.php?id=<?php echo $dedication_id; ?>" class="btn btn-success btn-large" target="_blank">
                                            <i class="icon-eye-open icon-white"></i> Preview Certificate
                                        </a>
                                    </div>
                                </form>
                                
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
    
    <script>        
        // Validate mobile number format
        document.getElementById('parents_mobile').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value.length > 11) {
                e.target.value = value.slice(0, 11);
            }
        });
        
        // Auto-populate names when selecting an existing member
        document.getElementById('member_id').addEventListener('change', function() {
            if (this.value) {
                // You can add AJAX here to fetch member details and populate parent fields
                // For now, just show a helper message
                if (this.selectedIndex > 0) {
                    alert('Selected member: ' + this.options[this.selectedIndex].text + '\nPlease verify parent information is correct.');
                }
            }
        });
        
        // Confirm before updating
        document.querySelector('form').addEventListener('submit', function(e) {
            if (e.submitter.name === 'update') {
                if (!confirm('Are you sure you want to update this dedication certificate? This action will modify the existing record.')) {
                    e.preventDefault();
                }
            }
        });
        
        // Highlight changed fields
        const originalData = <?php echo json_encode($dedication_data); ?>;
        
        function highlightChanges() {
            const fields = ['child_fname', 'child_mname', 'child_lname', 'child_gender', 'child_birthdate', 'child_birthplace', 'father_name', 'mother_name', 'parents_address', 'parents_mobile', 'dedication_date', 'officiant', 'remarks'];
            
            fields.forEach(field => {
                const element = document.getElementById(field);
                if (element) {
                    element.addEventListener('input', function() {
                        if (this.value !== originalData[field]) {
                            this.style.backgroundColor = '#fff3cd';
                            this.style.borderColor = '#ffc107';
                        } else {
                            this.style.backgroundColor = '';
                            this.style.borderColor = '';
                        }
                    });
                }
            });
        }
        
        // Initialize change highlighting
        highlightChanges();
    </script>
</body>
</html>