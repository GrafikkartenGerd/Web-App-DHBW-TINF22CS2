<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Connect</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Include custom CSS -->
  <style>
    .card {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><i class="fas fa-university"></i> Campus Connect</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Announcements</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <img src="profile_picture.jpg" alt="Profile Picture" class="rounded-circle" style="width: 30px;">
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container mt-4">
    <!-- Newest Event Card -->
    <div class="card" id="eventCard">
      <div class="card-body">
        <h5 class="card-title">Event Name</h5>
        <p class="card-text">Event description goes here...</p>
        <div class="d-flex align-items-center">
          <img src="user_profile_picture.jpg" alt="User Profile Picture" class="rounded-circle" style="width: 20px;">
          <p class="mb-0 ml-2">Event Creator</p>
        </div>
        <div class="d-flex align-items-center mt-2">
          <i class="far fa-calendar-alt"></i>
          <p class="mb-0 ml-2">Event Date and Time</p>
        </div>
        <div class="d-flex align-items-center">
          <i class="fas fa-map-marker-alt"></i>
          <p class="mb-0 ml-2">Event Location</p>
        </div>
      </div>
    </div>

    <!-- Add more event cards here -->
  </div>

  <!-- Include Bootstrap JS and Font Awesome JS -->
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
    var eventCard = document.getElementById('eventCard');
    var touchStartX = 0;

    eventCard.addEventListener('touchstart', handleTouchStart, false);
    eventCard.addEventListener('touchmove', handleTouchMove, false);
    function handleTouchStart(event) {
      touchStartX = event.touches[0].clientX;
    }

    function handleTouchMove(event) {
      if (!touchStartX) {
        return;
      }

      var touchCurrentX = event.touches[0].clientX;
      var touchDiffX = touchStartX - touchCurrentX;

      if (touchDiffX > 0) {
        // Swipe left
        // Call your JavaScript function for swipe left action
        console.log("Swiped left");
      } else if (touchDiffX < 0) {
        // Swipe right
        // Call your JavaScript function for swipe right action
        console.log("Swiped right");
      }

      touchStartX = null;
    }
  </script>
</body>
</html>
