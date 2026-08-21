@extends('layouts.admin')

@section('page-title', $graphic->exists ? 'Edit Graphic' : 'Add Graphic')

@section('content')
<form method="POST" action="{{ $graphic->exists ? route('admin.graphics.update', $graphic) : route('admin.graphics.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-5">
    @csrf
    @if($graphic->exists) @method('PUT') @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Title (English)</label>
            <input type="text" name="title" value="{{ old('title', $graphic->title) }}" required
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Title (Myanmar)</label>
            <input type="text" name="title_mm" value="{{ old('title_mm', $graphic->title_mm) }}"
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Category (English)</label>
            <input type="text" name="category" value="{{ old('category', $graphic->category) }}" required
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Category (Myanmar)</label>
            <input type="text" name="category_mm" value="{{ old('category_mm', $graphic->category_mm) }}"
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
    </div>

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Description (English)</label>
        <textarea name="description" rows="4" required
            class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">{{ old('description', $graphic->description) }}</textarea>
    </div>

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Description (Myanmar)</label>
        <textarea name="description_mm" rows="4"
            class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">{{ old('description_mm', $graphic->description_mm) }}</textarea>
    </div>

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Image</label>
        @if($graphic->image)
            <img src="{{ \App\Support\ImageUrl::admin($graphic->image) }}" alt="" class="h-24 rounded-lg mb-2 object-cover">
        @endif
        <input type="file" name="image" accept="image/*"
            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-cyan-400/20 file:text-cyan-400">
    </div>

    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Gradient Class</label>
            <input type="text" name="gradient" value="{{ old('gradient', $graphic->gradient ?? 'from-cyan-400/20 to-violet-600/20') }}"
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $graphic->sort_order ?? 0) }}" min="0"
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm text-gray-400">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $graphic->is_active ?? true) ? 'checked' : '' }}
            class="rounded border-cyan-400/30 bg-[#1a1a1a] text-cyan-400">
        Active
    </label>

    <div class="flex gap-3">
        <button type="submit" class="px-6 py-2.5 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300">Save</button>
        <a href="{{ route('admin.sections.edit', 'graphic') }}" class="px-6 py-2.5 border border-cyan-400/20 text-gray-400 rounded-lg hover:text-white">Back to Section</a>
    </div>
</form>
@endsection
