@extends('layouts.admin')

@section('page-title', 'Partners')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-400 text-sm">Manage partnership logos/names on the homepage.</p>
    <a href="{{ route('admin.partners.create') }}" class="px-4 py-2 bg-cyan-400 text-black text-sm font-semibold rounded-lg hover:bg-cyan-300">Add Partner</a>
</div>

<div class="space-y-3">
    @forelse($partners as $p)
        <div class="flex items-center justify-between p-4 rounded-xl bg-[#141414] border border-cyan-400/15">
            <div class="font-medium text-white">{{ $p->name }}</div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500">Order: {{ $p->sort_order }}</span>
                <a href="{{ route('admin.partners.edit', $p) }}" class="text-sm text-cyan-400">Edit</a>
                <form method="POST" action="{{ route('admin.partners.destroy', $p) }}" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-400">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-sm">No partners yet.</p>
    @endforelse
</div>
@endsection
