<x-app-layout>
    <div class="bg-[#E8E4DC] min-h-screen py-12 px-4">
        <div class="max-w-5xl mx-auto">

            <!-- 戻るボタン -->
            <a href="{{ route('trips.index') }}"
               class="inline-flex items-center text-slate-500 hover:text-slate-700 mb-8 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to list
            </a>

            <!-- ヘッダー -->
            <div class="bg-white rounded-lg shadow-sm p-6 md:p-8 mb-6">
                <h1 class="text-3xl md:text-5xl font-bold text-slate-800 mb-6" style="font-family: Georgia, serif;">
                    Week Itinerary
                </h1>

                <div class="bg-slate-50 rounded-xl p-5 md:p-6 flex flex-col md:flex-row justify-between items-start gap-6">
                    
                    <div class="space-y-3 w-full">
                        <h2 class="text-lg md:text-xl font-bold text-slate-800">
                            {{ $trip->title }}
                        </h2>

                        <div class="space-y-1">
                            <p class="text-sm md:text-base text-slate-600 flex items-center">
                                <span class="font-semibold mr-2 text-slate-400 text-xs uppercase">Where</span>
                                {{ $trip->destination ?? '未設定' }}
                            </p>

                            <p class="text-xs md:text-sm text-slate-500 flex items-center">
                                <span class="font-semibold mr-2 text-slate-400 text-xs uppercase">Dates</span>
                                {{ \Carbon\Carbon::parse($trip->start_date)->format('Y.m.d') }}
                                〜
                                {{ \Carbon\Carbon::parse($trip->end_date)->format('Y.m.d') }}
                            </p>

                            @if($trip->memo)
                                <p class="text-xs md:text-sm text-slate-500 flex items-start">
                                    <span class="font-semibold mr-2 text-slate-400 text-xs uppercase mt-0.5">Notes</span>
                                    <span class="flex-1">{{ $trip->memo }}</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row md:flex-row gap-3 w-full md:w-auto">
                        <a href="{{ route('trips.pdf', $trip) }}"
                        class="inline-flex justify-center items-center bg-white text-slate-700 border border-slate-300 px-4 py-2.5 rounded-lg text-sm hover:bg-slate-50 transition-colors shadow-sm w-full md:w-auto md:min-w-max whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export PDF
                        </a>

                        <a href="{{ route('trips.edit', $trip) }}"
                        class="inline-flex justify-center items-center bg-slate-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-slate-800 transition-all w-full md:w-auto md:min-w-max whitespace-nowrap">
                            Edit
                        </a>
                    </div>
                </div>
            </div>

            <!-- 追加ボタン -->
            <div class="mb-6 px-4 md:pr-12 flex justify-end">
                <a href="{{ route('itineraries.create', $trip) }}"
                    class="w-full md:w-auto text-center bg-slate-700 text-white px-6 py-3 md:py-2 rounded-lg font-medium hover:bg-slate-800 transition-colors shadow-sm">
                    + Add itinerary
                </a>
            </div>

            @foreach ($itinerariesByDate as $date => $items)
                <div class="bg-white rounded-lg shadow-sm p-5 md:p-8 mb-6">
                    <div class="grid grid-cols-12 gap-4 md:gap-8">

                        <div class="col-span-12 md:col-span-3">
                            <div class="md:sticky md:top-8 flex md:flex-col justify-between items-end md:items-start border-b md:border-none pb-4 md:pb-0 mb-4 md:mb-0">
                                <div>
                                    <h2 class="text-4xl md:text-5xl font-bold text-slate-800" style="font-family: Georgia, serif;">
                                        Day {{ $loop->iteration }}
                                    </h2>
                                    <p class="text-sm md:text-base text-slate-600 tracking-wide mt-1">
                                        {{ \Carbon\Carbon::parse($date)->format('M j (D)') }}
                                    </p>
                                </div>

                                <div class="text-right md:text-left md:mt-6 bg-slate-50 md:bg-transparent p-2 md:p-0 rounded-lg">
                                    <div class="text-[10px] md:text-sm font-semibold text-slate-400 uppercase tracking-wider">Daily Total</div>
                                    <div class="text-lg md:text-xl font-bold text-slate-700">
                                        ¥{{ number_format($dailyCosts[$date] ?? 0) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 md:col-span-9 relative">
                            <div class="absolute left-0 top-0 bottom-0 w-px bg-slate-200 hidden md:block"></div>

                            <ul class="itinerary-list space-y-6 md:pl-8">
                                @php $lastSlot = null; @endphp

                                @foreach ($items as $itinerary)
                                    {{-- 時間帯見出し --}}
                                    @if ($itinerary->time_slot !== $lastSlot)
                                        <li class="relative mt-8 first:mt-0 pt-4 md:pt-0">
                                            <div class="absolute -left-[35px] w-3 h-3 bg-slate-400 rounded-full hidden md:block border-4 border-white"></div>
                                            <h3 class="font-bold text-slate-500 text-xs uppercase tracking-widest">
                                                {{ $itinerary->time_slot }}
                                            </h3>
                                        </li>
                                        @php $lastSlot = $itinerary->time_slot; @endphp
                                    @endif

                                    {{-- 旅程アイテム --}}
                                    <li data-id="{{ $itinerary->id }}" class="relative group border-b border-slate-50 md:border-none pb-4 md:pb-0">
                                        <div class="absolute -left-[33px] w-2 h-2 bg-slate-300 rounded-full top-2 hidden md:block"></div>

                                        <div class="flex flex-col md:flex-row justify-between items-start gap-3">
                                            <div class="flex-1 w-full">
                                                <div class="flex items-baseline gap-3">
                                                    <span class="text-sm text-slate-400 font-mono font-medium min-w-[45px]">
                                                        {{ $itinerary->time ?? '--:--' }}
                                                    </span>

                                                    <div class="flex-1">
                                                        <div class="text-slate-800 font-semibold text-base md:text-lg">
                                                            {{ $itinerary->title }}
                                                        </div>

                                                        @if($itinerary->note)
                                                            <div class="text-sm text-slate-500 mt-1 leading-relaxed">
                                                                {{ $itinerary->note }}
                                                            </div>
                                                        @endif

                                                        @if($itinerary->cost)
                                                            <div class="inline-block bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded mt-2 font-medium">
                                                                ¥{{ number_format($itinerary->cost) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- 操作ボタン：スマホでは右下に配置、PCではホバー時のみ --}}
                                            <div class="flex gap-4 self-end md:self-start opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('itineraries.edit', [$trip, $itinerary]) }}"
                                                class="text-slate-400 hover:text-sky-600 text-xs font-bold uppercase tracking-tighter">
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('itineraries.destroy', [$trip, $itinerary]) }}"
                                                    onsubmit="return confirm('本当に削除しますか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-400 hover:text-red-500 text-xs font-bold uppercase tracking-tighter">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-12 px-4">
                <div class="bg-white rounded-lg p-6 flex flex-col md:flex-row justify-between items-center border-2 border-red-50 shadow-sm">
                    <div class="text-center md:text-left mb-6 md:mb-0">
                        <h3 class="text-lg font-bold text-red-800 uppercase tracking-wider">Danger Zone</h3>
                        <p class="text-xs text-slate-400 mt-1">This action cannot be undone. All data will be lost.</p>
                    </div>
                    
                    <form action="{{ route('trips.destroy', $trip) }}" method="POST" 
                        onsubmit="return confirm('旅行プラン全体を完全に削除しますか？');"
                        class="w-full md:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full md:w-auto bg-white border-2 border-red-600 text-red-600 px-8 py-3 rounded-lg font-bold hover:bg-red-600 hover:text-white transition-all">
                            Delete Entire Trip
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- SortableJS --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>window.itineraryOrderUrl = "{{ route('itineraries.updateOrder') }}";</script>


    <script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.itinerary-list').forEach(el => {

            new Sortable(el, {
                animation: 150,
                ghostClass: 'bg-slate-100',
                filter: 'li:not([data-id])',
                
                onEnd: function (evt) {
                    const order = [];
                    const movedId = evt.item.dataset.id;
                    const movedTime = evt.item.querySelector('.text-slate-500.font-medium')?.textContent?.trim();

                    // 並び順を収集
                    el.querySelectorAll('li[data-id]').forEach((li, index) => {
                        order.push({
                            id: li.dataset.id,
                            order: index
                        });
                    });

                    // 時間帯が変わった場合は警告
                    if (movedTime && movedTime !== '--:--') {
                        const newTimeSlot = getTimeSlotFromElement(evt.item);
                        console.log('Moved to:', newTimeSlot);
                    }

                    // サーバーに送信
                    fetch(window.itineraryOrderUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ order: order.map(item => item.id) })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // 成功したらページをリロードして時間帯の再分類を反映
                            location.reload();
                        }
                    });
                }
            });

        });

        // 時間帯を判定する補助関数
        function getTimeSlotFromElement(element) {
            let current = element.previousElementSibling;
            while (current) {
                if (current.querySelector('h3')) {
                    return current.querySelector('h3').textContent.trim();
                }
                current = current.previousElementSibling;
            }
            return 'Unknown';
        }

    });
    </script>
</x-app-layout>
