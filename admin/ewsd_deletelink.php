<?php 
	require_once __DIR__ . '/../ewsd_connection.php';
?>

<?php  
 session_start();  
 if($_SESSION['role'] != "Admin") // must be admin 
 {
    header("Location: ../ewsd_login.php");
 }
 
 $query = "TRUNCATE TABLE `submissiondate`";
 if($stmt = mysqli_prepare($conn, $query))
 {
    mysqli_stmt_execute($stmt);
    if(mysqli_stmt_affected_rows($stmt) >= 1){
        echo "<script>alert('Successfully reset all links!');</script>";
        header("Location: admin/ewsd_admin.php");
    }
    else{
        echo "<script>alert('Failed to reset!');</script>";
        header("Location: ewsd_admin.php");
    }
 }
?>