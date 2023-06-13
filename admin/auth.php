<?php

session_start();

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) {

  require_once "../Private/AuthController.php";
  $controller = new AuthController();
  $result = $controller->refreshUser($_SESSION["user"]["username"]);


   if($result == null || $result == false){
        session_destroy();
        header("Location: login.php");
        exit;
    }

    $_SESSION["is_admin"] = $result["is_admin"] == 1;
    $_SESSION["user"] = $result;

}

if($_SESSION["is_admin"] !== true){
  session_destroy();
  header("Location: ../Public/login.php");
  exit;
}
?>