function shownotification(schedule) {
    (async () => {
        // create and show the notification
        const showNotification = () => {
            // create a new notification
            const notification = new Notification('Class Alarm.', {
                body: "A class will be starting soon. Please check your schedule",
                icon: './img/js.png'
            });

            // close the notification after 10 seconds
            setTimeout(() => {
                notification.close();
            }, 10 * 2000);

            // navigate to a URL when clicked
            notification.addEventListener('click', () => {

                window.open('', '_blank');
            });
        }

        // show an error message
        const showError = () => {
            const error = document.querySelector('.error');
            error.style.display = 'block';
            error.textContent = 'You blocked the notifications';
        }

        // check notification permission
        let granted = false;

        if (Notification.permission === 'granted') {
            granted = true;
        } else if (Notification.permission !== 'denied') {
            let permission = await Notification.requestPermission();
            granted = permission === 'granted' ? true : false;
        }

        // show notification or error
        if(granted) {
            for (i = 0; i < schedule.length; i++) {
                var now = new Date();
                var hour = now.getHours();
                var minutes = now.getMinutes();
                var second = now.getSeconds();

                if (schedule[0] != undefined || schedule.length == 0) {
                    for(i=0;i < schedule.length; i++) {
                        var t = schedule[i].split(':');
                        if(hour == t[0] && minutes == t[1] && second < t[2]+2 && second > t[2]-2){
                            alert("Please get ready for class");
                            showNotification();
                        }
                    }
                }
            } 
        }else showError();

    })();
}