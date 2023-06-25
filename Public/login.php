<?php

session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true){
    header('Location: index.php');
    exit;
}

$cookie_login = require_once("../private/validateCookie.php");

if($cookie_login){
    require_once "../private/AuthController.php";

    $username = $_COOKIE["user"];
    $controller = new AuthController();
    $result = $controller->refreshUser($username);

    $_SESSION["logged_in"] = true;
    $_SESSION["is_admin"] = $result["is_admin"] == 1;
    $_SESSION["is_super_admin"] = $result["is_super_admin"] == 1;
    $_SESSION["user"] = $result;

    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"]) && isset($_POST["password"])) {
  
    require_once "../private/AuthController.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    $controller = new AuthController();
    $result = $controller->login($username, $password);

    if($result == false){
         $errorMessage = 'Invalid username or password.';
    }else if($result == null){
        $errorMessage = 'Internal server error.';
    }
    else{
        $_SESSION["logged_in"] = true;
        $_SESSION["is_admin"] = $result["is_admin"] == 1;
        $_SESSION["is_super_admin"] = $result["is_super_admin"] == 1;
        $_SESSION["user"] = $result;

        if (!empty($_POST["remember"]) && $_POST["remember"] == "on") {
            setcookie("user", $username, $cookie_expiration_time);
            
            $auth_token = bin2hex(random_bytes(16));
            setcookie("auth_token", $auth_token, $cookie_expiration_time);
            
            $auth_id = bin2hex(random_bytes(32));
            setcookie("auth_id", $auth_id, $cookie_expiration_time);
            
            $auth_token_hash = password_hash($auth_token, PASSWORD_DEFAULT);
            $auth_id_hash = password_hash($auth_id, PASSWORD_DEFAULT);
            
            $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
            
            $userToken = $controller->getTokenByUsername($username, 0);
            if (!empty($userToken[0]["id"])) {
                $controller->markTokenAsExpired($userToken[0]["id"]);
            }
            $controller->insertToken($username, $auth_token_hash, $auth_id_hash, $expiry_date);
        } else {
            clearAuthCookie();
        }

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>CampusConnect</title>
    <meta name="description" content="CampusConnect Login">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="footer.css">
    <script src="util.js"></script>

</head>
<body>
    <header class="header">
        <img src="logo.png" alt="Logo CampusConnect">
        <span>CampusConnect</span>
    </header>
    <main>
        <div class="container login-container">
            <div id="alertContainer">
                <?php
                    if(isset($errorMessage))
                        echo '<div role="alert" class="alert alert-danger">'.$errorMessage.'</div>';
                ?>
            </div>
            <h2 class="text-center mb-4">Login</h2>
            <form class="login-form" method="post" action="login.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="username" class="form-control" id="username" name="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <div><p class="text-center register-link">Don't have an account? <a href="register.php">Register</a>
                    <div class="text-center email-link">Forgot Password? <a href="mailto:support@campusconnect.de">Send an Email</a></div></p>
                </div>
            </form>
        </div>
    </main>
<?php
    include("../private/footer.php");
?>
</body>
</html>