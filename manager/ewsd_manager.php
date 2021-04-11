<?php 
	require_once "ewsd_connection.php"
?>
<?php 
	session_start();
    if($_SESSION['role'] != "Manager")
    {
        header("Location: ../ewsd_login.php");
    }
?>


<!DOCTYPE html>
<html>
<head>
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

    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    }

    tr:nth-child(even) {
    background-color: #dddddd;
    }

    #btnHome{
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
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home"></i><button id="btnHome" onclick="window.location.href='ewsd_manager.php'" >Home</button></a>

    
    
    
  </div>
</nav>


     <!-- Overlay effect when opening sidebar on small screens -->
     <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

     <!-- !PAGE CONTENT! -->
     <div class="w3-main" style="margin-left:300px;margin-top:43px;">

     <!-- Header -->
     <header class="w3-container" style="padding-top:22px">
     <h5><b><i class="fa fa-dashboard"></i> Home</b></h5>
     
     </header> 

    <div class="container">
    <?php 
    $faculty = $_SESSION["faculty"];
     ?> 
    
    <br /> <br />
    <table>
                        <tr>
                        <th>Contributions</th>
                        <th>Student Name</th>
                        <th>Description</th>
                        <th>Faculty</th>
                        </tr>
                        <?php
                    
                            // Get images from the database
                            $query = $db->query("SELECT * FROM submission where approve='true' ORDER BY uploaded_on ASC");
                            if($query->num_rows > 0){
                                while($row = $query->fetch_assoc()){
                                    $imageURL = 'uploads/'.$row["file_name"];
                                    $id = $row["id"];
                                    $_SESSION["id"] = $row["id"];
                                    $f = $row["faculty"];
                                    $n = $row["studentname"];
                                    $d = $row["description"];
                            ?>
                                <tr>
                                    <td hidden><?php echo $id;?>
                                    <td><iframe src="../student/<?php echo $imageURL; ?>" alt="" ></iframe></td>
                                    <td><?php echo $n?></td>
                                    <td><?php echo $d;?></td>
                                    <td><?php echo $f;?></td>
                                </tr>
                            <?php }
                            }else{ ?>
                                <p>No image(s) found...</p>
                            <?php } ?>
                    
                    
                        </table>
                        <br /><br />
                        <button class="btn btn-primary" onclick="window.location.href='../manager/view_graph.php'">View contributions selected from each faculty in graph</button>
                        <br /><br />
                        <button class="btn btn-primary" onclick="window.location.href='../manager/ewsd_downloadzip.php'">Download all approved contributions as zip</button>
                            </body>
                 </html>

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