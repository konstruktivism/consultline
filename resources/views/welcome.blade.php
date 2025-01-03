@extends('layouts.app')

@section('content')
    @auth()
        <div class="flex xl:w-1/2 grow h-full">
            <div class="flex flex-col w-full">
                <h1 class="text-4xl lg:text-6xl font-bold tracking-tight mb-4">Experts</h1>

                <div class="w-full flex flex-col gap-3 lg:gap-6 xl:max-w-4xl xl:mx-auto ">
                    <div class="bg-white border border-b-2 border-b-gray-200 rounded-lg p-9 lg:p-12 flex gap-3 lg:gap-12">
                        <img src="{{ asset('profile.jpg') }}" alt="Profile Avatar" class="rounded-full w-16 h-16 lg:w-32 lg:h-32">

                        <div class="flex gap-3 flex-col text-xl">
                            <h3 class="flex gap-3 items-center">Sander van der Kolk
                                <span class="bg-green-100 text-green-600 text-sm rounded-full px-3 py-1">Available</span>
                            </h3>
                            <div class="flex gap-3">
                                <form action="{{ route('chat.start') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="professional_id" value="1">
                                    <button type="submit" class="bg-yellow-400 border-b-2 border-yellow-500 text-dark px-4 py-2 rounded-md font-bold shrink-0">Start chat</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($chats && auth()->id() == 1)
                        <div id="send-message-form" class="flex flex-col gap-3">
                            @foreach($chats as $chat)
                                <a href="/chat/messages/{{ $chat->id }}" class="flex gap-6 border-b pb-3">
                                    {{ $chat->id }}

                                    {{ $chat->created_at->diffForHumans() }}
                                </a>

                            @endforeach


                        </div>


                        <div id="chat-messages" class=" border drop-shadow-sm rounded-lg p-3 w-full flex-col gap-px grow h-full hidden">
                        </div>
                    @endif


                </div>
            </div>
        </div>
        <script>
            window.chatId = {{ $chats->first()->id ?? null }};
            window.authUserId = {{ auth()->id() }};

            // refresh page every 2 seconds
            setInterval(() => {
                window.location.reload();
            }, 2000);
        </script>
    @endauth

    @stack('scripts')
@endsection

