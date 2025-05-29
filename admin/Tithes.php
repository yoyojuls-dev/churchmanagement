<?php include('header.php'); ?>
<?php include('session.php'); ?>
<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar.php'); ?>
            <div class="span3" id="adduser">
                <?php include('add_tithe.php'); ?>
            </div>
            <div class="span9" id="content">
                <div class="row-fluid">
                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('#add').tooltip('show');
                        $('#add').tooltip('hide');
                    });
                    </script>
                    <div id="sc" align="center">
                        <img src="images/sclogo.png" width="45%" height="45%" />
                    </div>
                    <?php
                    $count_tithe = mysqli_query($conn, "SELECT * FROM tithe");
                    $count = mysqli_num_rows($count_tithe);
                    ?>
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><i class="icon-reorder icon-large"></i> Tithe List</div>
                            <div class="muted pull-right">
                                Number of Tithes: <span class="badge badge-info"><?php echo $count; ?></span>
                            </div>
                        </div>
                        <h4 id="sc">
                            <div align="right" id="sc">Date:
                                <?php
                                $date = new DateTime();
                                echo $date->format('l, F jS, Y');
                                ?>
                            </div>
                        </h4>
                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div class="empty">
                                    <div class="pull-right">
                                        <a href="print_tithe.php" class="btn btn-info" id="print" data-placement="left" title="Click to Print">
                                            <i class="icon-print icon-large"></i> Print List
                                        </a>
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
                                                <th>Transaction Code</th>
                                                <th>Amount</th>
                                                <th>Date & Time</th>
                                                <th>Type of Transaction</th>
                                                <th>Purpose</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tithe_query = mysqli_query($conn, "SELECT * FROM tithe") or die(mysqli_error());
                                            while ($row = mysqli_fetch_array($tithe_query)) {
                                                $titheid = $row['titheid'];
                                            ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['trcode']; ?></td>
                                                <td><?php echo $row['amount']; ?></td>
                                                <td><?php echo $row['paytime']; ?></td>
                                                <td><?php echo $row['ttype']; ?></td>
                                                <td><?php echo $row['purpose']; ?></td>
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
