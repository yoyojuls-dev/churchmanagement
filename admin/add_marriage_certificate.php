<?php
// add_marriage_certificate.php
include('header.php');
include('session.php');
?>
<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar.php'); ?>
            <div class="span3" id="addmarriage">
                <!-- Marriage Certificate Form -->
                <div class="row-fluid">
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><i class="icon-plus-sign icon-large"> Add Marriage Certificate</i></div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <form method="post" enctype="multipart/form-data">
                                    <!-- Groom Information -->
                                    <h5>Groom Information</h5>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="input focused" name="groom_name" type="text" placeholder="Groom Full Name" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="input focused" name="groom_mobile" type="text" placeholder="Groom Mobile Number">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <textarea class="input focused" name="groom_address" placeholder="Groom Address" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <!-- Bride Information -->
                                    <h5>Bride Information</h5>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="input focused" name="bride_name" type="text" placeholder="Bride Full Name" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="input focused" name="bride_mobile" type="text" placeholder="Bride Mobile Number">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <textarea class="input focused" name="bride_address" placeholder="Bride Address" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <!-- Marriage Details -->
                                    <h5>Marriage Details</h5>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="input focused" name="marriage_date" type="date" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="input focused" name="marriage_venue" type="text" placeholder="Marriage Venue">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="input focused" name="officiant_name" type="text" placeholder="Officiant Name">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="input focused" name="certificate_number" type="text" placeholder="Certificate Number">
                                        </div>
                                    </div>

                                    <!-- Document Upload -->
                                    <div class="control-group">
                                        <label class="control-label">Upload Marriage Certificate Proof</label>
                                        <div class="controls">
                                            <input name="proof_document" type="file" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <span class="help-block">Upload PDF, JPG, or PNG files only</span>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="control-group">
                                        <div class="controls">
                                            <select name="status" class="input focused">
                                                <option value="pending">Pending</option>
                                                <option value="approved">Approved</option>
                                                <option value="issued">Issued</option>
                                                <option value="rejected">Rejected</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="control-group">
                                        <div class="controls">
                                            <textarea class="input focused" name="notes" placeholder="Additional Notes" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button name="save" class="btn btn-info" type="submit">
                                                <i class="icon-plus-sign icon-large"> Save Marriage Certificate</i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Marriage Certificates List -->
            <div class="span6">
                <div class="row-fluid">
                    <div class="empty">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon-info-sign"></i> <strong>Note!:</strong> Select the checkbox if you want to delete?
                        </div>
                    </div>

                    <?php
                    $count_certificates = mysqli_query($conn, "SELECT * FROM marriage_certificates");
                    $count = mysqli_num_rows($count_certificates);
                    ?>

                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><i class="icon-certificate"></i> Marriage Certificates List</div>
                            <div class="muted pull-right">
                                Number of Certificates: <span class="badge badge-info"><?php echo $count; ?></span>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                                    <thead>
                                        <tr>
                                            <th>Certificate #</th>
                                            <th>Groom</th>
                                            <th>Bride</th>
                                            <th>Marriage Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $certificates_query = mysqli_query($conn, "SELECT * FROM marriage_certificates ORDER BY marriage_date DESC");
                                        while ($row = mysqli_fetch_array($certificates_query)) {
                                            $id = $row['marriage_id'];
                                        ?>
                                        <tr>
                                            <td><?php echo $row['certificate_number']; ?></td>
                                            <td><?php echo $row['groom_name']; ?></td>
                                            <td><?php echo $row['bride_name']; ?></td>
                                            <td><?php echo $row['marriage_date']; ?></td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $row['status'] == 'issued' ? 'success' : 
                                                        ($row['status'] == 'pending' ? 'warning' : 
                                                         ($row['status'] == 'approved' ? 'info' : 'important'));
                                                ?>">
                                                    <?php echo ucfirst($row['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="edit_marriage.php?id=<?php echo $id; ?>" class="btn btn-mini btn-success">
                                                    <i class="icon-edit"></i> Edit
                                                </a>
                                                <?php if ($row['proof_document']) { ?>
                                                <a href="<?php echo $row['proof_document']; ?>" target="_blank" class="btn btn-mini btn-info">
                                                    <i class="icon-file"></i> View Proof
                                                </a>
                                                <?php } ?>
                                            </td>
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
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
</body>

<?php
// Handle form submission
if (isset($_POST['save'])) {
    $groom_name = mysqli_real_escape_string($conn, $_POST['groom_name']);
    $groom_mobile = mysqli_real_escape_string($conn, $_POST['groom_mobile']);
    $groom_address = mysqli_real_escape_string($conn, $_POST['groom_address']);
    $bride_name = mysqli_real_escape_string($conn, $_POST['bride_name']);
    $bride_mobile = mysqli_real_escape_string($conn, $_POST['bride_mobile']);
    $bride_address = mysqli_real_escape_string($conn, $_POST['bride_address']);
    $marriage_date = $_POST['marriage_date'];
    $marriage_venue = mysqli_real_escape_string($conn, $_POST['marriage_venue']);
    $officiant_name = mysqli_real_escape_string($conn, $_POST['officiant_name']);
    $certificate_number = mysqli_real_escape_string($conn, $_POST['certificate_number']);
    $status = $_POST['status'];
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    // Handle file upload
    $proof_document = '';
    if (isset($_FILES['proof_document']) && $_FILES['proof_document']['error'] == 0) {
        $upload_dir = 'uploads/marriage_certificates/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['proof_document']['name'], PATHINFO_EXTENSION);
        $file_name = 'marriage_' . time() . '_' . uniqid() . '.' . $file_extension;
        $target_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['proof_document']['tmp_name'], $target_file)) {
            $proof_document = $target_file;
        }
    }

    $query = "INSERT INTO marriage_certificates (
        groom_name, groom_mobile, groom_address,
        bride_name, bride_mobile, bride_address,
        marriage_date, marriage_venue, officiant_name,
        certificate_number, proof_document, status, notes, created_by
    ) VALUES (
        '$groom_name', '$groom_mobile', '$groom_address',
        '$bride_name', '$bride_mobile', '$bride_address',
        '$marriage_date', '$marriage_venue', '$officiant_name',
        '$certificate_number', '$proof_document', '$status', '$notes', '$admin_username'
    )";

    if (mysqli_query($conn, $query)) {
        // Log activity
        mysqli_query($conn, "INSERT INTO activity_log (date, username, action) 
                           VALUES (NOW(), '$admin_username', 'Added marriage certificate for $groom_name & $bride_name')");
        ?>
        <script>
            window.location = "add_marriage_certificate.php";
            $.jGrowl("Marriage Certificate Successfully Added", { header: 'Success' });
        </script>
        <?php
    } else {
        ?>
        <script>
            $.jGrowl("Error adding marriage certificate: <?php echo mysqli_error($conn); ?>", { header: 'Error' });
        </script>
        <?php
    }
}
?>
</html>