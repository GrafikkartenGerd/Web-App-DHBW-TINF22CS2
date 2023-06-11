<?php

include "auth.php"

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Management System</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .card {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<?php
  include "header.php";
?>


<div id="alertContainer"></div>

<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Create Event</h5>
      <form>
        <div class="mb-3">
          <label for="eventName" class="form-label">Event Name</label>
          <input type="text" class="form-control" id="eventName" placeholder="Enter event name" required>
        </div>
        <div class="mb-3">
          <label for="eventDate" class="form-label">Event Date</label>
          <input type="datetime-local" class="form-control" id="eventDate" required>
        </div>
        <div class="mb-3">
          <label for="eventPlace" class="form-label">Event Place</label>
          <input type="text" class="form-control" id="eventPlace" placeholder="Enter event place" required>
        </div>
        <div class="mb-3">
          <label for="eventContent" class="form-label">Event Content</label>
          <textarea class="form-control" id="eventContent" rows="3" placeholder="Enter event content" required></textarea>
        </div>
        <div class="mb-3">
          <input type="hidden" class="form-control" id="eventHost" placeholder="Enter event host" required>
        </div>
        <div class="mb-3">
          <label for="eventPoster" class="form-label">Event Poster</label>
          <input type="file" class="form-control" id="eventPoster" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
    </div>
  </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

