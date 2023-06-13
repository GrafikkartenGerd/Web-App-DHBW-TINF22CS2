<?php
include "auth.php";

$auth = new AuthController();
$_SESSION["user"] = $auth->refreshUser($_SESSION["user"]["username"]);

$action = $_GET['do'] ?? null;

if($action !== null){

  require_once "../Private/UserController.php";

  $controller = new UserController();

  if($action == "profile"){

    $name = $_POST['name'] ?? null;
    $surname = $_POST['surname'] ?? null;
    $bio = $_POST['bio'] ?? null;

    if($name != null && $surname != null && $bio != null){
      $controller->updateProfileInfo($_SESSION["user"]["id"], $name, $surname, $bio);
    }else{
      $errorMessage = "Missing parameters.";
    }
  }
  else if($action == "pic"){

    $result = $controller->changeProfilePicture($_SESSION["user"]["id"]);
    
    if($result === false)
      $errorMessage = "Internal server error.";
    else if($result !== true)
        $errorMessage = $result;

  }else if($action == "pass"){
    $oldPassword = $_POST['current-password'] ?? null;
    $newPassword = $_POST['password'] ?? null;
    $passwordConfirm = $_POST['confirm-password'] ?? null;

    if($oldPassword != null && $newPassword != null && $passwordConfirm != null){
      if(strlen($newPassword) < PASSWORD_LENGTH){
        $errorMessage = "Password should be at least ".PASSWORD_LENGTH." characters long.";
      

      }else if($newPassword != $passwordConfirm){
        $errorMessage = "New password did not match confirmation password.";

      }else{
        
        $controller= new AuthController();
        $result = $controller->changePassword($_SESSION["user"], $oldPassword, $newPassword);

        if($result === false)
          $errorMessage = "Internal server error.";
        else if($result !== true)
          $errorMessage = $result;
      }
    }
  }

  $auth = new AuthController();
  $_SESSION["user"] = $auth->refreshUser($_SESSION["user"]["username"]);
}
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <style>
    
    .profile-box {
      background-color: #f1f1f1;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
      margin-bottom: 20px;
    }
    
    .profile-pic-container {
      position: relative;
      width: 200px;
      height: 200px;
      margin: 0 auto;
      overflow: hidden;
      border-radius: 50%;
    }
    
    .profile-pic-container img {
      width: 100%;
      height: auto;
    }
    
    .upload-btn {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      padding: 10px 20px;
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      text-align: center;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
      border: none;
      border-radius: 5px;
    }
    
    .upload-btn:hover {
      opacity: 1;
    }
    
    .profile-info {
      margin-top: 20px;
    }
    
    .password-change-button {
      display: block;
      margin-top: 20px;
      text-align: center;
    }
    
    .password-change-window {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    
    .password-change-window-inner {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      text-align: center;
    }
    
    .password-change-window-close {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      color: white;
    }

    
    
    .forgot-password {
      display: block;
      margin-top: 10px;
      text-align: center;
      color: #999;
    }
    
    
    @media (min-width: 768px) {
      .password-change-window-close2 {
        display: none;

      }
    }

    @media (max-width: 767px) {
      .password-change-window {
        position: static;
        width: 100%;
        height: auto;
        background-color: transparent;
        display: block;
        padding-top: 20px;
        display: none;
      }
      
      .password-change-window-inner {
        border-radius: 0;
      }

      .password-change-window-close {
       display:none;
      }

      .password-change-window-close2 {
        text-decoration: underline;
        font-size:20px;
        position: relative;
        top: 80%;
        right: 90%;
        cursor: pointer;
        color: black;
      }

        .footer {
        background-color: #333;
        color: white;
        padding: 10px;
        text-align: center;
      }
    }
    .card {
      margin-bottom: 20px;
    }

  </style>
</head>
<body>

<?php
  include "../Private/header.php";
?>

<main>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="profile-box">
          <div id="alertContainer">
            <?php
                if(isset($errorMessage))
                    echo '<div role="alert" class="alert alert-danger">'.$errorMessage.'</div>';
            ?>
          </div>
          <div class="profile-pic-container">
            <img src="<?php echo $_SESSION["user"]["profile_picture"]; ?>" alt="Profile Picture" onclick="document.getElementById('profile_picture').click();">
            <form action="profile.php?do=pic" method="post" enctype="multipart/form-data">
              <input type="file" name="profile_picture" id="profile_picture" accept="image/*" style="display: none;" onchange="this.form.submit()">
            </form>
          </div>
          <div class="profile-info">
            <form method="POST" action="profile.php?do=profile">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" readonly value="<?php echo $_SESSION["user"]["username"]?>">
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo $_SESSION["user"]["name"]?>">
            </div>
            <div class="mb-3">
              <label for="surname" class="form-label">Surname</label>
              <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $_SESSION["user"]["surname"]?>">
            </div>
            <div class="mb-3">
              <label for="bio" class="form-label">Bio</label>
              <input type="bio" class="form-control" id="bio" name="bio" value="<?php echo $_SESSION["user"]["bio"]?>">
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">Birthday</label>
              <input type="date" class="form-control" id="birthday" value="<?php echo $_SESSION["user"]["birthday"]?>" readonly>
            </div>
            <div class="mb-3">
              <label for="course" class="form-label">Course</label>
              <input type="text" class="form-control" id="course" value="<?php echo $_SESSION["user"]["course"]?>" readonly>
            </div>
            <div class="password-change-button">
              <button class="btn btn-primary" onclick="return openPasswordChangeWindow()">Change Password</button>
              <button class="btn btn-primary">Save</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="password-change-window">
  <div class="password-change-window-inner">
    <div class="password-change-window-close" onclick="closePasswordChangeWindow()">X</div>
    <div class="password-change-window-close2" onclick="closePasswordChangeWindow()">close</div>
    <h2>Change Password</h2>
    <form action="profile.php?do=pass" method="POST">
      <div class="mb-3">
        <label for="current-password" class="form-label">Current Password</label>
        <input type="password" class="form-control" name="current-password" id="current-password">
      </div>
      <div class="mb-3">
        <label for="new-password" class="form-label">New Password</label>
        <input type="password" class="form-control" name="password" id="new-password">
      </div>
      <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" name="confirm-password" id="confirm-password">
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <div class="forgot-password">
      <div class="text-center email-link">Forgot Password? <a href="mailto:support@campusconnect.de">Send an Email</a></div>
    </div>
  </div>
</div>
</main>

<?php
  include "../Private/footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function openPasswordChangeWindow() {
    const passwordChangeWindow = document.querySelector('.password-change-window');
    passwordChangeWindow.style.display = 'flex';
    return false;
  }
  
  function closePasswordChangeWindow() {
    const passwordChangeWindow = document.querySelector('.password-change-window');
    passwordChangeWindow.style.display = 'none';

  }
</script>

</body>
</html>
