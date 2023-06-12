<?php

include "auth.php"

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
  include "header.php";
?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="profile-box">
        <div class="profile-pic-container">
          <img src="default.jpg" alt="Profile Picture">
          <button class="upload-btn">Upload Profile Picture</button>
        </div>
        <div class="profile-info">
          <form>
          <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username">
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name">
            </div>
            <div class="mb-3">
              <label for="surname" class="form-label">Surname</label>
              <input type="text" class="form-control" id="surname">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">Birthday</label>
              <input type="date" class="form-control" id="birthday">
            </div>
            <div class="mb-3">
              <label for="course" class="form-label">Course</label>
              <input type="text" class="form-control" id="course">
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
    <form>
      <div class="mb-3">
        <label for="current-password" class="form-label">Current Password</label>
        <input type="password" class="form-control" id="current-password">
      </div>
      <div class="mb-3">
        <label for="new-password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new-password">
      </div>
      <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="confirm-password">
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    <div class="forgot-password">
      Forgot Password? Write an Email to: admin@campusconnect.de
    </div>
  </div>
</div>

<?php
  include("footer.php")
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
