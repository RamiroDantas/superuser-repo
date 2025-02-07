<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT atendente_id, atendente_name, atendente_email, password FROM atendente_users WHERE atendente_email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if email exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    // Fetch result
                    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $row["atendente_id"];
                        $fullname = $row["atendente_name"];
                        $hashed_password = $row["password"];

                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["role"] = $role;
                            $_SESSION["fullname"] = $fullname;
                            $_SESSION["email"] = $email;

                            // Redirect user to welcome page
                            header("location: register.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    // Email doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Login </title>
    <!-- plugins:css -->
    <?php include 'partials/headtags.php'; ?>

    <style>
        body {
            background-color: #f3f3f4;
        }

        .img-size {
            width: 120px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <img src="./images/Controll10.png" class="img-circle img-size" />
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                        method="post">
                        <?php
                        if (!empty($login_err)) {
                            echo '<div class="alert alert-danger">' . $login_err . '</div>';
                        }

                        ?>
                        <div class="form-group">
                            <input type="text" name="email"
                                class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $email; ?>" placeholder="Email">
                            <span class="invalid-feedback">
                                <?php echo $email_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password"
                                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                                placeholder="Password">
                            <span class="invalid-feedback">
                                <?php echo $password_err; ?>
                            </span>
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                        <a href="#">
                            <small>Esqueceu a senha?</small>
                        </a>

                    </form>
                    <p class="m-t">
                        <small>Controlle 10 &copy; 2014</small>
                    </p>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Controlle 10
            </div>
            <div class="col-md-6 text-right">
                <small>© 2014-2015</small>
            </div>
        </div>
    </div>
    <!-- container-scroller -->
    <?php include 'partials/javascripts.php'; ?>

</body>

</html>