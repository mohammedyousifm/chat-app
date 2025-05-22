
//
//
//
//
$(document).ready(function () {
     // CSRF Token setup for AJAX
     $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

            // SEND MESSAGE
        $('#sendMessage').click(function (e) {
                e.preventDefault(); // Prevent default form submission

                const receiver_id = $('#receiver_id').val();
                const message = $('#message').val();

                $.ajax({
                    url: '/send/message',
                    method: 'POST',
                    data: {
                        receiver_id: receiver_id,
                        message: message
                    },
                    success: function (data) {
                        console.log('Message sent');

                        $("#chatMessages").load(" #chatMessages > *", function () {
                            var chatBox = document.getElementById("chatMessages");
                            chatBox.scrollTop = chatBox.scrollHeight;
                        });

                        $('#message').val('');
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
});

//
//
//
$(document).ready(function () {
    $('#menuButton').click(function () {
        // Toggle the sidebar with animation
        $('#Sidebar').toggle(500);

        // Toggle the icon class
        const icon = $('#menuButtonIcon');

        if (icon.hasClass('fa-bars')) {
            icon.removeClass('fa-bars').addClass('fa-x');
        } else {
            icon.removeClass('fa-x').addClass('fa-bars');
        }
    });
});

//
//
//
$(document).ready(function () {
            // Show the Notification
    $('#showNotification').click(function () {
        $('#NotificationSidebar').show(500);
    });
            // hide the Notification
        $('#NotificationSidebarIcon').click(function () {
        $('#NotificationSidebar').hide(500);
    });
});



