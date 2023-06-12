
function refreshEventList(){
    $.get("backend.php", { action: "getEventList" }, function (response) {
        if(!response.status) return;
        var eventList = response.events;

        // Populate the event table
        var tableBody = $('#eventsTableBody');
        tableBody.empty(); // Clear previous table content

        eventList.forEach(function (event) {
            var row = $("<tr>");

            var eventNameCell = $('<td>')
            var eventLink = $('<a>').attr('href', '../HTML/event.php?id=' + event.id).text(event.name);
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