<div wire:poll.keep-alive>
    @foreach($professionals as $professional)
        <li class="flex items-start justify-between border shadow-sm rounded bg-white gap-3 px-6 py-3">

            <span class="inline-block w-4 h-4 mr-2 shrink-0 rounded-full mt-1 {{ $professional->status == 'red' ? 'bg-red-500' : 'bg-green-500' }}"></span>

            <div class="flex flex-col grow">
                {{ $professional->name }}

                <div class="opacity-50">{{ $professional->specialization }}</div>
            </div>


            <a href="tel:+31855055233" class="text-indigo-500 underline">Bel 085 055233</a>
        </li>
    @endforeach
</div>
