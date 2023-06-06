<?php
session_start();

session_destroy();

 if (isset($_COOKIE["user"])) {
    setcookie("user", "");
}
if (isset($_COOKIE["auth_token"])) {
    setcookie("auth_token", "");
}
if (isset($_COOKIE["auth_id"])) {
    setcookie("auth_id", "");
}

header("Location: login.php");
?>