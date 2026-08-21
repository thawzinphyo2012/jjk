@extends('layouts.admin')

@section('page-title', 'Message from ' . $message->name)

@section('content')
<div class="max-w-2xl">
    <div class="bg-[#141414] border border-cyan-400/20 rounded-xl p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-gray-500 mb-1">Name</div>
                <div class="text-white">{{ $message->name }}</div>
            </div>
            <div>
                <div class="text-gray-500 mb-1">Email</div>
                <a href="mailto:{{ $message->email }}" class="text-cyan-400">{{ $message->email }}</a>
            </div>
            @if($message->phone)
                <div>
                    <div class="text-gray-500 mb-1">Phone</div>
                    <div class="text-white">{{ $message->phone }}</div>
                </div>
            @endif
            @if($message->subject)
                <div>
                    <div class="text-gray-500 mb-1">Subject</div>
                    <div class="text-white">{{ $message->subject }}</div>
                </div>
            @endif
            <div>
                <div class="text-gray-500 mb-1">Received</div>
                <div class="text-gray-400">{{ $message->created_at->format('F d, Y H:i') }}</div>
            </div>
        </div>

        <div class="border-t border-cyan-400/10 pt-4">
            <div class="text-gray-500 text-sm mb-2">Message</div>
            <div class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
        </div>
    </div>

    <div class="flex gap-3 mt-6">
        <a href="{{ route('admin.messages.index') }}" class="px-6 py-2.5 border border-cyan-400/20 text-gray-400 rounded-lg hover:text-white">← Back</a>
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-6 py-2.5 bg-red-400/10 border border-red-400/30 text-red-400 rounded-lg hover:bg-red-400/20">Delete</button>
        </form>
    </div>
</div>
@endsection
