<?php 
	require_once "ewsd_connection.php"; 
?>

<?php 
	session_start(); 
?>

<?php
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['email'],$_POST['password'])){
		$email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
		$password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
		
		$sql = "SELECT `id`,`email`, `password`, `name`, `role` ,`faculty` FROM `account` WHERE `email` = ?";
		
		if($stmt = mysqli_prepare($conn, $sql)){
			
			mysqli_stmt_bind_param($stmt, "s", $email);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			
			if(mysqli_stmt_num_rows($stmt) == 1){
				mysqli_stmt_bind_result($stmt, $c1, $c2, $c3,$c4,$c5,$c6);
				mysqli_stmt_fetch($stmt);
				
				if(password_verify($password,$c3)){
					$_SESSION['isLogin'] = true;
					$_SESSION['name'] = $c4;
					$_SESSION['email'] = $c2;
					$_SESSION['role'] = $c5;
					$_SESSION['faculty']= $c6;
				}
				else{
					echo"<script>alert('Fail to login')</script>";
				}
			}
			else{
				echo "<script>alert('Email not registered!')</script>";
			}
			mysqli_stmt_free_result($stmt);
			mysqli_stmt_close($stmt);
		}
	}
?>

<?php
	if(isset($_SESSION['isLogin'], $c5) && $_SESSION['isLogin']){
		$role = $c5;
		
		switch($role){
			case "Manager" : header("Location: manager/ewsd_manager.php");
								   exit;
								   break;
			case "Coordinator" : 	header("Location: coordinator/ewsd_coordinator.php");
								exit;
								break;
			case "Student" : 	header("Location: student/ewsd_studenthome.php");
											exit;
											break;
			case "Admin": header("Location: admin/ewsd_admin.php");
									exit;
									break;
			case "Guest": header("Location: guest/ewsd_guest.php");
						exit;
						break;
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>University Login System</title>
<link rel="stylesheet" type="text/css" href="ewsd_Login.css">
</head> 
<body>
<div class="image"></div>
	<div id="container">
		<div id="containerH" >
			<h1>Blackboard</h1>
		</div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">
		<div id="container1">
			<input type="email" placeholder="email" name="email" required>
			<input type="password" placeholder="Password" name="password" required>
			<button type="submit" value="Login">Login</button>
		</div>
		</form>
		<div id="container1" style="">
			<span id="forgot"><a href="ewsd_ForgotPass.php" id="forgotPass"> Forgot Password</a></span>	
			<br />
			<br />
			<span id="view"><a href="ewsd_guest.php" id="viewGuest"> View as Guest</a></span>
	
		</div>
		
		<div> </div>
	</div>
	<footer>
		<p class="text-muted text-center"><small>Copyright © EWSD</small></p>
	</footer>
</body>
</html>