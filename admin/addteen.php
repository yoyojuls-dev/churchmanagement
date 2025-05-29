
  <div class="row-fluid">
                        <!-- block -->
 <div class="block">
 <div class="navbar navbar-inner block-header">
<div class="muted pull-left"><i class="icon-plus-sign icon-large"> Application Form</i></div>
</div>
<div class="block-content collapse in">
                                <div class="span12">
								
								 <!--------------------form------------------->
								<form method="post">
					<div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" name="fname" id="focusedInput" type="text" placeholder = "First Name" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" name="mname" id="focusedInput" type="text" placeholder ="Middle Name" required> 
                                   </p>
                                 </div>
                                  </div>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" name="lname" id="focusedInput" type="text" placeholder = "Last name" required> 
                                   </p>
                                 </div>
                                  </div>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                      <select class="input focused" name="gender" id="focusedInput" required="required" type="text">
  <option value="Select Gender">Select Gender</option>
  <option value="Male">Male</option>
  <option value="Female">Female</option>

</select>   
                                   </p>
                                 </div>
                                  </div>
                                  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                      <select class="input focused" name="apfor" id="focusedInput" required="required" type="text">
  <option value="Select Gender">Applying For</option>
  <option value="None">None</option>
  <option value="Ministry of Altar Servers">Ministry of Altar Servers</option>
  <option value="Parish Youth Ministry">Parish Youth Ministry</option>
  <option value="Lectors and Commentators Ministry">Lectors and Commentators Ministry</option>
  <option value="Extra-Ordinary Ministry of Holy Communion">Extra-Ordinary Ministry of Holy Communion</option>
  <option value="Social Communications and Media Ministry">Social Communications and Media Ministry</option>
  <option value="Public Affairs Ministry">Public Affairs Ministry</option>
  <option value="Social Action Ministry">Social Action Ministry</option>
  <option value="Family and Life Ministry">Family and Life Ministry</option>
  <option value="Others">Others</option>

</select>   
                                   </p>
                                 </div>
                                  </div>
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     Schedule a Date
                                     <input class="input focused" name="sched" id="focusedInput" type="date" placeholder = "Schedule a Date" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" name="residence" id="focusedInput" type="text" placeholder = "Residence" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
								<div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" name="pob" id="focusedInput" type="text" placeholder = "Place of Birth" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>		
										
										<div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" name="purpose" id="focusedInput" type="text" placeholder = "Purpose" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
									<div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" name="mobile" id="focusedInput" type="text" placeholder = "Mobile Number" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                    
                                   </p>
                                 </div>
                                  </div>
								  </p>
								 							 
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                   </p>
                                 </div>
                                  </div>
								  </p>
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
                  				 
<?php
if (isset($_POST['save'])){
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$gender = $_POST['gender'];
$apfor = $_POST['apfor'];
$sched = $_POST['sched'];
$residence= $_POST['residence'];
$pob = $_POST['pob'];
$mobile= $_POST['mobile'];
$purpose = $_POST['purpose'];



$query = @mysqli_query($conn,"select * from apply where  mobile = '$mobile'  ")or die(mysqli_error());
$count = mysqli_num_rows($query);

if ($count > 0){ ?>
<script>
alert('This Applicant  Already Exists');
</script>
<?php
}else{
mysqli_query($conn,"insert into apply (fname,mname,lname,gender,apfor,sched,residence,pob,purpose,mobile) 
values('$fname','$mname','$lname','$gender','$apfor','$sched','$residence','$pob','$purpose','$mobile')")or die(mysqli_error());

mysqli_query($conn,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Added member $mobile')")or die(mysqli_error());
?>
<script>
window.location = "add_teen.php";
$.jGrowl("member Successfully added", { header: 'member add' });
</script>
<?php
}
}
?>