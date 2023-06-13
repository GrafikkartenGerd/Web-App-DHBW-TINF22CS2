
function populateEventList(events){
 // Populate the event table
 var tableBody = $('#eventsTableBody');
 tableBody.empty(); // Clear previous table content

 events.forEach(function (event) {
     var row = $("<tr>");

     var eventNameCell = $('<td>')
     var eventLink = $('<a>').attr('href', '../Public/event.php?id=' + event.id).text(event.name);
     eventNameCell.append(eventLink);

     eventNameCell.appendTo(row);
     $("<td>").text(event.place).appendTo(row);
     $("<td>").text(event.host).appendTo(row);

     $("<td>").text(event.date).appendTo(row);
     var actionsCell = $('<td>').appendTo(row);

     // Create delete button
     var deleteBtn = $('<button>')
         .addClass('btn btn-danger')
         .text('Delete')
         .click(function() {
         deleteEvent(event.id);
         });

     actionsCell.append(deleteBtn);
     tableBody.append(row);
   });
}

function refreshEventList(){
    $.get("backend.php", { action: "getEventList" }, function (response) {
        if(!response.status) return;
        populateEventList(response.events);
       
    });
}

 // Function to perform user search
 function searchEvents() {
  var searchInput = $('#searchEventInput').val();

  // Send AJAX request to PHP backend with the search query
  $.get('backend.php', { action: 'searchEvent', query: searchInput }, function(response) {
    // Check if the request was successful
    if (response.success) {
      var events = response.events;
      populateEventList(events); // Populate the user table with the search results
    } else {
        showAlert("Couldn't find event!", "danger");
    }
  });
}

function deleteEvent(id) {
    $.get('backend.php', { action: 'deleteEvent', eventId: id }, function(response) {
      if (response.success) {
        showAlert("Event deleted!", "success");
        refreshEventList();
      } else {
        showAlert("Could not delete event: " + response.reason, "danger");
      }
    });
  }

$(document).ready(function () {
    refreshEventList();
  });

  $('#searchEventsButton').click(function() {
    searchEvents();
  });