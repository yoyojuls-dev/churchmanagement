<?php include('header.php'); ?>
<?php include('session.php'); ?>

<?php
// Handle deletion
if(isset($_GET['delete']) && !empty($_GET['delete'])) {
    $dedication_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM dedication WHERE dedication_id = '$dedication_id'") or die(mysqli_error($conn));
    if($delete_query) {
        mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (NOW(), '$admin_username', 'Deleted dedication certificate ID: $dedication_id')");
        echo "<script>alert('Certificate deleted successfully!'); window.location='dedication_certificates.php';</script>";
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
    $search_condition = "WHERE (d.certificate_number LIKE '%$search%' OR 
                               d.child_fname LIKE '%$search%' OR 
                               d.child_lname LIKE '%$search%' OR 
                               d.father_name LIKE '%$search%' OR 
                               d.mother_name LIKE '%$search%' OR 
                               d.officiant LIKE '%$search%')";
}

// Count total records for pagination
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM dedication d $search_condition") or die(mysqli_error($conn));
$count_result = mysqli_fetch_array($count_query);
$total_records = $count_result['total'];
$total_pages = ceil($total_records / $limit);

// Fetch dedication certificates
$dedications_query = mysqli_query($conn, "SELECT d.*, a.firstname, a.lastname 
                                         FROM dedication d 
                                         LEFT JOIN admin a ON d.created_by = a.admin_id 
                                         $search_condition
                                         ORDER BY d.dedication_id DESC 
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
                                <i class="icon-certificate icon-large"></i> Dedication Certificates Management
                            </div>
                            <div class="muted pull-right">
                                <a href="add_dedication.php" class="btn btn-success" title="Generate New Certificate">
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
                                                <a href="dedication_certificates.php" class="btn">
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

                                <?php if(mysqli_num_rows($dedications_query) > 0): ?>
                                
                                <!-- Certificates Table -->
                                <table class="table table-striped table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Certificate No.</th>
                                            <th>Child Name</th>
                                            <th>Parents</th>
                                            <th>Birth Date</th>
                                            <th>Dedication Date</th>
                                            <th>Officiant</th>
                                            <th>Created By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $counter = $offset + 1;
                                        while($dedication = mysqli_fetch_array($dedications_query)): 
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td>
                                                <strong><?php echo $dedication['certificate_number']; ?></strong>
                                            </td>
                                            <td>
                                                <?php 
                                                $child_name = $dedication['child_fname'];
                                                if(!empty($dedication['child_mname'])) {
                                                    $child_name .= ' ' . $dedication['child_mname'];
                                                }
                                                $child_name .= ' ' . $dedication['child_lname'];
                                                echo $child_name; 
                                                ?>
                                                <br>
                                                <small class="muted">
                                                    <?php echo ucfirst($dedication['child_gender']); ?> | 
                                                    Mobile: <?php echo $dedication['parents_mobile']; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <strong>Father:</strong> <?php echo $dedication['father_name']; ?><br>
                                                <strong>Mother:</strong> <?php echo $dedication['mother_name']; ?><br>
                                                <small class="muted"><?php echo $dedication['parents_address']; ?></small>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($dedication['child_birthdate'])); ?><br>
                                                <small class="muted"><?php echo $dedication['child_birthplace']; ?></small>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($dedication['dedication_date'])); ?></td>
                                            <td><?php echo $dedication['officiant']; ?></td>
                                            <td>
                                                <?php 
                                                if(!empty($dedication['firstname']) && !empty($dedication['lastname'])) {
                                                    echo $dedication['firstname'] . ' ' . $dedication['lastname'];
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                                <br>
                                                <small class="muted">
                                                    <?php echo date('M j, Y', strtotime($dedication['created_date'])); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="print_dedication_certificate.php?id=<?php echo $dedication['dedication_id']; ?>" 
                                                       class="btn btn-mini btn-info" target="_blank" title="View Certificate">
                                                        <i class="icon-eye-open icon-white"></i> View
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-mini btn-warning" 
                                                            title="Edit Certificate"
                                                            onclick="window.location.href='edit_dedication.php?id=<?php echo $dedication['dedication_id']; ?>';">
                                                        <i class="icon-edit icon-white"></i> Edit
                                                    </button>
                                                    <a href="javascript:void(0);" 
                                                       class="btn btn-mini btn-danger" title="Delete Certificate"
                                                       onclick="if(confirm('Are you sure you want to delete this certificate? This action cannot be undone.')) { window.location.href='dedication_certificates.php?delete=<?php echo $dedication['dedication_id']; ?>'; }">
                                                        <i class="icon-trash icon-white"></i> Delete
                                                    </a>
                                                </div>
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
                                        <a href="dedication_certificates.php" class="btn btn-small">
                                            <i class="icon-arrow-left"></i> View All Certificates
                                        </a>
                                    </p>
                                    <?php else: ?>
                                    <p>No dedication certificates have been generated yet.</p>
                                    <p>
                                        <a href="add_dedication.php" class="btn btn-success">
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
                                                COUNT(*) as total_dedications,
                                                COUNT(CASE WHEN child_gender = 'Male' THEN 1 END) as male_children,
                                                COUNT(CASE WHEN child_gender = 'Female' THEN 1 END) as female_children,
                                                MIN(dedication_date) as first_dedication,
                                                MAX(dedication_date) as latest_dedication
                                                FROM dedication") or die(mysqli_error($conn));
                                            $stats = mysqli_fetch_array($stats_query);
                                            ?>
                                            <div class="row-fluid">
                                                <div class="span3">
                                                    <strong>Total Dedications:</strong><br>
                                                    <span class="badge badge-info"><?php echo $stats['total_dedications']; ?></span>
                                                </div>
                                                <div class="span3">
                                                    <strong>Male Children:</strong><br>
                                                    <span class="badge badge-primary"><?php echo $stats['male_children']; ?></span>
                                                </div>
                                                <div class="span3">
                                                    <strong>Female Children:</strong><br>
                                                    <span class="badge" style="background-color: #e91e63;"><?php echo $stats['female_children']; ?></span>
                                                </div>
                                                <div class="span3">
                                                    <strong>Latest Dedication:</strong><br>
                                                    <?php echo $stats['latest_dedication'] ? date('M j, Y', strtotime($stats['latest_dedication'])) : 'N/A'; ?>
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