@extends('layouts.admin')

@section('page-title', 'FAQ')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-400 text-sm">Manage frequently asked questions on the homepage.</p>
    <a href="{{ route('admin.faqs.create') }}" class="px-4 py-2 bg-cyan-400 text-black text-sm font-semibold rounded-lg hover:bg-cyan-300">Add FAQ</a>
</div>

<div class="space-y-3">
    @forelse($faqs as $faq)
        <div class="flex items-center justify-between p-4 rounded-xl bg-[#141414] border border-cyan-400/15">
            <div>
                <div class="font-medium text-white">{{ Str::limit($faq->question_en, 80) }}</div>
                <div class="text-sm text-gray-500">{{ Str::limit($faq->answer_en, 100) }}</div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs {{ $faq->is_active ? 'text-green-400' : 'text-gray-500' }}">{{ $faq->is_active ? 'Active' : 'Hidden' }}</span>
                <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-sm text-cyan-400 hover:text-cyan-300">Edit</a>
                <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Delete this FAQ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-400 hover:text-red-300">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-sm">No FAQ items yet.</p>
    @endforelse
</div>
@endsection
