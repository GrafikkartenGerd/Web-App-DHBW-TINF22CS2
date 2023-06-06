<?php

session_start();

if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && isset($_SESSION["user"])){
    
    require_once "../api/AuthController.php";
    $controller = new AuthController();
    $result = $controller->refreshUser($_SESSION["user"]["username"]);

    if($result == null || $result == false){
        session_destroy();
        header("Location: login.php");
        exit;
    }

    $_SESSION["is_admin"] = $result["is_admin"] == 1;
    $_SESSION["user"] = $result;

    return $_SESSION["user"];
} 
else{
    header("Location: login.php");
    exit;
}


?>