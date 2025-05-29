<?php include('header.php'); ?>
<?php include('session.php'); ?>

<?php
// Handle deletion
if(isset($_GET['delete']) && !empty($_GET['delete'])) {
    $certificate_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM baptismal_certificates WHERE certificate_id = '$certificate_id'") or die(mysqli_error($conn));
    if($delete_query) {
        mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (NOW(), '$admin_username', 'Deleted baptismal certificate ID: $certificate_id')");
        echo "<script>alert('Certificate deleted successfully!'); window.location='baptismal_certificates.php';</script>";
    } else {
        echo "<script>alert('Error deleting certificate!');</script>";
    }
}

// Pagination
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_condition = '';
if(!empty($search)) {
    $search_condition = "WHERE (bc.certificate_number LIKE '%$search%' OR 
                               m.fname LIKE '%$search%' OR 
                               m.lname LIKE '%$search%' OR 
                               bc.baptized_by LIKE '%$search%' OR 
                               bc.church_location LIKE '%$search%')";
}

// Count total records for pagination
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM baptismal_certificates bc 
                                   JOIN members m ON bc.member_id = m.id $search_condition") or die(mysqli_error($conn));
$count_result = mysqli_fetch_array($count_query);
$total_records = $count_result['total'];
$total_pages = ceil($total_records / $limit);

