<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="myScript.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <ul>
        <li><a onclick="goBack()">Back</a></li>
      <li><a onclick="goForward()">Next</a></li>
      <li class="lalign"><a href="logout.php">Log Out</a></li>
    </ul>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2></h2>
                        <h3></h3>
                        <h2 class="pull-left">OurGameList</h2>
                        <a href="create.php" class="btn btn-success pull-right">Add New</a>
                    </div>
                    <?php
                    // Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = 
                    "SELECT games.id,name,dev_id,years,descr,genre,users.username FROM games, users where author_id=users.id";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Developer</th>";
                                        echo "<th>Years</th>";
                                        echo "<th>Descr</th>";
                                        echo "<th>Genre</th>";
                                        echo "<th>Username</th>";
                                        echo "<th>Settings</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['developer'] . "</td>";
                                        echo "<td>" . $row['years'] . "</td>";
                                        echo "<td>" . $row['descr'] . "</td>";
                                        echo "<td>" . $row['genre'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Games' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Games' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Games' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                            echo "<a href='developerdetail.php?id=". $row['id'] ."' title='Developer Detail' data-toggle='tooltip'><span class='glyphicon glyphicon-user'></span></a>";
                                            echo "<a href='authordetail.php?id=". $row['id'] ."' title='Author Detail' data-toggle='tooltip'><span class='glyphicon glyphicon-sunglasses'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No games were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
                    //showing UID
                    echo "your UID is: ".$_SESSION["id"];
                    
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>