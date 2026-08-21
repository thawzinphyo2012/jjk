@extends('layouts.admin')

@section('page-title', 'Messages')

@section('content')
<div class="bg-[#141414] border border-cyan-400/20 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-cyan-400/10 text-gray-500">
            <tr>
                <th class="text-left px-6 py-3">Name</th>
                <th class="text-left px-6 py-3">Email</th>
                <th class="text-left px-6 py-3">Subject</th>
                <th class="text-left px-6 py-3">Date</th>
                <th class="text-right px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-cyan-400/10">
            @forelse($messages as $message)
                <tr class="hover:bg-white/5 {{ !$message->is_read ? 'bg-cyan-400/5' : '' }}">
                    <td class="px-6 py-4 text-white font-medium">
                        @if(!$message->is_read)<span class="inline-block w-2 h-2 rounded-full bg-cyan-400 mr-2"></span>@endif
                        {{ $message->name }}
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $message->email }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $message->subject ?? '—' }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $message->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.messages.show', $message) }}" class="text-cyan-400 hover:text-cyan-300">View</a>
                        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="inline" onsubmit="return confirm('Delete this message?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No messages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($messages->hasPages())
    <div class="mt-6">{{ $messages->links() }}</div>
@endif
@endsection
