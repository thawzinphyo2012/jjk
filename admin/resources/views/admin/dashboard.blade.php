@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-[#141414] border border-cyan-400/20 rounded-xl p-6">
        <div class="text-gray-500 text-sm mb-1">Services</div>
        <div class="font-display text-3xl font-bold text-cyan-400">{{ $stats['services'] }}</div>
    </div>
    <div class="bg-[#141414] border border-cyan-400/20 rounded-xl p-6">
        <div class="text-gray-500 text-sm mb-1">Graphics</div>
        <div class="font-display text-3xl font-bold text-violet-400">{{ $stats['graphics'] }}</div>
    </div>
    <div class="bg-[#141414] border border-cyan-400/20 rounded-xl p-6">
        <div class="text-gray-500 text-sm mb-1">Messages</div>
        <div class="font-display text-3xl font-bold text-white">{{ $stats['messages'] }}</div>
    </div>
    <div class="bg-[#141414] border border-cyan-400/20 rounded-xl p-6">
        <div class="text-gray-500 text-sm mb-1">Unread</div>
        <div class="font-display text-3xl font-bold text-orange-400">{{ $stats['unread'] }}</div>
    </div>
</div>

<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold text-white">Edit Website Sections</h2>
        <a href="{{ route('admin.sections.index') }}" class="text-sm text-cyan-400 hover:text-cyan-300">View all →</a>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach(collect(\App\Support\SectionRegistry::all())->sortBy('order') as $key => $sec)
            <a href="{{ route('admin.sections.edit', $key) }}" class="p-4 rounded-xl bg-[#141414] border border-cyan-400/15 hover:border-cyan-400/40 transition-colors">
                <div class="text-sm font-medium text-white">{{ $sec['label'] }}</div>
                <div class="text-xs text-gray-500 mt-1">{{ $sec['description'] }}</div>
            </a>
        @endforeach
    </div>
</div>

<div class="bg-[#141414] border border-cyan-400/20 rounded-xl">
    <div class="px-6 py-4 border-b border-cyan-400/10 flex items-center justify-between">
        <h2 class="font-semibold text-white">Recent Messages</h2>
        <a href="{{ route('admin.messages.index') }}" class="text-sm text-cyan-400 hover:text-cyan-300">View all →</a>
    </div>
    <div class="divide-y divide-cyan-400/10">
        @forelse($recentMessages as $msg)
            <a href="{{ route('admin.messages.show', $msg) }}" class="flex items-center justify-between px-6 py-4 hover:bg-white/5 transition-colors">
                <div>
                    <div class="text-white text-sm font-medium {{ !$msg->is_read ? 'text-cyan-400' : '' }}">{{ $msg->name }}</div>
                    <div class="text-gray-500 text-xs">{{ $msg->email }} · {{ $msg->created_at->diffForHumans() }}</div>
                </div>
                @if(!$msg->is_read)
                    <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                @endif
            </a>
        @empty
            <div class="px-6 py-8 text-center text-gray-500 text-sm">No messages yet.</div>
        @endforelse
    </div>
</div>
@endsection
