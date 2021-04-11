<?php 
	require_once "ewsd_connection.php"
?>



<!DOCTYPE html>
<html>
<head>
<style>
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
    #containerTable{
    /* margin: ; */
    }
    .center {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    border: 0; 
    }
    button {
    background-color: #53D58B; 
    border: none;
    color: white;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 12px;    
    }
    
    
    </style>


</head>

<body>
    <!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin: 50px 50px;">
    
    <div id="containerTable">
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
                                    <td><iframe src="student/<?php echo $imageURL; ?>" alt="" ></iframe></td>
                                    <td><?php echo $n?></td>
                                    <td><?php echo $d;?></td>
                                    <td><?php echo $f;?></td>
                                </tr>
                            <?php }
                            }else{ ?>
                                <p>No image(s) found...</p>
                            <?php } ?>
                    
                    
                        </table>
                            </div>
                        <br />
                        <br />
            
                <div class="center">
                    <button onclick="window.location.href='ewsd_Login.php'">Back to Login Page</button>
                </div>
            
   
</div>
</body>
</html>