<?php
error_reporting(0);
 $db = mysqli_select_db('cman',@mysqli_connect('localhost','root','')); ?>
<?php
if (isset($_POST['submit'])){
$fname = $_POST['fname'];
$sname = $_POST['sname'];
$lname = $_POST['lname'];
$Gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$residence= $_POST['residence'];
$pob = $_POST['pob'];
$ministry = $_POST['ministry'];
$mobile= $_POST['mobile'];
$email= $_POST['email'];
$password = $_POST['password'];


$query = @mysqli_query($conn,"SELECT * FROM members WHERE  mobile = '$mobile'  ")or die(mysqli_error());
$count = mysqli_num_rows($query);

if ($count > 0){ ?>
<script>
alert('This Member Already Exists');
window.location = "index.php";
</script>
<?php
}else{
mysqli_query($conn,"INSERT INTO members (fname,sname,lname,Gender,birthday,residence,pob,ministry,mobile,email,thumbnail,password,id) 
values('$fname','$sname','$lname','$Gender','$birthday','$residence','$pob','$ministry','$mobile','$email','uploads/none.png','$password','$mobile')")or die(mysqli_error());

mysqli_query($conn,"INSERT INTO activity_log (date,username,action) values(NOW(),'$admin_username','Added member $mobile')")or die(mysqli_error());
?>
<script>
window.location = "index.php";
$.jGrowl("Member Successfully added", { header: 'Member add' });
</script>
<?php
}
}
?>


//<?php
// Database connection settings
// $host = "127.0.0.1"; // Server
// $user = "root";      // Database username
// $pass = "";          // Database password
// $dbname = "cman";    // Database name

// Create connection
// $conn = new mysqli($host, $user, $pass, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Process form data
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $fname = $_POST['fname'];
//     $sname = $_POST['sname'];
//     $lname = $_POST['lname'];
//     $gender = $_POST['gender'];
//     $birthday = $_POST['birthday'];
//     $residence = $_POST['residence'];
//     $mobile = $_POST['mobile'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];

    // Insert data into the `members` table
//     $sql = "INSERT INTO members (fname, sname, lname, Gender, Birthday, Residence, mobile, email, password)
//             VALUES ('$fname', '$sname', '$lname', '$gender', '$birthday', '$residence', '$mobile', '$email', '$password')";

//     if ($conn->query($sql) === TRUE) {
//         echo "Registration successful! <a href='index.php'>Login</a>";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }

// // Close the connection
// $conn->close();
// ?> 
