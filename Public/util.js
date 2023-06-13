function showAlert(message, alertType)
{
    $('.alert').remove();

    // Create the alert element
    var alert = $('<div class="alert" role="alert"></div>').addClass('alert-' + alertType).text(message);

    $('#alertContainer').append(alert);

    $('html, body').animate({ scrollTop: 0 }, 'fast');
}