import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

const chatMessages = document.getElementById('chat-messages');

Echo.private('chat.' + window.chatId)
    .listen('.MessageSent', (e) => {
        const newMessage = document.createElement('div');
        newMessage.classList.add(
            'flex',
            e.message.user_id === window.authUserId ? 'justify-end' : 'justify-start',
            'message',
            'p-1'
        );
        newMessage.innerHTML = `<div class="${e.message.user_id === window.authUserId ? 'bg-green-200' : 'bg-white border'} p-1 px-2 rounded-lg">
            ${e.message.message}
        <span class="text-xs text-gray-500 ml-1">${new Date(e.message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
    </div>`;
        chatMessages.appendChild(newMessage);

        // Show notification
        if (Notification.permission === 'granted') {
            console.log('Showing notification for new message');
            new Notification('New Message', {
                body: e.message.message,
                //icon: '/path/to/icon.png' // Optional: path to an icon
            });
            console.log('Notification shown');
        } else {
            console.log('Notification permission not granted');
        }
    });

if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('/service-worker.js')
        .then(function (registration) {
            console.log('Service Worker registered with scope:', registration.scope);

            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    console.log('Notification permission granted.');

                    registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: urlB64ToUint8Array(window.VAPID_PUBLIC_KEY)
                    }).then(function(subscription) {
                        console.log('User is subscribed:', subscription);
                        // Send subscription to your server to store it
                    }).catch(function(err) {
                        console.error('Failed to subscribe the user:', err);
                    });
                } else {
                    console.log('Notification permission denied.');
                }
            });
        })
        .catch(function (error) {
            console.error('Service Worker registration failed:', error);
        });
}

function urlB64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const rawData = window.atob(base64);
    return new Uint8Array([...rawData].map(char => char.charCodeAt(0)));
}
