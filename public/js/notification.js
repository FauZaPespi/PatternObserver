// Listen to the channel
var channel = pusher.subscribe('notifications-channel');

// Bind to the event
channel.bind('new-thread', function(data) {
    // Check if browser supports notifications and if permission is granted
    if (Notification.permission === "granted") {
        new Notification("New Alert!", {
            body: data.news
        });
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                new Notification("New Alert!", {
                    body: data.news
                });
            }
        });
    }
});