document.getElementById('eventForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var eventName = document.getElementById('eventName').value;
    var eventDate = document.getElementById('eventDate').value;
    var eventLocation = document.getElementById('eventLocation').value;

    var eventElement = document.createElement('div');
    eventElement.className = 'event';
    eventElement.innerHTML = '<h3>' + eventName + '</h3>' +
                            '<p>Date: ' + eventDate + '</p>' +
                            '<p>Location: ' + eventLocation + '</p>' +
                            '<p>Likes: <span id="likesCount">0</span>' +
                            '<span class="like-button" onclick="likeEvent(this)"> Like</span></p>';

    document.getElementById('eventList').appendChild(eventElement);

    document.getElementById('eventName').value = '';
    document.getElementById('eventDate').value = '';
    document.getElementById('eventLocation').value = '';
});

var likeCount = 0;
var dislikeCount = 0;
var isLiked = false;
var isDisliked = false;

function toggleLike() {
    if (!isLiked) {
        if (isDisliked) {
            toggleDislike();
        }
        likeCount++;
        document.getElementById("likeButton").style.backgroundColor = "green";
    } else {
        likeCount--;
        document.getElementById("likeButton").style.backgroundColor = "initial";
    }
    isLiked = !isLiked;
    updateLikeCount();
}

function toggleDislike() {
    if (!isDisliked) {
        if (isLiked) {
            toggleLike();
        }
        dislikeCount++;
        document.getElementById("dislikeButton").style.backgroundColor = "red";
    } else {
        dislikeCount--;
        document.getElementById("dislikeButton").style.backgroundColor = "initial";
    }
    isDisliked = !isDisliked;
    updateDislikeCount();
}

function updateLikeCount() {
    document.getElementById("likeCount").textContent = likeCount + (likeCount === 1 ? " Like" : " Likes");
}

function updateDislikeCount() {
    document.getElementById("dislikeCount").textContent = dislikeCount + (dislikeCount === 1 ? " Dislike" : " Dislikes");
}



