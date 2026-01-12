@php
    $isEdit = isset($trip);
@endphp

<div class="space-y-10">

    {{-- 基本情報 --}}
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-slate-800" style="font-family: Georgia, serif;">
            Basic Info
        </h3>

        <div class="space-y-4">
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Title</label>
                <input
                    type="text"
                    name="title"
                    placeholder="What This Trip Is About"
                    value="{{ old('title', $trip->title ?? '') }}"
                    class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none"
                />
            </div>

            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Notes</label>
                <textarea
                    name="memo"
                    placeholder="Brief description or memo..."
                    rows="3"
                    class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3
                           focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none"
                >{{ old('memo', $trip->memo ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- 場所 --}}
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-slate-800" style="font-family: Georgia, serif;">
            Destination
        </h3>

        <div>
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Where to</label>
            <input
                type="text"
                name="destination"
                placeholder="e.g. Paris, France"
                value="{{ old('destination', $trip->destination ?? '') }}"
                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3
                       focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none"
            />
        </div>
    </div>

    {{-- 日程 --}}
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-slate-800" style="font-family: Georgia, serif;">
            Dates
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- 開始日 --}}
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                    Departure
                </label>
                <input type="text"
                    id="start_date"
                    name="start_date"
                    value="{{ old('start_date', $trip->start_date ?? '') }}"
                    class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3
                            focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none" />
            </div>

            {{-- 終了日 --}}
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                    Return
                </label>
                <input type="text"
                    id="end_date"
                    name="end_date"
                    value="{{ old('end_date', $trip->end_date ?? '') }}"
                    class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3
                            focus:ring-2 focus:ring-slate-400 focus:bg-white transition-all outline-none" />
            </div>
        </div>
    </div>

</div>