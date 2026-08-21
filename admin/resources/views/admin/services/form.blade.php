@extends('layouts.admin')

@section('page-title', $service->exists ? 'Edit Service' : 'Add Service')

@section('content')
<form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-5">
    @csrf
    @if($service->exists) @method('PUT') @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Title (English)</label>
            <input type="text" name="title" value="{{ old('title', $service->title) }}" required
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Title (Myanmar)</label>
            <input type="text" name="title_mm" value="{{ old('title_mm', $service->title_mm) }}"
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
    </div>

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Description (English)</label>
        <textarea name="description" rows="4" required
            class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">{{ old('description', $service->description) }}</textarea>
    </div>

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Description (Myanmar)</label>
        <textarea name="description_mm" rows="4"
            class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">{{ old('description_mm', $service->description_mm) }}</textarea>
    </div>

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Image</label>
        @if($service->image)
            <img src="{{ \App\Support\ImageUrl::admin($service->image) }}" alt="" class="h-24 rounded-lg mb-2 object-cover">
        @endif
        <input type="file" name="image" accept="image/*"
            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-cyan-400/20 file:text-cyan-400">
    </div>

    <div class="grid grid-cols-2 gap-5">
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Icon Color</label>
            <select name="icon_color" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
                @foreach(['cyan','violet','green','orange','pink','blue'] as $color)
                    <option value="{{ $color }}" {{ old('icon_color', $service->icon_color) === $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1.5">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" min="0"
                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm text-gray-400">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}
            class="rounded border-cyan-400/30 bg-[#1a1a1a] text-cyan-400">
        Active
    </label>

    <div class="flex gap-3">
        <button type="submit" class="px-6 py-2.5 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300">Save</button>
        <a href="{{ route('admin.sections.edit', 'service') }}" class="px-6 py-2.5 border border-cyan-400/20 text-gray-400 rounded-lg hover:text-white">Back to Section</a>
    </div>
</form>
@endsection
