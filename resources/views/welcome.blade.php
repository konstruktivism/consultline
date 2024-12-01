@extends('layouts.app')

@section('content')
    @auth()
        @if(auth()->user()->credits > 10)
            <div class="flex flex-col w-full xl:max-w-4xl xl:mx-auto">
                <div class="w-full mt-6 bg-green-200 pt-1 text-center text-green-700 rounded-lg">
                    <marquee>Je hebt nog credits voor {{ auth()->user()->credits / 60 }} minuten</marquee></div>
            </div>

            <div class="flex flex-col w-full">

                <div class="w-full text-2xl mt-6 xl:max-w-4xl xl:mx-auto">Zorgprofessionals</div>

                <div class="w-full flex flex-col gap-6 mt-6 xl:max-w-4xl xl:mx-auto">
                    <div class="bg-white border rounded-lg p-6 flex gap-12">
                        <img src="{{ asset('profile.jpg') }}" alt="Profile Avatar" class="rounded-full w-32 h-32">

                        <div class="flex gap-3 flex-col">
                            <h3 class="text-lg font-bold flex gap-3 items-center">Willemijn
                                <span class="bg-green-500 text-white rounded-full font-normal text-sm px-3 py-1">Beschikbaar</span>
                            </h3>
                            <p>Specialisatie: Fysiotherapie</p>
                            <p>Ervaring: 10 jaar</p>

                            <div class="flex gap-3 mt-3">
                                <form action="{{ route('chat.start') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="professional_id" value="2">
                                    <button type="submit" class="px-3 py-1 bg-purple-100 text-purple-500 font-bold rounded">Start chat</button>
                                </form>

                                <a href="" class="px-3 py-1 bg-blue-100 text-blue-500 font-bold rounded">Bel</a>

                                <a href=""  class="px-3 py-1 border rounded">Maak een afspraak</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        @else
            <div class="w-full text-xl mt-6">Koop credits</div>

            <form action="{{ route('payment.create') }}" method="GET" class="flex gap-3">
                @csrf

                <div class="flex gap-3">
                    <button type="button" class="border border-blue-600 text-neutral-800 px-4 py-2 rounded-md" onclick="setDuration(30, this)">30 minuten</button>
                    <button type="button" class="border text-neutral-700 px-4 py-2 rounded-md" onclick="setDuration(60, this)">60 minuten</button>
                    <button type="button" class="border text-neutral-700 px-4 py-2 rounded-md" onclick="setDuration(90, this)">90 minuten</button>
                </div>

                <input type="hidden" name="amount" id="amount" value="30">

                <input type="hidden" name="name" id="name" value="{{ auth()->user()->name }}">

                <input type="hidden" name="email" id="email" value="{{ auth()->user()->email }}">

                <button type="submit" class="bg-blue-600 border-b-2 border-blue-700 text-white px-4 py-2 rounded-md font-bold">Betaal via iDEAL</button>
            </form>
        @endif
    @endauth
@endsection
