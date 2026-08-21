@extends('layouts.admin')

@section('page-title', 'Graphics')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-400 text-sm">Manage graphic portfolio items</p>
    <a href="{{ route('admin.graphics.create') }}" class="px-4 py-2 bg-cyan-400 text-black text-sm font-semibold rounded-lg hover:bg-cyan-300">+ Add Graphic</a>
</div>

<div class="bg-[#141414] border border-cyan-400/20 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-cyan-400/10 text-gray-500">
            <tr>
                <th class="text-left px-6 py-3">Title</th>
                <th class="text-left px-6 py-3">Category</th>
                <th class="text-left px-6 py-3">Order</th>
                <th class="text-left px-6 py-3">Status</th>
                <th class="text-right px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-cyan-400/10">
            @forelse($graphics as $graphic)
                <tr class="hover:bg-white/5">
                    <td class="px-6 py-4 text-white font-medium">{{ $graphic->title }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $graphic->category }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $graphic->sort_order }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs {{ $graphic->is_active ? 'bg-green-400/10 text-green-400' : 'bg-red-400/10 text-red-400' }}">
                            {{ $graphic->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.graphics.edit', $graphic) }}" class="text-cyan-400 hover:text-cyan-300">Edit</a>
                        <form method="POST" action="{{ route('admin.graphics.destroy', $graphic) }}" class="inline" onsubmit="return confirm('Delete this graphic?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No graphics yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
