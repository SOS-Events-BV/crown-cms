@props(['question', 'answer'])

<div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
    <button
        @click="open = !open"
        class="flex justify-between items-center w-full p-4 font-medium text-left hover:bg-gray-50"
    >
        {{ $question }}
        <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': open }"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open" x-collapse x-cloak>
        <div class="p-4 text-gray-600 border-t border-gray-200 text-format">
            {!! $answer !!}
        </div>
    </div>
</div>
