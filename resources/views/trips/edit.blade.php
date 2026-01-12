<x-app-layout>
    <div class="bg-[#E8E4DC] min-h-screen py-12 px-4">
        <div class="max-w-3xl mx-auto">
            
            {{-- Navigation --}}
            <a href="{{ route('trips.show', $trip) }}"
               class="inline-flex items-center text-slate-500 hover:text-slate-700 mb-8 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to details
            </a>

            {{-- Header --}}
            <div class="mb-10">
                <h2 class="text-5xl font-bold text-slate-800" style="font-family: Georgia, serif;">
                    Edit Journey
                </h2>
                <p class="text-slate-600 mt-3 tracking-wide uppercase text-sm font-semibold">
                    Update your trip memories and plans
                </p>
            </div>

            <form method="POST" action="{{ route('trips.update', $trip) }}" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Form Content (trips/_form.blade.php を読み込み) --}}
                <div class="bg-white rounded-lg shadow-sm p-8 md:p-12">
                    @include('trips._form')
                </div>

                {{-- Action Bar --}}
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('trips.show', $trip) }}" 
                       class="flex-1 bg-white text-slate-500 border border-slate-200 text-center font-bold py-4 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="flex-1 bg-slate-700 text-white rounded-lg py-4 font-bold shadow-sm hover:bg-slate-800 transition-all active:scale-[0.98]">
                        Update Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Flatpickr 読み込み --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        const config = {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            disableMobile: "true",
            onReady: function(selectedDates, dateStr, instance) {
                // 入力欄のスタイルを統一
                instance.altInput.classList.add("w-full", "bg-slate-50", "border-none", "rounded-xl", "px-4", "py-3", "focus:ring-2", "focus:ring-slate-400");
            }
        };

        const startPicker = flatpickr("#start_date", {
            ...config,
            onChange: function(selectedDates, dateStr) {
                endPicker.set('minDate', dateStr);
            }
        });

        const endPicker = flatpickr("#end_date", {
            ...config,
            onChange: function(selectedDates, dateStr) {
                startPicker.set('maxDate', dateStr);
            }
        });
    </script>
</x-app-layout>