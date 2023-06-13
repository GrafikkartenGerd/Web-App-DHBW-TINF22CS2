var eventCard = document.getElementById('eventCard');
var mc = new Hammer(eventCard);

var initialX = null;
var isSwiping = false;

function changeEventStatus(accept){
    $.post('event.php?id=' + window.event.id, { accept: accept }, function(response) {
      });
}

mc.on('panstart', function (e)
{
    initialX = e.center.x;
    isSwiping = true;
});

mc.on('panmove', function (e)
{
    if (!isSwiping) return;
    var deltaX = e.deltaX;
    eventCard.style.transform = 'translateX(' + deltaX + 'px)';
});

mc.on('panend', function (e)
{
    if (!isSwiping) return;
    isSwiping = false;
    eventCard.style.transform = '';

    var deltaX = e.deltaX;
    var threshold = eventCard.offsetWidth * 0.25;

    if (deltaX < -threshold)
    {
        eventCard.classList.add('swipe-left');
        explodeCard();
        changeEventStatus(false);
    } else if (deltaX > threshold)
    {
        eventCard.classList.add('swipe-right');
        showConfirmation();
        eventCard.style.display = "none";
        changeEventStatus(true);
    }

    fetchNextEvent();
});

function explodeCard()
{
    $(eventCard).hide("explode", { pieces: 5 }, 150);
    var audio = new Audio('nope.mp3');
    audio.play();

}


function showConfirmation()
{
    // Play chime sound
    var audio = new Audio('chime.mp3');
    audio.play();
    // 
    var confirmationContainer = $('<div>Liked event!</div>')
        .addClass('confirmation-popup')
        .appendTo('body');

    // this will make the background darker temporarly
    var overlay = $('<div></div>')
        .addClass('overlay')
        .appendTo('body');

    // Show confetti
    var confettiSettings = {
        target: 'confetti-canvas',
        max: 100,
        size: 1,
        animate: true
    };
    var confetti = new ConfettiGenerator(confettiSettings);
    confetti.render();

    // add bounce
    confirmationContainer.effect('bounce', { times: 2, distance: 100 }, 750, function ()
    {
        confirmationContainer.remove();
        confetti.clear();
        overlay.remove();
    });
}