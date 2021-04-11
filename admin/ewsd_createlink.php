

<?php 
	require_once __DIR__ . '/../ewsd_connection.php';
?>

<?php  
 session_start();  
 if($_SESSION['role'] != "Admin") // must be admin 
 {
    header("Location: ../ewsd_login.php");
 } 
 if(isset($_POST["register"]))  
 {   
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['newsubdate'],$_POST['closesubdate'],$_POST['closeeditdate']))
        {
            $newsubdate = filter_var($_POST['newsubdate'],FILTER_SANITIZE_STRING);
            $closesubdate = filter_var($_POST['closesubdate'],FILTER_SANITIZE_STRING);
            $closeeditdate = filter_var($_POST['closeeditdate'],FILTER_SANITIZE_STRING);
            $id = 1;
            $query1 = "SELECT `id`,`submissionDate`,`closeNewSubmissionDate`, `closeEditSubmissionDate`FROM `submissiondate`";
            //$query2 = "UPDATE `submissiondate` SET `submissionDate`= ?,'closeNewSubmissionDate'=?,'closeEditSubmissionDate'=?  WHERE `id` = ?";
            $query3 = "INSERT INTO  submissiondate(`submissionDate`, `closeNewSubmissionDate`, `closeEditSubmissionDate`) VALUES('$newsubdate', '$closesubdate', '$closeeditdate')";  
            if($stmt = mysqli_prepare($conn, $query1)){
			
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    mysqli_stmt_bind_result($stmt, $c1, $c2, $c3,$c4);
                    mysqli_stmt_fetch($stmt);
                    echo '<script>alert("Date for submission link has been created! Please reset if you want to make new changes")</script>';
                    
                }
                else{
                    if (mysqli_query($conn, $query3)) {
                        echo '<script>alert("Succesfully created date for submission link!")</script>';
                     } else {
                        echo '<script>alert("Failed to create date for submission link!")</script>';
                     }
                }
                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);
            }


         }  	
	   
 }  
 
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Registration Page</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
           <meta charset="UTF-8">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
           <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
           <style>
          h5{
             font-weight: bold;
            }
          html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

          #btnRegister{
               background-color: white;
               border: none;
               margin-left:20px;   
          }
          #btnLink{
               background-color: white;
               border: none;
               margin-left:20px;  
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
    
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i><button id="btnRegister" onclick="window.location.href='../admin/ewsd_register.php'">Register</button></a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-calendar-plus-o"></i><button id="btnLink" onclick="window.location.href='../admin/ewsd_createlink.php'">Create link</button></a>
    
  </div>
</nav>


     <!-- Overlay effect when opening sidebar on small screens -->
     <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

     <!-- !PAGE CONTENT! -->
     <div class="w3-main" style="margin-left:300px;margin-top:43px;">

     <!-- Header -->
     <header class="w3-container" style="padding-top:22px">
     <h5><b><i class="fa fa-dashboard"></i> Create Link</b></h5>
     <button id="buttonBack" onclick="window.location.href='../admin/ewsd_admin.php'" class="btn btn-info" style="float:right;">Back</button>
     </header> 
     
           <br /><br />  
           <div class="container" style="width:500px;">  
                <h3 align="left">Create or Make Changes <br> to submission link</h3>  
                <br />  
                <br />  
                <form method="post">  
                     <label>Enter Date for new Submission link:</label> </br>
                     <input type="datetime-local" id="newsubdate" name="newsubdate" required>
                     <br /> 
                     <label>Enter Closure Date for new Submission:</label>  
                     <input type="datetime-local" id="closesubdate" name="closesubdate" required>
                     <br />  
                     <label>Enter Closure Date for edit Submission:</label>  
                     <input type="datetime-local" id="closeeditdate" name="closeeditdate" required>
                    <br /> <br /> 
                     <input type="submit" name="register" value="Register" class="btn btn-primary" />  
                     <br />  
                </form>  
                <br /> 
                <button onclick="window.location.href='../admin/ewsd_deletelink.php'" class="btn btn-warning">Reset all submission dates</button>
                
           </div> 
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