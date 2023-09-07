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
                        <div id="twitter-login-container" style="margin-top: 30px">
                            <button id="twitter-login-button">
								<svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
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

	<script>
		document.getElementById('twitter-login-button').onclick = function() {
            window.location.href = 'https://api.twitter.com/oauth/authenticate?oauth_consumer_key=YOUR_TWITTER_API_KEY&oauth_token=YOUR_OAUTH_TOKEN';
        }
	</script>

</body>
</html>
