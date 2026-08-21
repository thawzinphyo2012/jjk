@extends('layouts.admin')

@section('page-title', 'Edit: '.$config['label'])

@section('content')
<form method="POST" action="{{ route('admin.sections.update', $section) }}" enctype="multipart/form-data" class="max-w-4xl space-y-8">
    @csrf
    @method('PUT')

    <div class="p-4 rounded-xl bg-cyan-400/5 border border-cyan-400/20 text-sm text-gray-400">
        {{ $config['description'] }}
    </div>

    @if($translations->isNotEmpty())
        <div>
            <h2 class="font-display text-lg font-bold text-white mb-4">Text Content</h2>
            <div class="space-y-4">
                @foreach($translations as $translation)
                    @php
                        $rows = str_contains($translation->key, 'desc')
                            || str_contains($translation->key, '.p')
                            || str_contains($translation->key, 'note')
                            || str_contains($translation->key, 'message')
                            || str_contains($translation->key, 'quote')
                            || str_contains($translation->key, 'answer')
                            || str_contains($translation->key, 'form_subject')
                            ? 3 : 2;
                    @endphp
                    <div class="p-5 rounded-xl bg-[#141414] border border-cyan-400/15 space-y-4">
                        <div class="font-medium text-white">{{ \App\Support\SectionRegistry::labelForKey($translation->key) }}</div>
                        <div class="text-xs text-gray-600 font-mono">{{ $translation->key }}</div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1.5">English</label>
                            <textarea name="translations[{{ $translation->id }}][value_en]" rows="{{ $rows }}" required
                                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">{{ old('translations.'.$translation->id.'.value_en', $translation->value_en) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1.5">Myanmar</label>
                            <textarea name="translations[{{ $translation->id }}][value_mm]" rows="{{ $rows }}"
                                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">{{ old('translations.'.$translation->id.'.value_mm', $translation->value_mm) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(!empty($settingFields))
        <div>
            <h2 class="font-display text-lg font-bold text-white mb-4">Settings & Images</h2>
            <div class="space-y-4 p-5 rounded-xl bg-[#141414] border border-cyan-400/15">
                @foreach($settingFields as $field)
                    <div>
                        <label class="block text-sm text-gray-400 mb-1.5">{{ $field['label'] }}</label>
                        @if($field['type'] === 'image')
                            @php $val = $settings[$field['key']] ?? null; @endphp
                            @if($val)
                                <img src="{{ \App\Support\ImageUrl::admin($val) }}" alt="" class="h-20 rounded-lg mb-2 object-cover">
                            @endif
                            <input type="file" name="{{ $field['key'] }}" accept="image/*"
                                class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-cyan-400/20 file:text-cyan-400">
                        @elseif($field['type'] === 'textarea')
                            <textarea name="{{ $field['key'] }}" rows="4"
                                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50 font-mono text-sm">{{ old($field['key'], $settings[$field['key']] ?? '') }}</textarea>
                        @else
                            <input type="{{ $field['type'] }}" name="{{ $field['key'] }}" value="{{ old($field['key'], $settings[$field['key']] ?? '') }}"
                                class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white focus:outline-none focus:border-cyan-400/50">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="flex gap-3 pt-2">
        <button type="submit" class="px-6 py-2.5 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300">Save Section</button>
        <a href="{{ route('admin.sections.index') }}" class="px-6 py-2.5 border border-cyan-400/20 text-gray-400 rounded-lg hover:text-white">All Sections</a>
    </div>
</form>

@if($itemsConfig)
    <div class="max-w-4xl mt-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-lg font-bold text-white">{{ $itemsConfig['label'] }}</h2>
            <a href="{{ route('admin.'.$itemsConfig['route_prefix'].'.create') }}"
               class="px-4 py-2 bg-cyan-400/20 text-cyan-400 text-sm font-semibold rounded-lg hover:bg-cyan-400/30">
                + Add {{ \Illuminate\Support\Str::singular($itemsConfig['label']) }}
            </a>
        </div>

        <div class="space-y-3">
            @forelse($items as $item)
                <div class="flex items-center justify-between p-4 rounded-xl bg-[#141414] border border-cyan-400/15">
                    <div class="min-w-0 flex-1 pr-4">
                        <div class="font-medium text-white truncate">{{ $item->{$itemsConfig['title']} }}</div>
                        @if($itemsConfig['subtitle'] && $item->{$itemsConfig['subtitle']})
                            <div class="text-sm text-gray-500 truncate">{{ \Illuminate\Support\Str::limit($item->{$itemsConfig['subtitle']}, 80) }}</div>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        @if(isset($item->is_active))
                            <span class="text-xs {{ $item->is_active ? 'text-green-400' : 'text-gray-500' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span>
                        @endif
                        <a href="{{ route('admin.'.$itemsConfig['route_prefix'].'.edit', $item) }}" class="text-sm text-cyan-400 hover:text-cyan-300">Edit</a>
                        <form method="POST" action="{{ route('admin.'.$itemsConfig['route_prefix'].'.destroy', $item) }}" onsubmit="return confirm('Delete this item?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm text-red-400 hover:text-red-300">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm p-4 rounded-xl bg-[#141414] border border-cyan-400/15">No items yet. Click "Add" to create one.</p>
            @endforelse
        </div>
    </div>
@endif
@endsection
