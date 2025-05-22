<script src="{{ asset('js.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    $("document").ready(function () {
        //  ==== CLEAR ALL NOTIFICATION
        $(document).on('click', "#clearNotification", function () {
            $.ajax({
                url: {{ Illuminate\Support\Js::from(route('notification.clear')) }},
                method: 'get',
                success: function (data) {
                    $("#notificationIconModel").load(" #notificationIconModel >*")
                },
                error: function () {
                    alert('please try again');
                },
            });
        });
    });
</script>


@vite('resources/js/app.js')