// Fetch certificates with member information
$certificates_query = mysqli_query($conn, "SELECT bc.*, m.fname, m.lname, m.Gender, m.Birthday, m.mobile 
                                          FROM baptismal_certificates bc 
                                          JOIN members m ON bc.member_id = m.id 
                                          $search_condition
                                          ORDER BY bc.certificate_id DESC 
                                          LIMIT $limit OFFSET $offset") or die(mysqli_error($conn));
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
                                <i class="icon-certificate icon-large"></i> Baptismal Certificates Management
                            </div>
                            <div class="muted pull-right">
                                <a href="scheduledate.php" class="btn btn-success" title="Generate New Certificate">
                                    <i class="icon-plus icon-white"></i> Generate New Certificate
                                </a>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                
                                <!-- Search and Filter Section -->
                                <div class="row-fluid" style="margin-bottom: 20px;">
                                    <div class="span6">
                                        <form method="GET" class="form-search">
                                            <div class="input-append">
                                                <input type="text" name="search" class="input-large search-query" 
                                                       placeholder="Search certificates..." value="<?php echo htmlspecialchars($search); ?>">
                                                <button type="submit" class="btn">
                                                    <i class="icon-search"></i> Search
                                                </button>
                                                <?php if(!empty($search)): ?>
                                                <a href="baptismal_certificates.php" class="btn">
                                                    <i class="icon-remove"></i> Clear
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="span6">
                                        <div class="pull-right">
                                            <span class="badge badge-info">
                                                Total Certificates: <?php echo $total_records; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <?php if(mysqli_num_rows($certificates_query) > 0): ?>
                                
                                <!-- Certificates Table -->
                                <table class="table table-striped table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Certificate No.</th>
                                            <th>Member Name</th>
                                            <th>Gender</th>
                                            <th>Birth Date</th>
                                            <th>Baptism Date</th>
                                            <th>Baptized By</th>
                                            <th>Church Location</th>
                                            <th>Generated By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $counter = $offset + 1;
                                        while($certificate = mysqli_fetch_array($certificates_query)): 
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td>
                                                <strong><?php echo $certificate['certificate_number']; ?></strong>
                                            </td>
                                            <td>
                                                <?php echo $certificate['fname'] . ' ' . $certificate['lname']; ?>
                                                <br>
                                                <small class="muted">Mobile: <?php echo $certificate['mobile']; ?></small>
                                            </td>
                                            <td><?php echo $certificate['Gender']; ?></td>
                                            <td><?php echo date('M j, Y', strtotime($certificate['Birthday'])); ?></td>
                                            <td><?php echo date('M j, Y', strtotime($certificate['baptism_date'])); ?></td>
                                            <td><?php echo $certificate['baptized_by']; ?></td>
                                            <td><?php echo $certificate['church_location']; ?></td>
                                            <td>
                                                <?php echo $certificate['generated_by']; ?>
                                                <br>
                                                <small class="muted">
                                                    Certificate #<?php echo $certificate['certificate_id']; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="print_baptismal_certificate.php?id=<?php echo $certificate['certificate_id']; ?>" 
                                                       class="btn btn-mini btn-info" target="_blank" title="View Certificate">
                                                        <i class="icon-eye-open icon-white"></i> View
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-mini btn-warning" 
                                                            title="Edit Certificate"
                                                            onclick="window.location.href='scheduledate.php?id=<?php echo $certificate['certificate_id']; ?>';">
                                                        <i class="icon-edit icon-white"></i> Edit
                                                    </button>
                                                    <a href="javascript:void(0);" 
                                                       class="btn btn-mini btn-danger" title="Delete Certificate"
                                                       onclick="if(confirm('Are you sure you want to delete this certificate? This action cannot be undone.')) { window.location.href='baptismal_certificates.php?delete=<?php echo $certificate['certificate_id']; ?>'; }">
                                                        <i class="icon-trash icon-white"></i> Delete
                                                    </a>
                                                </div>
                                                <!-- Debug info -->
                                                <small style="color: #999; display: block; margin-top: 5px;">
                                                    ID: <?php echo $certificate['certificate_id']; ?> | 
                                                    <a href="test_edit.php?id=<?php echo $certificate['certificate_id']; ?>" target="_blank">Debug Test</a>
                                                </small>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <?php if($total_pages > 1): ?>
                                <div class="pagination pagination-centered">
                                    <ul>
                                        <?php if($page > 1): ?>
                                        <li>
                                            <a href="?page=<?php echo $page-1; ?><?php echo !empty($search) ? '&search='.$search : ''; ?>">
                                                &laquo; Previous
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        
                                        <?php
                                        $start_page = max(1, $page - 2);
                                        $end_page = min($total_pages, $page + 2);
                                        
                                        for($i = $start_page; $i <= $end_page; $i++):
                                        ?>
                                        <li <?php echo ($i == $page) ? 'class="active"' : ''; ?>>
                                            <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search='.$search : ''; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                        <?php endfor; ?>
                                        
                                        <?php if($page < $total_pages): ?>
                                        <li>
                                            <a href="?page=<?php echo $page+1; ?><?php echo !empty($search) ? '&search='.$search : ''; ?>">
                                                Next &raquo;
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>

                                <?php else: ?>
                                
                                <!-- No certificates found -->
                                <div class="alert alert-info">
                                    <h4>No Certificates Found</h4>
                                    <?php if(!empty($search)): ?>
                                    <p>No certificates match your search criteria: <strong>"<?php echo htmlspecialchars($search); ?>"</strong></p>
                                    <p>
                                        <a href="baptismal_certificates.php" class="btn btn-small">
                                            <i class="icon-arrow-left"></i> View All Certificates
                                        </a>
                                    </p>
                                    <?php else: ?>
                                    <p>No baptismal certificates have been generated yet.</p>
                                    <p>
                                        <a href="scheduledate.php" class="btn btn-success">
                                            <i class="icon-plus icon-white"></i> Generate Your First Certificate
                                        </a>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                
                                <?php endif; ?>

                                <!-- Quick Stats -->
                                <div class="row-fluid" style="margin-top: 30px;">
                                    <div class="span12">
                                        <div class="alert alert-success">
                                            <h5>Quick Statistics</h5>
                                            <?php
                                            $stats_query = mysqli_query($conn, "SELECT 
                                                COUNT(*) as total_certs,
                                                COUNT(DISTINCT member_id) as unique_members,
                                                MIN(certificate_id) as first_cert_id,
                                                MAX(certificate_id) as latest_cert_id
                                                FROM baptismal_certificates") or die(mysqli_error($conn));
                                            $stats = mysqli_fetch_array($stats_query);
                                            ?>
                                            <div class="row-fluid">
                                                <div class="span3">
                                                    <strong>Total Certificates:</strong><br>
                                                    <span class="badge badge-info"><?php echo $stats['total_certs']; ?></span>
                                                </div>
                                                <div class="span3">
                                                    <strong>Unique Members:</strong><br>
                                                    <span class="badge badge-success"><?php echo $stats['unique_members']; ?></span>
                                                </div>
                                                <div class="span3">
                                                    <strong>First Certificate:</strong><br>
                                                    #<?php echo $stats['first_cert_id'] ? $stats['first_cert_id'] : 'N/A'; ?>
                                                </div>
                                                <div class="span3">
                                                    <strong>Latest Certificate:</strong><br>
                                                    #<?php echo $stats['latest_cert_id'] ? $stats['latest_cert_id'] : 'N/A'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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