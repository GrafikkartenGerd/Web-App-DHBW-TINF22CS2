 // Function to populate the user table
 function populateUserTable(users) {
    var userTableBody = $('#userTableBody');
    userTableBody.empty(); // Clear previous table content

    // Loop through the users array and create table rows
    users.forEach(function(user) {
      var row = $('<tr>');
      var usernameCell = $('<td>').text(user.username);
      var nameCell = $('<td>').text(user.name + user.surname);
      var courseCell = $('<td>').text(user.course);
      var actionsCell = $('<td>');

      // Create delete button
      var deleteBtn = $('<button>')
        .addClass('btn btn-danger')
        .text('Delete')
        .click(function() {
          deleteUser(user.username);
        });

      // Create reset password button
      var resetPasswordBtn = $('<button>')
        .addClass('btn btn-warning')
        .text('Reset Password')
        .click(function() {
          resetPassword(user.username);
        });

      actionsCell.append(deleteBtn, resetPasswordBtn);
      row.append(usernameCell, nameCell, courseCell, actionsCell);
      userTableBody.append(row);
    });
  }

  // Function to perform user search
  function searchUsers() {
    var searchInput = $('#searchUserInput').val();

    // Send AJAX request to PHP backend with the search query
    $.get('backend.php', { action: 'searchUsers', query: searchInput }, function(response) {
      // Check if the request was successful
      if (response.success) {
        var users = response.users;
        populateUserTable(users); // Populate the user table with the search results
      } else {
        // Display an error message or handle the error case as needed
      }
    });
  }

  // Function to delete a user
  function deleteUser(username) {
    // Send AJAX request to PHP backend to delete the user
    $.get('backend.php', { action: 'deleteUser', username: username }, function(response) {
      // Check if the request was successful
      if (response.success) {
        // Refresh the user table after successful deletion
        searchUsers();
      } else {
        // Display an error message or handle the error case as needed
      }
    });
  }

  // Function to reset a user's password
  function resetPassword(username) {
    // Send AJAX request to PHP backend to reset the user's password
    $.get('backend.php', { action: 'resetPassword', username: username }, function(response) {
      // Check if the request was successful
      if (response.success) {
        alert("New password: " + response.password);
      } else {
        alert("Could not set password: " + response.reason);
      }
    });
  }

  // Search users when the Search button is clicked
  $('#searchUserBtn').click(function() {
    searchUsers();
  });

  $(document).ready(function () {
    // Fetch user count from PHP backend
    $.get("backend.php", { action: "statistics" }, function (response) {
      var userCount = response.userCount;
      var eventCount = response.eventsCount;
      $("#userCount").text(userCount);
      $("#eventCount").text(eventCount);
    });
  });