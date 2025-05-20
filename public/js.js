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
