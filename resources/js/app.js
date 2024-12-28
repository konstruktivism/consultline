import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

function showNotification(message) {
    if (Notification.permission === 'granted') {
        new Notification('New Message', {
            body: message,
            icon: '/logo.png' // Optional: path to an icon
        });
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                new Notification('New Message', {
                    body: message,
                    icon: '/logo.png'
                });
            }
        });
    }
}

if (typeof window.chatId !== 'undefined') {
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
            showNotification(e.message.message);
        });
}


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
