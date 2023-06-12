<?php
include "auth.php";

// Perform any necessary database queries or data retrieval to fetch the event details
// You can use any method to retrieve the event details here

// Dummy data for demonstration purposes
$event = [
  'id' => 'SampleID123',
  'image' => "default.jpg",
  'name' => 'Sample Event',
  'caption' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
  'date' => '2023-06-15',
  'place' => 'Sample Place',
];

// Dummy data for attendees
$attendees = [
  'John Doe',
  'Jane Smith',
  'Mike Johnson',
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($event) ? $event['name'] : 'Event'; ?></title>
  <!-- Include Bootstrap CSS and any other necessary CSS files -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="header.css">

  <style>
    .event-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
  
    .event-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
        margin-bottom: 10px;
    }
  
    .event-name {
        font-weight: bold;
        margin-bottom: 5px;
    }
  
    .event-caption {
        margin-bottom: 10px;
    }
  
    .event-date {
        font-size: 14px;
        margin-bottom: 5px;
    }
  
    .event-place {
        font-size: 14px;
        color: #888;
    }
  
    .attendees-list {
        margin-top: 20px;
    }
  
  .attendee-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }
  
  .attendee-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
  }
  
  .attendee-name {
    font-weight: bold;
  }
  
</style>
</head>
<body>
  <?php include("header.php"); ?>
  <div class="container mt-4">
    <div class="row">
      <div class="col">
        <?php if (isset($event)): ?>
          <h3><?php echo $event['name']; ?></h3>
          <div class="event-image">
            <img src="<?php echo $event['image']; ?>" alt="Event Image">
          </div>
          <div class="event-caption"><?php echo $event['caption']; ?></div>
          <div class="event-date">Date: <?php echo $event['date']; ?></div>
          <div class="event-place">Place: <?php echo $event['place']; ?></div>
        <?php endif; ?>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col">
        <h4>Attendees:</h4>
        <ul class="attendees-list">
          <?php foreach ($attendees as $attendee): ?>
            <li class="attendee-item"><?php echo $attendee; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col">
        <button class="btn btn-primary">
          <i class="fas fa-share"></i> Share
        </button>
      </div>
    </div>
  </div>

  <!-- Include Bootstrap JS and any other necessary JS files -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
