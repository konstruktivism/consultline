import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const chatMessages = document.getElementById('chat-messages');


Echo.private('chat.' + window.chatId)
    .listen('.MessageSent', (e) => {
        const newMessage = document.createElement('div');
        newMessage.classList.add(e.message.user_id === window.authUserId ? 'flex' : 'flex', e.message.user_id === window.authUserId ? 'justify-end' : 'justify-start', 'message', 'p-1');
        newMessage.innerHTML = `<div class="${e.message.user_id === window.authUserId ? 'bg-green-200' : 'bg-white border'} p-1 px-2 rounded-lg">
            ${e.message.message}
        <span class="text-xs text-gray-500 ml-1">${new Date(e.message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
    </div>`;
        chatMessages.appendChild(newMessage);
    });
