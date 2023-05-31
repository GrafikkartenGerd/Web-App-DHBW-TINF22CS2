
function refreshEventList(){
    $.get("backend.php", { action: "getEventList" }, function (response) {
        if(!response.status) return;
        var eventList = response.events;

        // Populate the event table
        var tableBody = $('#eventsTableBody');
        tableBody.empty(); // Clear previous table content

        eventList.forEach(function (event) {
            var row = $("<tr>");
            $("<td>").text(event.name).appendTo(row);
            $("<td>").text(event.place).appendTo(row);
            $("<td>").text(event.host).appendTo(row);

            $("<td>").text(event.date).appendTo(row);
            var actionsCell = $('<td>').appendTo(row);

            // Create delete button
            var deleteBtn = $('<button>')
                .addClass('btn btn-danger')
                .text('Delete')
                .click(function() {
                deleteEvent(user.username);
                });

            actionsCell.append(deleteBtn);
            tableBody.append(row);
          });
    });
}

function deleteEvent(id) {
    // Send AJAX request to PHP backend to delete the user
    $.get('backend.php', { action: 'deleteEvent', eventId: id }, function(response) {
      // Check if the request was successful
      if (response.success) {
        // Refresh the user table after successful deletion
        refreshEventList();
      } else {
        // Display an error message or handle the error case as needed
      }
    });
  }

$(document).ready(function () {
    // Fetch user count from PHP backend
    $.get("backend.php", { action: "statistics" }, function (response) {
      var userCount = response.userCount;
      var eventCount = response.eventsCount;
      $("#userCount").text(userCount);
      $("#eventCount").text(eventCount);
    });

    refreshEventList();
  });