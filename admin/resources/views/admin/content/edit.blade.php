@extends('layouts.admin')

@section('page-title', 'Edit: '.$label)

@section('content')
<form method="POST" action="{{ route('admin.content.update', $group) }}" class="max-w-4xl space-y-6">
    @csrf
    @method('PUT')

    @foreach($translations as $translation)
        <div class="p-5 rounded-xl bg-[#141414] border border-cyan-400/15 space-y-4">
            <div class="text-xs text-cyan-400 font-mono">{{ $translation->key }}</div>
            <div>
                <label class="block text-sm text-gray-400 mb-1.5">English</label>
                <textarea name="translations[{{ $translation->id }}][value_en]" rows="{{ str_contains($translation->key, 'desc') || str_contains($translation->key, '.p') ? 3 : 2 }}" required
                    class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">{{ old('translations.'.$translation->id.'.value_en', $translation->value_en) }}</textarea>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1.5">Myanmar</label>
                <textarea name="translations[{{ $translation->id }}][value_mm]" rows="{{ str_contains($translation->key, 'desc') || str_contains($translation->key, '.p') ? 3 : 2 }}"
                    class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">{{ old('translations.'.$translation->id.'.value_mm', $translation->value_mm) }}</textarea>
            </div>
        </div>
    @endforeach

    <div class="flex gap-3">
        <button type="submit" class="px-6 py-2.5 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300">Save Changes</button>
        <a href="{{ route('admin.sections.index') }}" class="px-6 py-2.5 border border-cyan-400/20 text-gray-400 rounded-lg hover:text-white">Back</a>
    </div>
</form>
@endsection
