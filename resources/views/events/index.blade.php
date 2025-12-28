<x-layout title="Events">
<main class="bg-gray-900 min-h-screen text-white py-12">
<div class="max-w-7xl mx-auto px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-black uppercase tracking-tighter italic">
            {{ $isAdmin ? 'Manage' : 'Available' }}
            <span class="text-indigo-500">Events</span>
        </h1>

        @if($isAdmin)
        <a href="{{ route('events.create') }}"
           class="px-4 py-2 bg-indigo-600 rounded-lg text-xs font-bold uppercase">
            Create Event
        </a>
        @endif
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-400 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ADMIN FILTER --}}
    @if($isAdmin)
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search title or location"
            class="px-4 py-2 bg-black/40 border border-white/10 rounded-lg text-sm">

        <select name="status"
            class="px-4 py-2 bg-black/40 border border-white/10 rounded-lg text-sm">
            <option value="">All Status</option>
            <option value="published" {{ request('status')=='published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
        </select>

        <input type="date" name="date" value="{{ request('date') }}"
            class="px-4 py-2 bg-black/40 border border-white/10 rounded-lg text-sm">

        <div class="flex gap-2">
            <button class="px-3 py-2 bg-indigo-600 rounded-lg text-[10px] font-bold uppercase">
                Apply
            </button>
            <a href="{{ route('events.index') }}"
               class="px-3 py-2 bg-white/5 rounded-lg text-[10px] font-bold uppercase">
                Reset
            </a>
        </div>
    </form>
    @endif

    {{-- USER LIVE SEARCH --}}
    @if(!$isAdmin)
    <div class="mb-6">
        <input type="text" id="liveSearch"
            placeholder="Search events..."
            class="w-full px-4 py-2 bg-black/40 border border-white/10 rounded-lg text-sm">
    </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-black/40 border border-white/10 rounded-2xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-white/5 text-indigo-400 text-[10px] uppercase">
                <tr>
                    <th class="p-4">Title</th>
                    <th class="p-4">Location</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr class="border-t border-white/5">
                    <td class="p-4 font-bold text-indigo-500">{{ $event->title }}</td>
                    <td class="p-4 text-sm">{{ $event->location }}</td>
                    <td class="p-4 text-sm">{{ $event->event_date }}</td>
                    <td class="p-4 text-xs">{{ $event->status }}</td>
                    <td class="p-4 text-right">
                        <a href="{{ route('events.show',$event->id) }}"
                           class="px-3 py-1 bg-white/5 rounded text-xs">
                            View
                        </a>

                        @if($isAdmin)
                        <a href="{{ route('events.edit',$event->id) }}"
                           class="px-3 py-1 bg-white/5 rounded text-xs ml-1">
                            Edit
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-500 text-xs">
                        No events found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</main>

{{-- LIVE SEARCH SCRIPT (USER ONLY) --}}
@if(!$isAdmin)
<script>
document.getElementById('liveSearch').addEventListener('keyup', function () {
    let key = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(key) ? '' : 'none';
    });
});
</script>
@endif
</x-layout>
