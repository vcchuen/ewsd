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

    #btnHome{
               background-color: white;
               border: none;
               margin-left:20px;   
    }

    .containerBtn{
        margin-left:15px;
    }

</style>
<?php
$faculty = $_SESSION["faculty"];
$it = $art = $business = $total = $cit = $pit = $part = $pbusiness =  0;



$query = $db->query("SELECT * FROM submission where approve='true' ORDER BY uploaded_on ASC");
                            if($query->num_rows > 0){
                                while($row = $query->fetch_assoc()){
                                    $f = $row["faculty"];
                                    $total++;
                                    if($f == "IT")
                                    {
                                        $it++;
                                    }
                                    else if($f == "Art")
                                    {
                                        $art++;
                                    }
                                    else if($f == "Business")
                                    {
                                        $business++;
                                    }
                                }
                                echo"
                                <script type='text/javascript'>
                                function f1() {
                                    var chart = new CanvasJS.Chart('chartContainer');
                                
                                    chart.options.axisY = { prefix: '', suffix: ''};
                                    chart.options.title = { text: 'Number of contributions from each faculty in this year' };
                                
                                    var series1 = { //dataSeries - first quarter
                                        type: 'column',
                                        name: 'Contributions',
                                        showInLegend: true
                                    };
                                
                                    chart.options.data = [];
                                    chart.options.data.push(series1);
                                
                                
                                    series1.dataPoints = [
                                            { label: 'IT', y: ".$it.", color: '#51E4EC' },
                                            { label: 'Art', y: ".$art.", color: '#4EE7CA'},
                                            { label: 'Business', y: ".$business.", color: '#4992E7'}
                                    ];
                                
                                    chart.render();
                                }
                                </script>";
    
                                $pit = ($it/$total)*100;
                            $part = ($art/$total)*100;
                            $pbusiness = ($business/$total)*100;
                            echo"<script type='text/javascript'>
                            function f2 () {
                                var chart = new CanvasJS.Chart('chartContainer1');

                                chart.options.axisY = { prefix: '', suffix: '%'};
                                chart.options.title = { text: 'Percentage of contributions from each faculty in this year' };

                                var series1 = { //dataSeries - first quarter
                                    type: 'column',
                                    name: 'Contributions',
                                    showInLegend: true
                                };

                                chart.options.data = [];
                                chart.options.data.push(series1);


                                series1.dataPoints = [
                                        { label: 'IT', y: ".$pit.", color: '#51E4EC' },
                                        { label: 'Art', y: ".$part.", color: '#4EE7CA'},
                                        { label: 'Business', y: ".$pbusiness.", color: '#4992E7'}
                                ];

                                chart.render();
                            }
                            </script>";
                           
                            }
                            else{
                                echo "No contributions has been submitted!";
                            }                                


$xit = 0;
$xart = 0;
$xbusiness =0;
$query = $db->query("SELECT DISTINCT (studentname), faculty FROM submission where approve='true' ORDER BY uploaded_on ASC");
                            if($query->num_rows > 0){
                                while($row = $query->fetch_assoc()){
                                    $f = $row["faculty"];
                                    $total++;
                                    if($f == "IT")
                                    {
                                        $xit++;
                                    }
                                    else if($f == "Art")
                                    {
                                        $xart++;
                                    }
                                    else if($f == "Business")
                                    {
                                        $xbusiness++;
                                    }
                                }
                                echo"<script type='text/javascript'>
function f3 () {
    var chart = new CanvasJS.Chart('chartContainer2');

    chart.options.axisY = { prefix: '', suffix: ''};
    chart.options.title = { text: 'Number of contributors from each faculty in this year' };

    var series1 = { //dataSeries - first quarter
        type: 'column',
        name: 'Contributors',
        showInLegend: true
    };

    chart.options.data = [];
    chart.options.data.push(series1);


    series1.dataPoints = [
            { label: 'IT', y: ".$xit.", color: '#51E4EC' },
            { label: 'Art', y: ".$xart.", color: '#4EE7CA'},
            { label: 'Business', y: ".$xbusiness.", color: '#4992E7'}
    ];

    chart.render();
}
</script>";
                            }
                            else{
                               
                            } 



?>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
    <div class="containerBtn">
    <button class="btn btn-primary" onclick="f1()">Show number of contributions graph</button>
    <button class="btn btn-primary" onclick="f2()">Show percentage of contributions graph</button>
    <button class="btn btn-primary" onclick="f3()">Show number of contributors graph</button>
    <button class="btn btn-warning" onclick="window.location.href='ewsd_manager.php'">Back to manager homepage</button>
    </div>
    <div id="chartContainer" style="height: 300px; width: 100%;">
    </div>
    <br /><br />
    <div id="chartContainer1" style="height: 300px; width: 100%;">
    </div>
    <br /><br />
    <div id="chartContainer2" style="height: 300px; width: 100%;">
    </div>
    <br /><br />
    
</body>
</html>