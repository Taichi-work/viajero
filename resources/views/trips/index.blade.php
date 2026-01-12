<x-app-layout>
    <div class="bg-[#E8E4DC] min-h-screen py-12 px-4">
        <div class="max-w-5xl mx-auto">

            {{-- Header --}}
            <header class="flex justify-between items-end mb-12">
                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Explore Your Journeys</p>
                    <a href="{{ route('trips.index') }}" class="hover:opacity-80 transition-opacity">
                        <h1 class="text-5xl font-bold text-slate-800" style="font-family: Georgia, serif;">
                            Viajero
                        </h1>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-slate-600 font-medium">{{ Auth::user()->name }}</span>
                    <div class="w-12 h-12 rounded-full border-2 border-white shadow-sm overflow-hidden bg-white">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=cbd5e1&color=475569" alt="avatar">
                    </div>
                </div>
            </header>

            {{-- Search & Actions --}}
            <form action="{{ route('trips.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 mb-8">
                <div class="relative flex-1 group">
                    <span class="absolute inset-y-0 left-5 flex items-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="w-full rounded-xl bg-white border-none shadow-sm px-12 py-4 text-slate-600 focus:ring-2 focus:ring-slate-400 transition-all placeholder:text-slate-400"
                        placeholder="Search by title or destination..." />
                </div>
                
                <button type="submit" class="bg-slate-200 text-slate-700 px-6 py-4 rounded-xl font-bold hover:bg-slate-300 transition-all shadow-sm">
                    Search
                </button>

                <a href="{{ route('trips.create') }}"
                class="bg-slate-700 text-white px-8 py-4 rounded-xl font-bold hover:bg-slate-800 transition-all shadow-sm flex items-center justify-center gap-2">
                    <span class="text-xl">+</span> New Trip
                </a>
            </form>

            {{-- Trip Cards List --}}
            <div class="space-y-6">
                @forelse ($trips as $trip)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
                        <div class="grid grid-cols-12">
                            {{-- Image Preview (Optional/Small) --}}
                            <div class="col-span-12 md:col-span-3 h-48 md:h-auto relative overflow-hidden">
                                <img src="https://picsum.photos/seed/{{ $trip->id }}/400/300"
                                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>

                            {{-- Content --}}
                            <div class="col-span-12 md:col-span-9 p-8 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-4">
                                        <h2 class="text-3xl font-bold text-slate-800" style="font-family: Georgia, serif;">
                                            {{ $trip->title }}
                                        </h2>
                                        <a href="{{ route('trips.edit', $trip) }}" class="text-slate-400 hover:text-slate-600 p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>

                                    <div class="space-y-2 mb-6">
                                        <div class="flex items-center text-slate-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span class="font-medium">{{ $trip->destination ?? 'Destination unset' }}</span>
                                        </div>
                                        <div class="flex items-center text-slate-500 text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            {{ \Carbon\Carbon::parse($trip->start_date)->format('M j, Y') }} — {{ \Carbon\Carbon::parse($trip->end_date)->format('M j, Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                                    <span class="text-xs text-slate-400">Created: {{ $trip->created_at->format('M j, Y') }}</span>
                                    <a href="{{ route('trips.show', $trip) }}" 
                                       class="inline-flex items-center text-slate-700 font-bold hover:text-slate-900 transition-colors">
                                        View Itinerary
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg p-12 text-center shadow-sm">
                        <p class="text-slate-500 italic">No trips found. Let's start a new adventure!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>