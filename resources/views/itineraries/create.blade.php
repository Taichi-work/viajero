<x-app-layout>
    {{-- 1. 画面全体の背景（ベージュ） --}}
    <div class="bg-[#E8E4DC] min-h-screen w-full">
        
        {{-- 2. 中央寄せのコンテナ --}}
        <div class="max-w-3xl mx-auto py-12 px-4">

            {{-- Navigation --}}
            <a href="{{ route('trips.show', $trip) }}" class="inline-flex items-center text-slate-500 hover:text-slate-700 mb-8 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to itinerary
            </a>

            {{-- 3. メインカード（ここから白背景） --}}
            <div class="bg-white rounded-lg shadow-sm p-8 md:p-12">
                
                {{-- Header --}}
                <div class="mb-10">
                    <h2 class="text-5xl font-bold text-slate-800" style="font-family: Georgia, serif;">
                        Add Plan
                    </h2>
                    <p class="text-slate-600 mt-3 tracking-wide uppercase text-sm font-semibold">
                        Details for your journey
                    </p>
                </div>

                {{-- Form --}}
                <form action="{{ route('itineraries.store', $trip) }}" method="POST" class="space-y-10">
                    @csrf

                    <div class="space-y-6">
                        {{-- Date --}}
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Date</label>
                            <input type="text" id="date-picker" name="date" value="{{ old('date') }}"
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none">
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Time --}}
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Time</label>
                            <select 
                                name="time" 
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none appearance-none"
                            >
                                <option value="">Select Time</option>
                                @for ($hour = 0; $hour < 24; $hour++)
                                    @foreach ([0, 15, 30, 45] as $minute)
                                        @php
                                            $timeValue = sprintf('%02d:%02d', $hour, $minute);
                                            $displayHour = $hour == 0 ? 12 : ($hour > 12 ? $hour - 12 : $hour);
                                            $period = $hour < 12 ? 'AM' : 'PM';
                                            $displayTime = sprintf('%d:%02d %s', $displayHour, $minute, $period);
                                        @endphp
                                        <option value="{{ $timeValue }}" @selected(old('time') === $timeValue)>
                                            {{ $displayTime }}
                                        </option>
                                    @endforeach
                                @endfor
                            </select>
                            @error('time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Plans --}}
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Plans</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="What's the plan?"
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none">
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Notes</label>
                            <textarea name="note" rows="4" placeholder="Optional details..."
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none">{{ old('note') }}</textarea>
                        </div>

                        {{-- Fee --}}
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Fee (¥)</label>
                            <input type="number" name="cost" value="{{ old('cost') }}" placeholder="0"
                                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-slate-700 text-white py-4 rounded-xl font-bold shadow-sm hover:bg-slate-800 transition-all active:scale-[0.98]">
                            Add to Itinerary
                        </button>
                    </div>
                </form>
            </div> {{-- 白カードの閉じタグ --}}
            
        </div> {{-- 中央寄せコンテナの閉じタグ --}}
    </div> {{-- ベージュ背景の閉じタグ --}}

    {{-- Flatpickr JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date-picker", {
            dateFormat: "Y-m-d", 
            altInput: true,
            altFormat: "F j, Y",
            minDate: "{{ $trip->start_date }}",
            maxDate: "{{ $trip->end_date }}",
            onReady: function(selectedDates, dateStr, instance) {
                instance.altInput.classList.add("w-full", "bg-slate-50", "border-none", "rounded-xl", "px-4", "py-3", "focus:ring-2", "focus:ring-slate-400");
            }
        });
    </script>
</x-app-layout>