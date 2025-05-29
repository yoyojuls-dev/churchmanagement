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
                                            <input class="input focused" name="amount" id="focusedInput" type="text" placeholder = "Amount" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="trcode" id="focusedInput" type="text" placeholder = "Transaction Code" required>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <div class="controls">
                                          <label for="ttype" name="ttype" id="focusedInput" data-icon="u">Type</label>
                                            <select name="ttype" class="input focused">
                                            <option value="None">None</option>
                                            <option value="GCASH">Gcash</option>
                                            <option value="MAYA">Maya</option>
                                            <option value="PAYPAL">PayPal</option>
                                            <option value="BDO">BDO</option>
                                            <option value="OtherBanks">Other Banks</option>
                                            </select>
                                            </p>
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
    $firstname = $_POST['amount'];
    $lastname = $_POST['trcode'];
    $ttype = $_POST['ttype'];  // Corrected variable name

    mysqli_query($conn,"INSERT INTO donation (Amount,Trcode,na,type) values('$firstname','$lastname','$session_id','$ttype' )")or die(mysqli_error());

?>
<script>
    window.location = "donation.php";
    $.jGrowl("The Giving Successfully added", { header: 'Giving added' });
</script>
<?php
}

?>
