
  <div class="row-fluid">
                        <!-- block -->
 <div class="block">
 <div class="navbar navbar-inner block-header">
<div class="muted pull-left"><i class="icon-plus-sign icon-large"> Register New Kid</i></div>
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
                                     <input class="input focused" name="mname" id="focusedInput" type="text" placeholder = "Middle Name" required> 
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
                                     <select class="input focused" name="Gender" id="focusedInput" required="required" type="text">
  <option value="Select Gender">Select Gender</option>
  <option value="Male">Male</option>
  <option value="Female">Female</option>

</select>  
                                   </p>
                                 </div>
                                  </div>
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>Schedule a Date
                                     <input class="input focused" name="sched" id="focusedInput" type="date" placeholder = "Birthday" required> 
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
                                     <input class="input focused" name="purpose" id="focusedInput" type="text" placeholder = "Purpose" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>		
										
										<div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" name="pay" id="focusedInput" type="text" placeholder = "Willing Amount to Pay" required> 
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
error_reporting(1);
if (isset($_POST['save'])){
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$Gender = $_POST['Gender'];
$sched = $_POST['sched'];
$residence= $_POST['residence'];
$purpose = $_POST['purpose'];
$pay= $_POST['pay'];
$mobile= $_POST['mobile'];
$email= $_POST['email'];
$password = $_POST['password'];


$query = @mysqli_query($conn,"select * from sundays where  mobile = '$mobile'  ")or die(mysqli_error());
$count = mysqli_num_rows($query);

if ($count > 0){ ?>
<script>
alert('This kid  Already Exists');
</script>
<?php
}else{
mysqli_query($conn,"insert into sundays(fname,sname,lname,Gender,birthday,residence,pob,ministry,mobile,thumbnail,id) 
values('$fname','$mname','$lname','$Gender','$sched','$residence','$purpose','$pay','$mobile','uploads/none.png','$mobile')")or die(mysqli_error());

mysqli_query($conn,"insert into activity_log (date,username,action) values(NOW(),'$admin_username','Added member $mobile')")or die(mysqli_error());
?>
<script>
window.location = "add_sundaysch.php";
$.jGrowl("member Successfully added", { header: 'member add' });
</script>
<?php
}
}
?>