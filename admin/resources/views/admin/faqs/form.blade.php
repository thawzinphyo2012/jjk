@extends('layouts.admin')

@section('page-title', $faq->exists ? 'Edit FAQ' : 'Add FAQ')

@section('content')
<form method="POST" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" class="max-w-2xl space-y-5">
    @csrf
    @if($faq->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Question (English)</label>
        <input type="text" name="question_en" value="{{ old('question_en', $faq->question_en) }}" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Question (Myanmar)</label>
        <input type="text" name="question_mm" value="{{ old('question_mm', $faq->question_mm) }}" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Answer (English)</label>
        <textarea name="answer_en" rows="4" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">{{ old('answer_en', $faq->answer_en) }}</textarea>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Answer (Myanmar)</label>
        <textarea name="answer_mm" rows="4" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">{{ old('answer_mm', $faq->answer_mm) }}</textarea>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" min="0" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
    </div>
    <label class="flex items-center gap-2 text-sm text-gray-400">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }} class="rounded border-cyan-400/30 bg-[#1a1a1a] text-cyan-400">
        Active
    </label>
    <div class="flex gap-3">
        <button type="submit" class="px-6 py-2.5 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300">Save</button>
        <a href="{{ route('admin.sections.edit', 'faq') }}" class="px-6 py-2.5 border border-cyan-400/20 text-gray-400 rounded-lg hover:text-white">Back to Section</a>
    </div>
</form>
@endsection
