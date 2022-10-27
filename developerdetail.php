<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$developer_id = $devdescription = "";
$developer_id_err = $devdescription_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate developer id
    $input_developer_id = trim($_POST["developer_id"]);
    if(empty($input_developer_id)){
        $developer_id_err = "Please enter the Developer's ID.";
    }else if(1){
       $developer_id = $input_developer_id;
    }

    // Validate developer description
    $input_devdescription = trim($_POST["devdescription"]);
    if(empty($input_devdescription)){
        $devdescription_err = "Please enter the developer description.";
    } else{
        $devdescription = $input_devdescription;
    }
    

    // Check input errors before inserting in database
    if(empty($developer_id_err) && empty($devdescription_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO developerdetail (developer_id, devdescription) VALUES (?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssissi", $param_developer_id, $param_devdescription);

            // Set parameters
            $param_developer_id = $developer_id;
            $param_devdescription = $devdescription;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>devdescriptionlist</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="myScript.js"></script>
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <ul>
      <li><a onclick="goBack()">Back</a></li>
      <li><a onclick="goForward()">Next</a></li>
      <!-- <li class="lalign"><a href="login.php">Login</a></li> -->
      <li class="lalign"><a href="logout.php">Log Out</a></li>
    </ul>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add Developer Detail</h2>
                    </div>
                    <p>Please fill this text box to add Developer detail to the database</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($developer_id_err)) ? 'has-error' : ''; ?>">
                            <label>Developer ID</label>
                            <input type="text" name="developer_id" class="form-control" value="<?php echo $developer_id; ?>">
                            <span class="help-block"><?php echo $developer_id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($devdescription_err)) ? 'has-error' : ''; ?>">
                            <label>Developer Description</label>
                            <textarea name="developer description" class="form-control"><?php echo $devdescription; ?></textarea>
                            <span class="help-block"><?php echo $devdescription_err;?></span>
                        </div>
        
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>