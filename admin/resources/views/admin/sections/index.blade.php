@extends('layouts.admin')

@section('page-title', 'Website Sections')

@section('content')
<p class="text-gray-400 text-sm mb-6">Each section matches the website layout. Open a section to edit its text, images, numbers and items in one place.</p>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($sections as $section)
        <a href="{{ route('admin.sections.edit', $section['key']) }}"
           class="block p-5 rounded-xl bg-[#141414] border border-cyan-400/15 hover:border-cyan-400/40 transition-colors group">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="font-semibold text-white group-hover:text-cyan-400 transition-colors">{{ $section['label'] }}</h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">{{ $section['description'] }}</p>
                </div>
                <span class="text-cyan-400/50 group-hover:text-cyan-400 text-lg">→</span>
            </div>
            @if(!empty($section['items']))
                <span class="inline-block mt-3 text-xs px-2 py-1 rounded bg-cyan-400/10 text-cyan-400">Includes items</span>
            @endif
        </a>
    @endforeach
</div>
@endsection
