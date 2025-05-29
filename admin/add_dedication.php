<?php include('header.php'); ?>
<?php include('session.php'); ?>

<?php
// Handle form submission
if(isset($_POST['submit'])) {
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
    
    // Generate certificate number
    $year = date('Y');
    $count_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM dedication WHERE YEAR(created_date) = '$year'");
    $count_result = mysqli_fetch_array($count_query);
    $next_number = $count_result['count'] + 1;
    $certificate_number = 'DED-' . $year . '-' . str_pad($next_number, 3, '0', STR_PAD_LEFT);
    
    // Get admin ID from session
    $admin_query = mysqli_query($conn, "SELECT admin_id FROM admin WHERE username = '$admin_username'");
    $admin_result = mysqli_fetch_array($admin_query);
    $created_by = $admin_result['admin_id'];
    
    // Insert into database
    $insert_query = "INSERT INTO dedication (
        child_fname, child_mname, child_lname, child_gender, child_birthdate, child_birthplace,
        father_name, mother_name, parents_address, parents_mobile, dedication_date,
        officiant, certificate_number, remarks, member_id, created_by
    ) VALUES (
        '$child_fname', '$child_mname', '$child_lname', '$child_gender', '$child_birthdate', '$child_birthplace',
        '$father_name', '$mother_name', '$parents_address', '$parents_mobile', '$dedication_date',
        '$officiant', '$certificate_number', '$remarks', '$member_id', '$created_by'
    )";
    
    $result = mysqli_query($conn, $insert_query);
    
    if($result) {
        $dedication_id = mysqli_insert_id($conn);
        mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (NOW(), '$admin_username', 'Generated dedication certificate: $certificate_number')");
        echo "<script>alert('Dedication certificate generated successfully!'); window.location='print_dedication_certificate.php?id=$dedication_id';</script>";
    } else {
        echo "<script>alert('Error generating certificate: " . mysqli_error($conn) . "');</script>";
    }
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
                                <i class="icon-plus icon-large"></i> Generate Dedication Certificate
                            </div>
                            <div class="muted pull-right">
                                <a href="dedication_certificate.php" class="btn btn-info">
                                    <i class="icon-arrow-left icon-white"></i> Back to Certificates
                                </a>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                
                                <form method="POST" class="form-horizontal">
                                    
                                    <!-- Child Information -->
                                    <fieldset>
                                        <legend><i class="icon-user"></i> Child Information</legend>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_fname">First Name *</label>
                                            <div class="controls">
                                                <input type="text" id="child_fname" name="child_fname" class="input-large" required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_mname">Middle Name</label>
                                            <div class="controls">
                                                <input type="text" id="child_mname" name="child_mname" class="input-large">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_lname">Last Name *</label>
                                            <div class="controls">
                                                <input type="text" id="child_lname" name="child_lname" class="input-large" required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_gender">Gender *</label>
                                            <div class="controls">
                                                <select id="child_gender" name="child_gender" class="input-medium" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_birthdate">Date of Birth *</label>
                                            <div class="controls">
                                                <input type="date" id="child_birthdate" name="child_birthdate" class="input-medium" required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="child_birthplace">Place of Birth *</label>
                                            <div class="controls">
                                                <input type="text" id="child_birthplace" name="child_birthplace" class="input-large" required>
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <!-- Parents Information -->
                                    <fieldset>
                                        <legend><i class="icon-group"></i> Parents Information</legend>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="father_name">Father's Full Name *</label>
                                            <div class="controls">
                                                <input type="text" id="father_name" name="father_name" class="input-xlarge" required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="mother_name">Mother's Full Name *</label>
                                            <div class="controls">
                                                <input type="text" id="mother_name" name="mother_name" class="input-xlarge" required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="parents_address">Address *</label>
                                            <div class="controls">
                                                <textarea id="parents_address" name="parents_address" class="input-xlarge" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="parents_mobile">Mobile Number *</label>
                                            <div class="controls">
                                                <input type="text" id="parents_mobile" name="parents_mobile" class="input-medium" required pattern="[0-9]{11}" placeholder="09XXXXXXXXX">
                                                <span class="help-inline">Format: 09XXXXXXXXX</span>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="member_id">Existing Member</label>
                                            <div class="controls">
                                                <select id="member_id" name="member_id" class="input-large">
                                                    <option value="">Select if parent is a member</option>
                                                    <?php while($member = mysqli_fetch_array($members_query)): ?>
                                                    <option value="<?php echo $member['id']; ?>">
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
                                                <input type="date" id="dedication_date" name="dedication_date" class="input-medium" required>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="officiant">Officiant *</label>
                                            <div class="controls">
                                                <input type="text" id="officiant" name="officiant" class="input-large" required placeholder="e.g., Fr. John Smith">
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" for="remarks">Remarks/Notes</label>
                                            <div class="controls">
                                                <textarea id="remarks" name="remarks" class="input-xlarge" rows="3" placeholder="Any special notes or remarks"></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <div class="form-actions">
                                        <button type="submit" name="submit" class="btn btn-success btn-large">
                                            <i class="icon-certificate icon-white"></i> Generate Certificate
                                        </button>
                                        <a href="dedication_certificate.php" class="btn btn-large">Cancel</a>
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
        // Set today's date as default for dedication date
        document.getElementById('dedication_date').valueAsDate = new Date();
        
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
    </script>
</body>
</html>