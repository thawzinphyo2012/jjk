@extends('layouts.admin')

@section('page-title', $partner->exists ? 'Edit Partner' : 'Add Partner')

@section('content')
<form method="POST" action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}" enctype="multipart/form-data" class="max-w-lg space-y-5">
    @csrf
    @if($partner->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Partner Name</label>
        <input type="text" name="name" value="{{ old('name', $partner->name) }}" required class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Logo Image</label>
        @if($partner->image)
            <img src="{{ \App\Support\ImageUrl::admin($partner->image) }}" alt="" class="h-16 rounded-lg mb-2 object-contain bg-[#1a1a1a]">
        @endif
        <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-cyan-400/20 file:text-cyan-400">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1.5">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}" min="0" class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white">
    </div>
    <label class="flex items-center gap-2 text-sm text-gray-400">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $partner->is_active ?? true) ? 'checked' : '' }} class="rounded border-cyan-400/30 bg-[#1a1a1a] text-cyan-400">
        Active
    </label>
    <div class="flex gap-3">
        <button type="submit" class="px-6 py-2.5 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300">Save</button>
        <a href="{{ route('admin.sections.edit', 'partnership') }}" class="px-6 py-2.5 border border-cyan-400/20 text-gray-400 rounded-lg hover:text-white">Back to Section</a>
    </div>
</form>
@endsection
