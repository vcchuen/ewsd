

<?php 
	require_once __DIR__ . '/../ewsd_connection.php';
?>
<?php //send email to user
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require '../vendor/autoload.php';

	define ("MYGMAIL", "voon.chuen@gmail.com");
	define ("MYAPPPASS", "hovyoeqwgduelezl");

	function sendEmail($newemail,$randPass){
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
			
			$content = "<h2>Your new email is <mark>$newemail</mark></h2><br /><h2>Your new password is <mark>$randPass</mark></h2><br />";
			
			$mail->IsHTML(true);
			$mail->WordWrap = 50;
			$mail->Subject = "New Account for Blackboard";
			$mail->Body = $content;
			
			if($mail->Send()){
				echo "<script>alert('Email has been send.');</script>";
			}
		}
		catch(Exception $ex){
			echo "<script>alert('Email could not be sent.')</script>";
			echo "<p>Mailer Error: " . $mail->ErrorInfo . "</p>";
		}
	}
?>
<?php  
 session_start();  
 if($_SESSION['role'] != "Admin") // must be admin 
 {
    header("Location: ../ewsd_login.php");
 } 

 if(isset($_POST["register"]))  
 {  
      if(empty($_POST["email"]) || empty($_POST["uname"]) || empty($_POST["password"])|| empty($_POST["role"]) || empty($_POST["faculty"]))  
      {  
           echo '<script>alert("Both Fields are required")</script>';  
      }  
      else  
      {  
        if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['email'],$_POST['uname'],$_POST['password'],$_POST['role'],$_POST['faculty']))
        {
            $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            $name = filter_var($_POST['uname'],FILTER_SANITIZE_STRING);
            $role = filter_var($_POST['role'],FILTER_SANITIZE_STRING);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $faculty = filter_var($_POST['faculty'],FILTER_SANITIZE_STRING);
            $query = "INSERT INTO  account(email, password, name, role, faculty) VALUES('$email', '$hashed_password', '$name', '$role', '$faculty')";  
            
            if (mysqli_query($conn, $query)) {
                echo '<script>alert("Registration Done")</script>';
                sendEmail($email,$password);
             } else {
                echo '<script>alert("Registration Unsuccessful")</script>';
             }
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
          #buttonBack {
               background-color:#5AD0F5;
               border: none;
               color: black;
               padding: 10px 40px;
               text-align: center;
               text-decoration: none;
               display: inline-block;
               font-size: 16px;
               margin: 4px 2px;
               cursor: pointer;
               border-radius: 10px;
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
     <h5><b><i class="fa fa-dashboard"></i> Register</b></h5>
     <button id="buttonBack" onclick="window.location.href='../admin/ewsd_admin.php'" style="float:right;">Back</button>
     </header> 
     
     </br>
     </br>
           <div class="container" style="width:500px;">  
                <h3 align="center">Registration For New Account</h3>  
                <br />  
                <br />  
                <form method="post">  
                     <label>Enter Email:</label>  
                     <input type="text" name="email" class="form-control" required/>  
                     <br />  
                     <label>Enter Name:</label>  
                     <input type="text" name="uname" class="form-control" required/>  
                     <br /> 
                     <label>Enter Password:</label>  
                     <input type="text" name="password" class="form-control" required/>  
                     <br /> 
                     <select name="role" id="role" required>
                        <option value="Admin">Admin</option>
                        <option value="Student">Student</option>
                        <option value="Coordinator">Coordinator</option>
                        <option value="Manager">Manager</option>
                        <option value="Guest">Guest</option>
                    </select>
                    <br /><br />
                    <select name="faculty" id="faculty" required>
                        <option value="None">None</option>
                        <option value="IT">IT</option>
                        <option value="Art">Art</option>
                        <option value="Business">Business</option>
                    </select>
                    <br /> <br /> 
                     <input type="submit" name="register" value="Register" class="btn btn-info" />  
                     <br />  
                </form>  
                <br /> <br /> 
               
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