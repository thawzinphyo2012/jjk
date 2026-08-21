@extends('layouts.admin')

@section('page-title', 'Services')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-400 text-sm">Manage website services</p>
    <a href="{{ route('admin.services.create') }}" class="px-4 py-2 bg-cyan-400 text-black text-sm font-semibold rounded-lg hover:bg-cyan-300">+ Add Service</a>
</div>

<div class="bg-[#141414] border border-cyan-400/20 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-cyan-400/10 text-gray-500">
            <tr>
                <th class="text-left px-6 py-3">Title</th>
                <th class="text-left px-6 py-3">Color</th>
                <th class="text-left px-6 py-3">Order</th>
                <th class="text-left px-6 py-3">Status</th>
                <th class="text-right px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-cyan-400/10">
            @forelse($services as $service)
                <tr class="hover:bg-white/5">
                    <td class="px-6 py-4 text-white font-medium">{{ $service->title }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 rounded text-xs bg-{{ $service->icon_color }}-400/10 text-{{ $service->icon_color }}-400">{{ $service->icon_color }}</span></td>
                    <td class="px-6 py-4 text-gray-400">{{ $service->sort_order }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs {{ $service->is_active ? 'bg-green-400/10 text-green-400' : 'bg-red-400/10 text-red-400' }}">
                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-cyan-400 hover:text-cyan-300">Edit</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline" onsubmit="return confirm('Delete this service?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No services yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
