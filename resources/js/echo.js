import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

Pusher.logToConsole = true;
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    enabledTransports: ["ws", "wss"],
});


window.Echo.channel('send_message')
    .listen('.SendMessageEvent', (e) => {
        console.log('Yes event working', e.message);
          $("#chatMessages").load(" #chatMessages >*");
          $("#newMessageNotification").load(" #newMessageNotification >*")

           var chatBox = document.getElementById("chatMessages");
            chatBox.scrollTop = chatBox.scrollHeight;
    });

