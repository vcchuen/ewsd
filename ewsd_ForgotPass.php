<?php require_once "ewsd_connection.php"; ?>

<?php //send email to user
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require 'vendor/autoload.php';

	define ("MYGMAIL", "voon.chuen@gmail.com");
	define ("MYAPPPASS", "hovyoeqwgduelezl");

	function sendEmail($randPass){
		$mail = new PHPMailer();

		try{
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			
			//Your email
			$sender_email = MYGMAIL;
			$mail->Username = $sender_email;
			$mail->Password = MYAPPPASS;
			
			//Receipient's email
			$to = $_POST['email'];
			$mail->From = $sender_email;
			$mail->FromName = "Blackboard System";
			$mail->AddAddress($to);
			$mail->AddReplyTo($sender_email, "Administrator");
			
			$content = "<h2>Your new password is <mark>$randPass</mark><h2>";
			
			$mail->IsHTML(true);
			$mail->WordWrap = 50;
			$mail->Subject = "New Password";
			$mail->Body = $content;
			
			if($mail->Send()){
				echo "<script>alert('Password reset Successfully.');</script>";
			}
		}
		catch(Exception $ex){
			echo "<script>alert('Email could not be sent.')</script>";
			echo "<p>Mailer Error: " . $mail->ErrorInfo . "</p>";
		}
	}
?>

<?php //random new password
	function genNewPass(){
		$letterUpper = range("A","Z");
		$letterLower = range('a', 'z');
		$nums = range (0,9);
		$symbols = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "_", "+", "=");
		$letterMix = array_merge($letterLower, $letterUpper, $nums, $symbols);
		
		shuffle($letterMix);
		$indices = array_rand($letterMix, 15);
		
		$randPass = "";
		foreach($indices as $i){
			$randPass .= $letterMix[$i];
		}
		
		return $randPass;
	}
?>


<?php //Reset the password and send through to database and email
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['email']) && $_POST['submit']){

		$email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
		$pass = genNewPass();
		$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

		
		$sql = "UPDATE `account` SET `password`= ?  WHERE `email` = ?";
		if($stmt = mysqli_prepare($conn ,$sql)){
			
			mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
			
			mysqli_stmt_execute($stmt);
			
			if(mysqli_stmt_affected_rows($stmt) == 1){
				sendEmail($pass);
			}
			else{
				echo "<script>alert('Fail to reset/Invalid username');</script>";
			}
			mysqli_stmt_close($stmt);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
<link rel="stylesheet" type="text/css" href="ewsd_ForgetPass.css">
</head>
<body>

	<div id="container">
		<h2>Forgot your password?</h2>
		
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<p><input class="email" type="email" name="email" placeholder=" Enter your email address"></p>
			<input type="submit" value="Submit" name="submit" class="submit">
			<div id="back">
			<?php
				echo "<a href=ewsd_Login.php>Previous Page</a>";
			?>
			</div>
		</form>
	</div>
</body>
</html>