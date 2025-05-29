<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><i class="icon-plus-sign icon-large"> Enter Your Giving</i></div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form method="post">
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" name="name" id="focusedInput" type="text" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <select name="gender" class="input focused" required>
                                <option value="" disabled selected>Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" name="amount" id="focusedInput" type="text" placeholder="Amount" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" name="trcode" id="focusedInput" type="text" placeholder="Transaction Code" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" name="na" id="focusedInput" type="text" placeholder="Mobile Number" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <select name="type" class="input focused" required>
                                <option value="" disabled selected>Type</option>
                                <option value="Gcash">Gcash</option>
                                <option value="Maya">Maya</option>
                                <option value="PayPal">PayPal</option>
                                <option value="BDO">BDO</option>
                                <option value="OtherBanks">Other Banks</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" name="purpose" id="focusedInput" type="text" placeholder="Purpose" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button name="save" class="btn btn-info" id="save" data-placement="right" title="Click to Save"><i class="icon-plus-sign icon-large"> Save</i></button>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#save').tooltip('show');
                                    $('#save').tooltip('hide');
                                });
                            </script>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /block -->
</div>

<?php
if (isset($_POST['save'])){
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $amount = $_POST['amount'];
    $trcode = $_POST['trcode'];
    $na = $_POST['na'];
    $type = $_POST['type'];
    $purpose = $_POST['purpose'];

    $query = "INSERT INTO tithe (name, gender, amount, trcode, na, ttype, purpose) VALUES ('$name', '$gender', '$amount', '$trcode', '$na', '$type', '$purpose')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo '<script>
            window.location = "Tithes.php"; // Adjust the redirection as necessary
            $.jGrowl("The Giving Successfully added", { header: "Giving added" });
        </script>';
    } else {
        echo '<script>
            $.jGrowl("Error adding the giving", { header: "Error" });
        </script>';
    }
}
?>
