<?php  require_once('../connect.php');
//$conn = new mysqli('localhost','root','','db_2fa');

$sql_2v = "CREATE TABLE IF NOT EXISTS tbl_2vs (
id INT(99) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(25) NOT NULL,
status INT(1) NOT NULL,
auth_key VARCHAR(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$conn->query($sql_2v);

if(isset($_POST['send'])) {
$a=htmlspecialchars($_POST["myusername"]);
$b=$_POST["mypassword"];
$myusername=stripslashes($a);
$mypassword=md5($b);

$query_2v = $conn->query("SELECT * FROM tbl_2vs WHERE username = '$myusername' ");
$num_rows_2v = $query_2v->num_rows;
$val_2v = mysqli_fetch_assoc($query_2v);
$sattus_2v = $val_2v['status'];

setcookie('username', $_POST['myusername'], time()+60*60*24*30, '/');
setcookie('password',$_POST['mypassword'], time()+60*60*24*30, '/');
$query="SELECT * FROM users WHERE username='$myusername' AND password='$b'";
$result=$conn->query($query);
if($result->num_rows>0) {
while ($row=$result->fetch_assoc()) {
	if ($num_rows_2v > 0 && $sattus_2v == 1) {
	    header('location:two-step.php?a='.$myusername);
	}else{
		$u2=$row["username"];
		$_SESSION["u2"]=$u2;
		unset($_SESSION['ilog2']);
		$_SESSION['ilog']=1;
		header('location:../dashboard/index.php');
	}
}} else{
echo "<div class='alert alert-warning'> Login Details incorrect!</div>";
    $_SESSION['ilog2']=2;
    unset($_SESSION['ilog']);
  }

}


 ?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Boerse Login zur Ihrer Euro Geldboerse</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="../images/favicon_home.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="https://www.boerse.website/account/css/util.css">
	<link rel="stylesheet" type="text/css" href="https://www.boerse.website/account/css/main.css">
<!--===============================================================================================-->

</head>
<body>
    <?php  include("header.php"); ?>



		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title p-b-26">
						Login
					</span>

					<span class="login100-form-title p-b-48">

					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter valid username">
						<input class="input100" type="text" name="myusername" value="<?php if(isset($_COOKIE['username'])
									&& isset($_COOKIE['password']))
									{ echo  $_COOKIE['username']; }  ?>">
						<span class="focus-input100" data-placeholder="Nutzername"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="mypassword"  value="<?php if(isset($_COOKIE['username'])
&& isset($_COOKIE['password'])) { echo  $_COOKIE['password']; } ?>">
						<span class="focus-input100" data-placeholder="Passwort"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" name="send">
								Login
							</button>
						</div>
					</div>

					<div class="text-center p-t-115">
						<span class="txt1">
							Noch kein Boerse Account vorhanden?
						</span>

						<a class="txt2" href="signup.php">
							Hier registrieren.
						</a>

						<div class="text-center p-t-115">
						<span class="txt1"></span>
						<a class="txt2" href="forgot-password.php">Passwort vergessen? Hier anfordern.</a>
					</div>
				</form>
			</div>
		</div>
	</div>

 <?php include("footer.php"); ?>
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>










</body>
</html>
