@extends('layouts.app')

@section('content')
    <div class="bg-white w-full flex justify-center items-center pb-6 md:pb-12">
        <div class="flex flex-col gap-6 items-center justify-between w-full">
            <div class="flex gap-3 items-center">
                <div class="px-6 bg-green-200 py-1 text-center text-green-700 rounded-lg">
                    <span id="time-counter">0:00</span>
                </div>

                <a href="/" class="grow">Sluit chat</a>
            </div>

            @if(auth()->id() === $chat->professional_id)
                <div class="flex gap-6 w-full items-center justify-between">
                    <div class="flex flex-col gap-1 grow">
                        <div class="text-2xl xl:max-w-4xl xl:mx-auto">Sander</div>

                        <div>
                            <span class="bg-green-500 text-white rounded-full font-normal text-sm px-3 py-1">Credits: 25 minuten... </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex gap-6 w-full items-center justify-between">
                    <img src="{{ asset('profile.jpg') }}" alt="Profile Avatar" class="rounded-full w-16 h-16">

                    <div class="flex flex-col gap-1 grow">
                        <div class="text-2xl xl:max-w-4xl xl:mx-auto">Willemijn</div>

                        <div>
                            <span class="bg-green-500 text-white rounded-full font-normal text-sm px-3 py-1">Chat gestart</span>
                        </div>
                    </div>

                    <p class="text-balance w-1/2 text-right text-neutral-500 italic"> Hallo! Ik ben Willemijn, fysiotherapeute met passie voor het helpen van mensen om vrijer en zonder pijn te bewegen</p>
                </div>
            @endif

            <div id="chat-messages" class=" border drop-shadow-sm rounded-lg p-3 w-full flex flex-col gap-px">
                @foreach($messages as $message)
                    <div class="flex {{ $message->user->id === auth()->id() ? 'justify-end' : 'justify-start' }} message p-1">
                        <div class="{{ $message->user->id === auth()->id() ? 'bg-green-200' : 'bg-white border' }} p-1 px-2 rounded-lg">
                            {{ $message->message }}
                            <span class="text-xs text-gray-500 ml-1">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <form id="send-message-form" class=" flex gap-3 items-center w-full">
                <input type="hidden" id="chat-id" value="{{ $chat->id }}">
                <input type="text" id="message-input" name="message" class="grow border text-neutral-700 border-neutral-400 px-4 py-2 rounded-md" placeholder="" autofocus required>
                <button type="submit" class="bg-blue-600 border-b-2 border-blue-700 text-white stroke-current px-4 py-2 rounded-md font-bold">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.1525 3.55321L11.1772 21.0044L9.50686 12.4078L2.00002 7.89795L22.1525 3.55321Z" stroke="currentStroke" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M9.45557 12.4436L22.1524 3.55321" stroke="currentStroke" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </form>
        </div>
    </div>
    <script>
        window.chatId = {{ $chat->id }};
        window.authUserId = {{ auth()->id() }};

        document.getElementById('send-message-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const messageInput = document.getElementById('message-input');
            const chatId = document.getElementById('chat-id').value;

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    chat_id: chatId,
                    message: messageInput.value
                })
            })
                .then(response => response.json())
                .then(data => {
                    // const chatMessages = document.getElementById('chat-messages');
                    // const newMessage = document.createElement('p');
                    // newMessage.innerHTML = `<strong>${data.user_name}:</strong> ${data.message.message}`;
                    // chatMessages.appendChild(newMessage);
                    messageInput.value = '';
                })
                .catch(error => console.error('Error:', error));
        });

        let seconds = 0;
        setInterval(() => {
            seconds++;
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            document.getElementById('time-counter').innerText = `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
        }, 1000);
    </script>

    @stack('scripts')
@endsection
