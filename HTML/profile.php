<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <style>
    .header {
      background-color: #333;
      color: white;
      padding: 10px;
      text-align: center;
    }
    
    .header h1 {
      margin: 0;
      font-size: 24px;
    }
    
    .profile-box {
      background-color: #f1f1f1;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
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
    
    .footer {
      background-color: #333;
      color: white;
      padding: 10px;
      text-align: center;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
    }
    
    @media (max-width: 767px) {
      .password-change-window {
        position: static;
        width: 100%;
        height: auto;
        background-color: transparent;
        display: block;
        padding-top: 20px;
      }
      
      .password-change-window-inner {
        border-radius: 0;
      }
    }
  </style>
</head>
<body>
style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
    <img src="logo.png" alt="Campus Connect Icon" class="navbar-icon">
    Campus Connect
  </a>
  <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Announcements</a>
      </li>
    </ul>
  </div>
  <div class="navbar-nav ml-auto pr-2 d-none d-lg-block">
    <a class="nav-link" href="#">
      <img src="profile_picture.jpg" alt="Profile Picture" class="rounded-circle" style="width: 55px; padding-left:10px; padding-right:10px">
    </a>
  </div>
</nav>

<style>
  @media (max-width: 991.98px) {
    .navbar-toggler {
      margin-left: auto !important;
      margin-right: 0.5rem !important;
    }
    .navbar-nav.ml-auto:not(.collapse) {
      display: flex !important;
    }
    .navbar:not(.navbar-expand-lg) {
      padding-right: 1rem;
    }
    .navbar-collapse {
      padding-left: 1rem;
    }
  }
</style>

<script>
  document.querySelector('.navbar-toggler').addEventListener('click', function() {
    document.querySelector('.navbar-collapse').classList.toggle('show');
  });
</script>


















<header class="header">
  <div class="container">
    <h1>Profile Page</h1>
  </div>
</header>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="profile-box">
        <div class="profile-pic-container">
          <img src="profile_picture.jpg" alt="Profile Picture">
          <button class="upload-btn">Upload Profile Picture</button>
        </div>
        <div class="profile-info">
          <form>
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
            <div class="password-change-button">
              <button class="btn btn-primary" onclick="openPasswordChangeWindow()">Change Password</button>
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
      <a href="forgot_password.html">Forgot Password?</a>
    </div>
  </div>
</div>

<footer class="footer">
  <div class="container">
    &copy; 2023 Profile Page. All rights reserved.
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function openPasswordChangeWindow() {
    const passwordChangeWindow = document.querySelector('.password-change-window');
    passwordChangeWindow.style.display = 'flex';
  }
  
  function closePasswordChangeWindow() {
    const passwordChangeWindow = document.querySelector('.password-change-window');
    passwordChangeWindow.style.display = 'none';
  }
</script>
</body>
</html>
