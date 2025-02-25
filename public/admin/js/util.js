function showAlert(message, alertType) {
    // Clear any existing alerts
    $('.alert').remove();
  
    // Create the alert element
    var alert = $('<div class="alert" role="alert"></div>').addClass('alert-' + alertType).text(message);
  
    // Add the alert to the page
    $('#alertContainer').append(alert);
  
    // Scroll to the top of the page to show the alert
    $('html, body').animate({ scrollTop: 0 }, 'fast');
  }