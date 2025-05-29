<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php
// Get filter parameters
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$transaction_type = isset($_GET['transaction_type']) ? $_GET['transaction_type'] : '';
$member_search = isset($_GET['member_search']) ? $_GET['member_search'] : '';

// Build WHERE clause for filters
$where_conditions = array();
$where_conditions[] = "donation.titheid IS NOT NULL";

if (!empty($date_from) && !empty($date_to)) {
    $where_conditions[] = "DATE(donation.paytime) BETWEEN '$date_from' AND '$date_to'";
} elseif (!empty($date_from)) {
    $where_conditions[] = "DATE(donation.paytime) >= '$date_from'";
} elseif (!empty($date_to)) {
    $where_conditions[] = "DATE(donation.paytime) <= '$date_to'";
}

if (!empty($transaction_type)) {
    $where_conditions[] = "donation.type = '$transaction_type'";
}

if (!empty($member_search)) {
    $where_conditions[] = "(members.fname LIKE '%$member_search%' OR members.lname LIKE '%$member_search%' OR members.mobile LIKE '%$member_search%')";
}

$where_clause = implode(' AND ', $where_conditions);
?>

<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar.php'); ?>
            
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- Header -->
                    <div class="empty">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon-info-sign"></i> <strong>Donations Report</strong> - Filter and analyze donation data
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><i class="icon-filter"></i> Report Filters</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <form method="GET" class="form-horizontal">
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <label>Date From:</label>
                                            <input type="date" name="date_from" class="input-small" value="<?php echo $date_from; ?>">
                                        </div>
                                        <div class="span3">
                                            <label>Date To:</label>
                                            <input type="date" name="date_to" class="input-small" value="<?php echo $date_to; ?>">
                                        </div>
                                        <div class="span3">
                                            <label>Transaction Type:</label>
                                            <select name="transaction_type" class="input-medium">
                                                <option value="">All Types</option>
                                                <option value="GCASH" <?php echo ($transaction_type == 'GCASH') ? 'selected' : ''; ?>>GCASH</option>
                                                <option value="MAYA" <?php echo ($transaction_type == 'MAYA') ? 'selected' : ''; ?>>MAYA</option>
                                                <option value="BDO" <?php echo ($transaction_type == 'BDO') ? 'selected' : ''; ?>>BDO</option>
                                                <option value="CASH" <?php echo ($transaction_type == 'CASH') ? 'selected' : ''; ?>>CASH</option>
                                            </select>
                                        </div>
                                        <div class="span3">
                                            <label>Member Search:</label>
                                            <input type="text" name="member_search" class="input-medium" placeholder="Name or Mobile" value="<?php echo $member_search; ?>">
                                        </div>
                                    </div>
                                    <div class="row-fluid" style="margin-top: 10px;">
                                        <div class="span12">
                                            <button type="submit" class="btn btn-primary"><i class="icon-search"></i> Filter Report</button>
                                            <a href="donations_report.php" class="btn btn-warning"><i class="icon-refresh"></i> Clear Filters</a>
                                            <a href="print_donations_report.php?<?php echo http_build_query($_GET); ?>" class="btn btn-info" target="_blank"><i class="icon-print"></i> Print Report</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Get donation data with filters
                    $donation_query = mysqli_query($conn, "
                        SELECT 
                            donation.*,
                            members.fname,
                            members.lname,
                            members.mobile,
                            members.Residence
                        FROM donation 
                        LEFT JOIN members ON members.id = donation.na 
                        WHERE $where_clause
                        ORDER BY donation.paytime DESC
                    ") or die(mysqli_error());
                    
                    $donation_count = mysqli_num_rows($donation_query);
                    
                    // Calculate summary statistics
                    $summary_query = mysqli_query($conn, "
                        SELECT 
                            COUNT(*) as total_donations,
                            SUM(CAST(donation.Amount AS DECIMAL(10,2))) as total_amount,
                            AVG(CAST(donation.Amount AS DECIMAL(10,2))) as average_amount,
                            donation.type,
                            COUNT(*) as type_count,
                            SUM(CAST(donation.Amount AS DECIMAL(10,2))) as type_total
                        FROM donation 
                        LEFT JOIN members ON members.id = donation.na 
                        WHERE $where_clause
                        GROUP BY donation.type
                        ORDER BY type_total DESC
                    ") or die(mysqli_error());
                    
                    // Get overall totals
                    $total_query = mysqli_query($conn, "
                        SELECT 
                            COUNT(*) as total_donations,
                            SUM(CAST(donation.Amount AS DECIMAL(10,2))) as total_amount,
                            AVG(CAST(donation.Amount AS DECIMAL(10,2))) as average_amount
                        FROM donation 
                        LEFT JOIN members ON members.id = donation.na 
                        WHERE $where_clause
                    ") or die(mysqli_error());
                    
                    $totals = mysqli_fetch_array($total_query);
                    ?>

                    <!-- Summary Statistics -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><i class="icon-bar-chart"></i> Donation Summary</div>
                            <div class="muted pull-right">
                                Report Date: <?php echo date('l, F jS, Y'); ?>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="row-fluid">
                                <div class="span3">
                                    <div class="alert alert-success">
                                        <h4><?php echo number_format($totals['total_donations']); ?></h4>
                                        <p>Total Donations</p>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="alert alert-info">
                                        <h4>₱<?php echo number_format($totals['total_amount'], 2); ?></h4>
                                        <p>Total Amount</p>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="alert alert-warning">
                                        <h4>₱<?php echo number_format($totals['average_amount'], 2); ?></h4>
                                        <p>Average Donation</p>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="alert alert-inverse">
                                        <h4><?php echo date('M Y'); ?></h4>
                                        <p>Report Period</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Type Breakdown -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><i class="icon-credit-card"></i> Transaction Type Breakdown</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Transaction Type</th>
                                            <th>Count</th>
                                            <th>Total Amount</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        mysqli_data_seek($summary_query, 0);
                                        while ($summary = mysqli_fetch_array($summary_query)) {
                                            $percentage = ($summary['type_total'] / $totals['total_amount']) * 100;
                                            ?>
                                            <tr>
                                                <td><strong><?php echo $summary['type'] ?: 'Not Specified'; ?></strong></td>
                                                <td><?php echo number_format($summary['type_count']); ?></td>
                                                <td>₱<?php echo number_format($summary['type_total'], 2); ?></td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="bar" style="width: <?php echo $percentage; ?>%"></div>
                                                    </div>
                                                    <?php echo number_format($percentage, 1); ?>%
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Donations List -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><i class="icon-list"></i> Detailed Donations List</div>
                            <div class="muted pull-right">
                                Number of Records: <span class="badge badge-info"><?php echo $donation_count; ?></span>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="example">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Member Name</th>
                                            <th>Mobile</th>
                                            <th>Amount</th>
                                            <th>Transaction Code</th>
                                            <th>Type</th>
                                            <th>Residence</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_displayed = 0;
                                        while ($row = mysqli_fetch_array($donation_query)) {
                                            $total_displayed += floatval($row['Amount']);
                                            ?>
                                            <tr>
                                                <td><?php echo date('M d, Y', strtotime($row['paytime'])); ?></td>
                                                <td>
                                                    <?php 
                                                    if ($row['fname'] && $row['lname']) {
                                                        echo $row['fname'] . " " . $row['lname'];
                                                    } else {
                                                        echo '<em>Member not found</em>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $row['mobile'] ?: 'N/A'; ?></td>
                                                <td><strong>₱<?php echo number_format($row['Amount'], 2); ?></strong></td>
                                                <td><?php echo $row['Trcode']; ?></td>
                                                <td>
                                                    <span class="label label-info"><?php echo $row['type'] ?: 'N/A'; ?></span>
                                                </td>
                                                <td><?php echo $row['Residence'] ?: 'N/A'; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="info">
                                            <td colspan="3"><strong>TOTAL DISPLAYED:</strong></td>
                                            <td><strong>₱<?php echo number_format($total_displayed, 2); ?></strong></td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Summary (if no date filter is applied) -->
                    <?php if (empty($date_from) && empty($date_to)) { ?>
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><i class="icon-calendar"></i> Monthly Summary (Last 12 Months)</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <?php
                                $monthly_query = mysqli_query($conn, "
                                    SELECT 
                                        DATE_FORMAT(donation.paytime, '%Y-%m') as month_year,
                                        DATE_FORMAT(donation.paytime, '%M %Y') as month_name,
                                        COUNT(*) as donation_count,
                                        SUM(CAST(donation.Amount AS DECIMAL(10,2))) as monthly_total
                                    FROM donation 
                                    WHERE donation.paytime >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                                    GROUP BY DATE_FORMAT(donation.paytime, '%Y-%m')
                                    ORDER BY month_year DESC
                                ") or die(mysqli_error());
                                ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Donations Count</th>
                                            <th>Total Amount</th>
                                            <th>Average</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($monthly = mysqli_fetch_array($monthly_query)) { ?>
                                        <tr>
                                            <td><?php echo $monthly['month_name']; ?></td>
                                            <td><?php echo number_format($monthly['donation_count']); ?></td>
                                            <td>₱<?php echo number_format($monthly['monthly_total'], 2); ?></td>
                                            <td>₱<?php echo number_format($monthly['monthly_total'] / $monthly['donation_count'], 2); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
</body>
</html>