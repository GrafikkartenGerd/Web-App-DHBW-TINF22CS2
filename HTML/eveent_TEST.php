<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Timeline</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
  <!-- Include custom CSS -->
  <style>
    .navbar-icon {
      width: 55px;
    }

    .event-timeline {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .event-box {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 20px;
      width: 80%;
      margin-left: auto;
      margin-right: auto;
    }

    .event-box img {
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

    .card {
      margin-bottom: 20px;
    }

    .navbar-icon {
    width: 55px; 
    }
    </style>
</head>
<body>




<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
    <img src="logo.png" alt="Logo CampusConnect" class="navbar-icon">
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

<div class="container mt-4">
  <div class="row event-timeline">
    <div class="col">
      <h3>Event Timeline</h3>
      <div class="dropdown mb-3">
        <button class="btn btn-primary dropdown-toggle" type="button" id="scopeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          Select Scope
        </button>
        <ul class="dropdown-menu" aria-labelledby="scopeDropdown">
          <li><a class="dropdown-item" href="#" onclick="changeScope('upcoming')">Upcoming</a></li>
          <li><a class="dropdown-item" href="#" onclick="changeScope('today')">Today</a></li>
          <li><a class="dropdown-item" href="#" onclick="changeScope('past')">Past</a></li>
          <li><a class="dropdown-item" href="#" onclick="changeScope('liked')">Liked</a></li>
          <li><a class="dropdown-item" href="#" onclick="changeScope('disliked')">Disliked</a></li>
        </ul>
      </div>
      <div id="eventTimeline"></div>
    </div>
  </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  var exampleEvents = [
    {
      name: "Event 1",
      caption: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
      image: "default.jpg",
      date: "2023-06-10",
      place: "Location 1"
    },
    {
      name: "Event 2",
      caption: "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
      image: "default.jpg",
      date: "2023-06-15",
      place: "Location 2"
    },
    {
      name: "Event 3",
      caption: "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
      image: "event_image3.jpg",
      date: "2023-06-20",
      place: "Location 3"
    },
    {
      name: "Event 4",
      caption: "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
      image: "event_image4.jpg",
      date: "2023-06-25",
      place: "Location 4"
    },
    {
      name: "Event 5",
      caption: "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
      image: "event_image5.jpg",
      date: "2023-06-30",
      place: "Location 5"
    }
  ];

  function displayEvents(events) {
    var eventTimeline = document.getElementById('eventTimeline');
    eventTimeline.innerHTML = '';

    events.forEach(function(event) {
      var eventBox = document.createElement('div');
      eventBox.className = 'event-box';
      eventBox.innerHTML = `
        <img src="${event.image}" alt="Event Image">
        <div class="event-info">
          <div class="event-name">${event.name}</div>
          <div class="event-caption">${event.caption}</div>
          <div class="event-date">Date: ${event.date}</div>
          <div class="event-place">Place: ${event.place}</div>
          <div class="event-share">
            <button class="btn btn-primary" onclick="shareEvent('${event.name}', '${event.caption}')">
              <i class="fas fa-share"></i> Share
            </button>
          </div>
        </div>
      `;

      eventTimeline.appendChild(eventBox);
    });
  }

  function changeScope(scope) {
    var filteredEvents = [];

    switch (scope) {
      case 'upcoming':
        filteredEvents = exampleEvents.filter(function(event) {
          var eventDate = new Date(event.date);
          var currentDate = new Date();
          return eventDate > currentDate;
        });
        break;
      case 'today':
        filteredEvents = exampleEvents.filter(function(event) {
          var eventDate = new Date(event.date);
          var currentDate = new Date();
          return eventDate.toDateString() === currentDate.toDateString();
        });
        break;
      case 'past':
        filteredEvents = exampleEvents.filter(function(event) {
          var eventDate = new Date(event.date);
          var currentDate = new Date();
          return eventDate < currentDate;
        });
        break;
      case 'liked':
        // Placeholder for liked events filtering
        break;
      case 'disliked':
        // Placeholder for disliked events filtering
        break;
      default:
        filteredEvents = exampleEvents;
    }

    displayEvents(filteredEvents);
  }

  // Initial display
  changeScope('upcoming');
</script>
</body>
</html>

