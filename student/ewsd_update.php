<?php 
	require_once "ewsd_connection.php"
?>

<?php 
	session_start(); 
    if($_SESSION['role'] != "Student")
    {
        header("Location: ../ewsd_login.php");
    }
    if(isset($_GET["id"]))
    {
    $_SESSION["id"] = $_GET["id"];
    }
    $studentname = $_SESSION["name"];
   
?>
<br />

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

    .containerMain{
        margin-left:50px;
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
<br />

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
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home"></i><button id="btnHome" onclick="window.location.href='../student/ewsd_studenthome.php'">Home</button></a>
    
    
    
  </div>
</nav>


     <!-- Overlay effect when opening sidebar on small screens -->
     <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

     <!-- !PAGE CONTENT! -->
     <div class="w3-main" style="margin-left:300px;margin-top:43px;">

     <!-- Header -->
     <header class="w3-container" style="padding-top:22px">
     <h5><b><i class="fa fa-dashboard"></i> Upload</b></h5>
     
     </header>  

<!-- <button onclick="window.location.href='../student/ewsd_studenthome.php'">Back to Student Homepage</button> -->

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
        
        
          <?php echo "<div class='containerMain'>
        <form action=".$_SERVER["PHP_SELF"]." method='post' enctype='multipart/form-data' >
                    Select Image File to Upload:<br /><br />
                    <input type='file' name='file'><br /> <br />
                    Please write some description for the Image:<br /> <br />
                    <textarea id='description' name='description' required rows='4' cols='50'>
                    </textarea><br /><br />
                    <input type='checkbox' required name='checkbox' value='check' id='agree' /> I agree to the Terms and Conditions.<br /><br />
                    <input class='btn btn-info' type='submit' name='submit' value='Upload'> <br /> <br />
                    </form> ";

                    $statusMsg = '';

                    // File upload path
                    $targetDir = "uploads/";
                    if(isset($_FILES["file"]))
                        {
                            $fileName = $_SESSION['name']."_".basename($_FILES["file"]["name"]);
                            $targetFilePath = $targetDir .$fileName;
                            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                        }


                    if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
                        // Allow certain file formats
                        $allowTypes = array('jpg','png','jpeg','gif','pdf');
                        $desc = filter_var($_POST["description"],FILTER_SANITIZE_STRING);
                        if(in_array($fileType, $allowTypes)){
                            // Upload file to server
                            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                                // Insert image file name into database
                                $insert = $db->query("UPDATE submission SET file_name = '".$fileName."', uploaded_on = NOW(), description = '".$desc."', comments = 'NULL', approve = 'NULL' WHERE studentname = '".$_SESSION["name"]."' AND faculty = '".$_SESSION["faculty"]."' AND id  = '".$_SESSION["id"]."'");
                                if($insert){
                                    echo "<script>alert('The file ".$fileName." has been updated successfully!');</script>";
                                }else{
                                    $statusMsg = "File upload failed, please try again.";
                                } 
                            }else{
                                $statusMsg = "Sorry, there was an error uploading your file.";
                            }
                        }else{
                            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                        }
                    }else{
                        $statusMsg = '<div class="containerMain">Please select a file to upload.<br /> For word documents, only PDF formats were supported. <br /> For images, only jpg, png, jpeg and gif were allowed. <br/> Please upload based on the guideline.</div>';
                    }

                    // Display status message
                    echo $statusMsg;
                
                    ?>
                    <br />
                    <button class="btn btn-warning" onclick="window.location.href='../student/ewsd_studenthome.php'">Back to Student Homepage</button></div>
</body>
</html>