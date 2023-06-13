<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">
    <img src="logo.png" alt="Logo CampusConnect" class="navbar-icon">
    <link rel="icon" type="image/x-icon" href="/html/favicon.ico">
    <span class="header">CampusConnect</span>
  </a>
  <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="timeline.php">Timeline</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="create.php">Create Event</a>
      </li>
      <?php
        if($_SESSION["is_admin"])
          echo '<li class="nav-item">
                  <a class="nav-link" href="../admin/users.php">Admin Panel</a>
                </li>'
      ?>
    </ul>
  </div>
  <div class="navbar-nav ml-auto pr-2 d-none d-lg-block">
    <a class="nav-link" href="user.php">
      <img src="<?php echo $_SESSION["user"]["profile_picture"];?>" alt="Profile picture" class="rounded-circle" style="width: 55px; padding-left:10px; padding-right:10px">
    </a>
  </div>
    <div class="navbar-nav ml-auto pr-2 d-none d-lg-block">
     <a class="nav-link fa fa-sign-out" href="logout.php" style="font-size:30px; margin-right:10px"></a>
  </div>
</nav>

<script>
  document.querySelector('.navbar-toggler').addEventListener('click', function() {
    document.querySelector('.navbar-collapse').classList.toggle('show');
  });
</script>
