<?php 
	require_once "ewsd_connection.php"
?>

<?php 
	session_start(); 
    if($_SESSION['role'] != "Coordinator")
    {
        header("Location: ../ewsd_login.php");
    }

define('TIMEZONE', 'Asia/Kuala_Lumpur');
date_default_timezone_set(TIMEZONE);
if(isset($_GET["id"]))
{
    $_SESSION["id"] = $_GET["id"];
}
$name = $_SESSION["name"];
$id = $_SESSION["id"];
 if(isset($_POST["comment"]))  
 {   
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['comment_text']))
        {
            $cmtext = filter_var($_POST['comment_text'],FILTER_SANITIZE_STRING);
            $dt = date("Y-m-d H:i:s");
            $query3 = "INSERT INTO  comment(`comments`, `time_posted`, `name`, `postid`) VALUES('$cmtext', '$dt', '$name','$id')";  
            if (mysqli_query($conn, $query3))
            {
                 echo '<script>alert("Succesfully commented on post!")</script>';
            } 
            else 
            {
                 echo '<script>alert("Failed to comment on post!")</script>';
            }
                
                
        }

	   
 }  
 if(isset($_POST["comment"]))  
 {   
    $insert = $db->query("UPDATE submission SET comments = 'true' WHERE id = '".$_SESSION["id"]."'");
    if($insert){
                     echo "<script>alert('Successfully commented on student's post!');</script>";
    }
 
 }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Comment and reply system in PHP</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link rel="stylesheet" href="main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    h5{
             font-weight: bold;
            }
    html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

    #btnHome{
               background-color: white;
               border: none;
               margin-left:20px;   
    }

    #container{
        width:100%;
    }

</style>
</head>
<body class="w3-light-grey">
<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
<button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right"><a href="#" onclick="window.location.href='../ewsd_logout.php'" title="close menu">Log Out</a></span>
    
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    
    <div class="w3-col s8 w3-bar">
    <span><?php echo "Hi ".$_SESSION['name']."! Have a nice day!" ?></span><br>
      <!-- <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a> -->
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home"></i><button id="btnHome" onclick="window.location.href='../coordinator/ewsd_coordinator.php'">Home</button></a>
    
    
    
  </div>
</nav>


     <!-- Overlay effect when opening sidebar on small screens -->
     <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

     <!-- !PAGE CONTENT! -->
     <div class="w3-main" style="margin-left:300px;margin-top:43px;">

     <!-- Header -->
     <header class="w3-container" style="padding-top:22px">
     <h5><b><i class="fa fa-dashboard"></i> Comment</b></h5>
     
     </header> 

<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 post">
			<h2></h2>
			<p></p>
		</div>

		<!-- comments section -->
		<div class="col-md-6 col-md-offset-3 comments-section">
			<!-- comment form -->
			<form class="clearfix" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="comment_form">
				<h4>Post a comment:</h4>
				<textarea name="comment_text" id="comment_text" class="form-control" cols="30" rows="3"></textarea>
                <br />
				<button type="submit" class="btn btn-primary btn-sm pull-right" id="submit_comment" name="comment">Submit comment</button>
			</form>

			<!-- Display total number of comments on this post  -->
			<h2><span id="comments_count"></span> Comments for this post:</h2>
			<hr>
			<!-- comments wrapper -->
			<div id="comments-wrapper">
				<div class="comment clearfix">
						<img src="profile.png" alt="" class="profile_pic">
						<div class="comment-details">
                        <?php

                            $sql = "SELECT * FROM comment WHERE postid ='".$_SESSION['id']."'";
                            // Get images from the database
                            $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "

                                    <div class='comment reply clearfix'>
								    <img src='profile.png' alt='' class='profile_pic'>
								    <div class='comment-details'>
                                    <span class='comment-name'>".$row["name"]."</span>
                                    <span class='comment-date'>".$row["time_posted"]."</span>
                                    <p>".$row["comments"]."</p>";?>
                                    
                                    </div>
                                <div>
                                <?php
                                
                                }
                                } else {
                                echo "0 results";
                                }

                                mysqli_close($conn);
        
                                ?>
							<!-- reply -->
							
						</div>
					</div>
			</div>
			<!-- // comments wrapper -->
		</div>
		<!-- // comments section -->
	</div>
    <button onclick="window.location.href='../coordinator/ewsd_coordinator.php'" class="btn btn-info" style="floa:left;">Back</button>
</div>
<!-- Javascripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap Javascript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
          // Get the Sidebar
          var mySidebar = document.getElementById("mySidebar");

          // Get the DIV with overlay effect
          var overlayBg = document.getElementById("myOverlay");

          // Toggle between showing and hiding the sidebar, and add overlay effect
          function w3_open() {
          if (mySidebar.style.display === 'block') {
          mySidebar.style.display = 'none';
          overlayBg.style.display = "none";
          } else {
          mySidebar.style.display = 'block';
          overlayBg.style.display = "block";
          }
          }

          // Close the sidebar with the close button
          function w3_close() {
          mySidebar.style.display = "none";
          overlayBg.style.display = "none";
          }
          </script> 
</body>
</html>

