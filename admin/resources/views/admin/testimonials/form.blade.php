@extends('layouts.admin')

@section('page-title', $testimonial->exists ? 'Edit Testimonial' : 'Add Testimonial')

@section('content')
<form method="POST" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-5">
    @csrf
    @if($testimonial->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Quote (English)</label>
        <textarea name="quote_en" rows="4" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">{{ old('quote_en', $testimonial->quote_en) }}</textarea>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Quote (Myanmar)</label>
        <textarea name="quote_mm" rows="4" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">{{ old('quote_mm', $testimonial->quote_mm) }}</textarea>
    </div>
    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Name</label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Rating (1-5)</label>
            <input type="number" name="rating" value="{{ old('rating', $testimonial->rating ?? 5) }}" min="1" max="5" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
        </div>
    </div>
    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Role (English)</label>
            <input type="text" name="role_en" value="{{ old('role_en', $testimonial->role_en) }}" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Role (Myanmar)</label>
            <input type="text" name="role_mm" value="{{ old('role_mm', $testimonial->role_mm) }}" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
        </div>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Avatar</label>
        @if($testimonial->avatar)
            <img src="{{ \App\Support\ImageUrl::admin($testimonial->avatar) }}" alt="" class="w-12 h-12 rounded-full mb-2 object-cover">
        @endif
        <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-cyan-400/20 file:text-cyan-400">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" min="0" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
    </div>
    <label class="flex items-center gap-2 text-sm text-gray-400">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }} class="rounded border-cyan-400/30 bg-[#1a1a1a] text-cyan-400">
        Active
    </label>
    <div class="flex gap-3">
        <button type="submit" class="px-6 py-2.5 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300">Save</button>
        <a href="{{ route('admin.sections.edit', 'testimonial') }}" class="px-6 py-2.5 border border-cyan-400/20 text-gray-400 rounded-lg hover:text-white">Back to Section</a>
    </div>
</form>
@endsection
