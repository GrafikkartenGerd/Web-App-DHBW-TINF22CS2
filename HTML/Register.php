<?php

session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
    header('Location: index.php');
    exit;
}

$cookie_login = require_once("validateCookie.php");

if($cookie_login){
    require_once "../api/AuthController.php";

    $username = $_COOKIE["user"];
    $controller = new AuthController();
    $result = $controller->refreshUser($username);

    $_SESSION["logged_in"] = true;
    $_SESSION["is_admin"] = $result["is_admin"] == 1;
    $_SESSION["user"] = $result;

    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once "../api/AuthController.php";

    $username = $_POST['username'] ?? null;
    $name = $_POST['name'] ?? null;
    $surname = $_POST['surname'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $password = $_POST['password'] ?? null;
    $confirmPassword = $_POST['confirm-password'] ?? null;
    $matricNum = $_POST['matricnum'] ?? null;
    $course = $_POST['course'] ?? null;
    $birthday = $_POST['birthday'] ?? null;

    if ($username !== null && $name !== null && $surname !== null && $password !== null && $confirmPassword !== null && $matricNum !== null && $course !== null && $gender !== null
        && $birthday !== null && !empty($birthday)) {

        $isValid = true;

        if(strlen($username) > 30){
            $isValid = false;
            $errorMessage = "Username can't be longer than 30 characters.";
        }


        if (strlen($password) < 8) {
            $isValid = false;
            $errorMessage = "Password should be at least 8 characters long.";
        }

        $dateParts = explode('-', $birthday);
        if (!(count($dateParts) === 3 && checkdate($dateParts[1], $dateParts[2], $dateParts[0]))) {
            $isValid = false;
            $errorMessage = "Invalid date format.";

        }
    
        if ($password !== $confirmPassword) {
            $isValid = false;
            $errorMessage = "Passwords do not match.";
        }

        $gender = $gender == "Male" ? "m" : "f";

        if ($isValid) {

            $controller = new AuthController();
            $result = $controller->register($username, $password, $name, $surname, new DateTime($birthday), $gender, $matricNum, "", "", $course);

            if($result === false)
                $errorMessage = "Internal server error.";
            else if($result !== true)
                $errorMessage = $result;
            else
                header("Location: login.php");
            
            exit();
        }
    } else {
        $errorMessage = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>CampusConnect - Register</title>
    <meta name="description" content="Register">
    <link rel="stylesheet" type="text/css" href="swipecss.css" media="screen">  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="footer.css">
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;
            overflow: scroll;
        }

        .register-container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .register-form {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            border-radius: 5px;
            padding: 12px;
            border: 1px solid #ced4da;
            font-size: 16px;
            width: 100%;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #80bdff;
        }

        .form-group .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .form-group .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .form-group .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .form-group .login-link a {
            color: #343a40;
            text-decoration: none;
            transition: all 0.3s;
        }

        .form-group .login-link a:hover {
            color: #212529;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: left;
        }

        .header img {
            height: 60px;
            width: 60px;
            margin-right: 10px;
        }

        .header span {
            margin-top: 20px;
            font-size: 30px;
            font-weight: bold;
        }

       

        .logo-text {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header class="header">
        <img src="logo.png" alt="Logo">
        <span class="logo-text">CampusConnect</span>
    </header>
    <main>
        <div class="container register-container">
            <div id="alertContainer">
                    <?php
                        if(isset($errorMessage))
                            echo '<div role="alert" class="alert alert-danger">'.$errorMessage.'</div>';
                    ?>
                </div>
            <h2 class="text-center mb-4">Register</h2>
            <form class="register-form" method="post" action="register.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter surname" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <br>
                    <select name="gender" class="form-control" value="Male">
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" class="form-control" name="birthday" id="birthday">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm password" required>
                </div>
                <div class="form-group">
                    <label for="matricnum">Matriculation Number</label>
                    <input type="number" class="form-control" id="matricnum" name="matricnum" placeholder="Enter Matriculation Number" required>
                </div>
                <div class="form-group">
                    <label for="course">Course</label>
                    <input type="text" class="form-control" id="course" name="course" placeholder="Enter course" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <p class="text-center login-link">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>

        <script>
            $('.gender').click(function() {
                $(this).find('.btn').toggleClass('active');  
                if ($(this).find('.btn-primary').length>0) {
                    $(this).find('.btn').toggleClass('btn-primary');
                }
                $(this).find('.btn').toggleClass('btn-default');
            });
        </script>
    </main>
    <?php
        include("footer.php")
    ?>
</body>
</html>