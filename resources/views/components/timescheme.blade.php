@props(['timescheme'])

@php
    $schemeCategories = collect($timescheme)->pluck('name');
@endphp

<div x-data="{ category: @js($schemeCategories->first()) }">

    <div class="flex flex-wrap border border-gray-200 mb-3 rounded-lg overflow-hidden">
        @foreach($schemeCategories as $category)
            <button
                class="flex-1 p-3 text-center transition-colors cursor-pointer"
                @click="category = @js($category)"
                :class="{ 'bg-gray-200': category != @js($category), 'bg-white': category == @js($category) }"
            >
                {{ $category }}
            </button>
        @endforeach
    </div>

    <div>
        @foreach($timescheme as $scheme)
            <div x-show="category === @js($scheme['name'])" x-transition.in x-cloak>
                <table class="w-full">
                    @foreach($scheme['rows'] as $row)
                        <tr>
                            <td class="font-semibold">
                                {{ \Carbon\Carbon::parse($row['start_time'])->format('G:i') }}
                                -
                                {{ \Carbon\Carbon::parse($row['end_time'])->format('G:i') }}
                            </td>
                            <td>{{ $row['activity'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
</div>
