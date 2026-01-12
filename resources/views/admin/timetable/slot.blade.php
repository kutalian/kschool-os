<div class="w-full h-full flex items-center justify-center relative group min-h-[96px]">
    @php
        $currentDay = is_string($day) ? $day : '';
        $daySchedule = (is_array($schedule) && isset($schedule[$currentDay])) ? $schedule[$currentDay] : [];
        $entry = $daySchedule[$period] ?? null;
    @endphp

    @if($entry)
        <div class="text-center w-full p-2">
            <p class="font-bold text-gray-800 text-sm leading-tight">{{ $entry->subject->name }}</p>

            <button onclick="clearSlot('{{ $day }}', {{ $period }})"
                class="absolute top-0 right-0 m-1 w-5 h-5 flex items-center justify-center text-gray-300 hover:text-red-600 hover:bg-red-50 rounded-full transition z-20"
                title="Delete Assignment">
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>
    @else
        <div class="w-full h-full flex items-center justify-center relative">
            <select onchange="assignSubject('{{ $day }}', {{ $period }}, this.value)"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <option value="">Assign (+)</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            <span class="text-gray-300 text-2xl font-light select-none group-hover:text-blue-500 transition-colors">+</span>
        </div>
    @endif
</div>