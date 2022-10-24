<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $developer = $years = $descr = $genre = "";
$name_err = $developer_err = $years_err = $genre_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } else{
        $name = $input_name;
    }

    // Validate developer
    $input_developer = trim($_POST["developer"]);
    if(empty($input_developer)){
        $developer_err = "Please enter the developer company name.";
    } else{
        $developer = $input_developer;
    }

    // Validate years
    $input_years = trim($_POST["years"]);
    if(empty($input_years)){
        $years_err = "Please enter the years this game released public.";
    } elseif(!ctype_digit($input_years)){
        $years_err = "Please enter a positive integer value.";
    } else{
        $years = $input_years;
    }

    // Validate descr
    $input_descr = trim($_POST["descr"]);
    $descr = $input_descr;

    // Validate genre
    $input_genre = trim($_POST["genre"]);
    if(empty($input_genre)){
        $years_err = "Please enter the genre.";
    } else{
        $genre = $input_genre;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($developer_err) && empty($years_err) && empty($genre_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO games (name, developer, years, descr, genre) VALUES (?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_developer, $param_years, $param_descr, $param_genre);

            // Set parameters
            $param_name = $name;
            $param_developer = $developer;
            $param_years = $years;
            $param_descr = $descr;
            $param_genre = $genre;

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
    <title>OurGameList</title>
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
                        <h2>Add Games</h2>
                    </div>
                    <p>Please fill this form to add data to the database</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($developer_err)) ? 'has-error' : ''; ?>">
                            <label>Developer</label>
                            <textarea name="developer" class="form-control"><?php echo $developer; ?></textarea>
                            <span class="help-block"><?php echo $developer_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($years_err)) ? 'has-error' : ''; ?>">
                            <label>years</label>
                            <input type="text" name="years" class="form-control" value="<?php echo $years; ?>">
                            <span class="help-block"><?php echo $years_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>descr</label>
                            <input type="text" name="descr" class="form-control" value="<?php echo $descr; ?>">
                        </div>
                        <div class="form-group <?php echo (!empty($genre_err)) ? 'has-error' : ''; ?>">
                            <label>genre</label>
                            <input type="text" name="genre" class="form-control" value="<?php echo $genre; ?>">
                            <span class="help-block"><?php echo $genre_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>author</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
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