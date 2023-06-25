 // Function to populate the user table
function populateUserTable(users, isSuperAdmin) {
    var userTableBody = $('#userTableBody');
    userTableBody.empty();

    
    users.forEach(function(user) {
      var row = $('<tr>');
      var usernameCell = $('<td>');
      var usernameLink = $('<a>').attr('href', '../user.php?id=' + user.id).text(user.username);
      usernameCell.append(usernameLink);
      var nameCell = $('<td>').text(user.name + " " + user.surname);
      var courseCell = $('<td>').text(user.course);
      var actionsCell = $('<td>');

      if (user.is_super_admin != 1) // super admin accounts should remain untouched
      {
        // delete user button
        var deleteBtn = $('<button>')
          .addClass('btn btn-danger')
          .text('Delete')
          .click(function ()
          {
            deleteUser(user.username);
          });
        
        actionsCell.append(deleteBtn);

        // reset password btn
        var resetPasswordBtn = $('<button>')
          .addClass('btn btn-warning')
          .text('Reset Password')
          .click(function ()
          {
            resetPassword(user.username);
          });

        var exportUserBtn = $('<button>')
          .addClass('btn btn-info')
          .text('Export')
          .click(function ()
          {
            exportUser(user.username);
          });


        actionsCell.append(resetPasswordBtn, exportUserBtn);

        if (isSuperAdmin)
        {
          var userLevelButton;
          if (user.is_admin)
          {
            userLevelButton = $('<button>')
              .addClass('btn btn-danger')
              .text('Remove Admin')
              .click(function ()
              {
                changeUserLevel(user.username, 0);
              });
          } else
          {
            userLevelButton = $('<button>')
              .addClass('btn btn-danger')
              .text('Make Admin')
              .click(function ()
              {
                changeUserLevel(user.username, 1);
              });
          }

          actionsCell.append(userLevelButton);
        }
      }

      row.append(usernameCell, nameCell, courseCell, actionsCell);
      userTableBody.append(row);
    });
  }

  // Function to perform user search
  function searchUsers(quiet = false) {
    var searchInput = $('#searchUserInput').val();

    // Send AJAX request to PHP backend with the search query
    $.get('backend.php', { action: 'searchUsers', query: searchInput }, function(response) {
      // Check if the request was successful
      if (response.success) {
        var users = response.users;
        populateUserTable(users, response.is_self_super_admin); // Populate the user table with the search results
      } else {
        if(!quiet)
          showAlert("Couldn't find user!", "danger");
      }
    });
  }

  // Function to change user permission level
function changeUserLevel(username, promote)
  {
    $.get('backend.php', { action: 'userPerms', username: username, promote: promote}, function (response)
    {
      if (response.success)
      {
        showAlert("Changed user permissions successfully!", "success");
        searchUsers(true);
      } else
      {
        showAlert("Change user permissions!", "danger");
      }
    });
  }

  // Function to delete a user
  function deleteUser(username) {
    $.get('backend.php', { action: 'deleteUser', username: username }, function(response) {
      if (response.success) {
        showAlert("Deleted user successfully!", "success");
        searchUsers(true);
      } else {
        showAlert("Couldn't delete user: " + response.reason, "danger");
      }
    });
  }

  // Function to reset a user's password
  function resetPassword(username) {
    $.get('backend.php', { action: 'resetPassword', username: username }, function(response) {
    
      if (response.success) {
        showAlert("Password set to " + response.password, "success");
      } else {
        showAlert("Could not set password: " + response.reason, "danger");
      }
    });
  }

  function exportUser(username){
    window.open("exportUser.php?username=" + username);
  }

  $('#searchUserBtn').click(function() {
    searchUsers();
  });
