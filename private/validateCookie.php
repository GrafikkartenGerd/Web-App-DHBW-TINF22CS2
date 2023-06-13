<?php 
require_once "AuthController.php";

function clearAuthCookie() {
    if (isset($_COOKIE["user"])) {
        setcookie("user", "");
    }
    if (isset($_COOKIE["auth_token"])) {
        setcookie("auth_token", "");
    }
    if (isset($_COOKIE["auth_id"])) {
        setcookie("auth_id", "");
    }
}

$controller = new AuthController();

$current_time = time();
$current_date = date("Y-m-d H:i:s", $current_time);

$cookie_expiration_time = $current_time + $cookie_expiration_delay;

if (!empty($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    return true;
}
else if (!empty($_COOKIE["user"]) && !empty($_COOKIE["auth_token"]) && !empty($_COOKIE["auth_id"])) {
   
    $isPasswordVerified = false;
    $isSelectorVerified = false;
    $isExpiryDateVerified = false;
    
    $userToken = $controller->getTokenByUsername($_COOKIE["user"], 0);
    if($userToken == null || $userToken == false){
        clearAuthCookie();
        return false;
    }

    if (password_verify($_COOKIE["auth_token"], $userToken[0]["password_hash"])) {
        $isPasswordVerified = true;
    }
    
    if (password_verify($_COOKIE["auth_id"], $userToken[0]["selector_hash"])) {
        $isSelectorVerified = true;
    }
    
    if($userToken[0]["expiry_date"] >= $current_date) {
        $isExpiryDateVerified = true;
    }
  
    if (!empty($userToken[0]["id"]) && $isPasswordVerified && $isSelectorVerified && $isExpiryDateVerified) {
        return true;
    } else {
        if(!empty($userToken[0]["id"])) {
            $controller->markTokenAsExpired($userToken[0]["id"]);
        }
        clearAuthCookie();
        return false;
    }
}

return false;
?>