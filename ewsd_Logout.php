<?php 
	session_start();
?>

<?php 

	if(isset($_SESSION)){
	setcookie(session_name(), '', time() - 2592000);
	session_destroy();
	header('Location: ewsd_Login.php');
	}
	
?>
