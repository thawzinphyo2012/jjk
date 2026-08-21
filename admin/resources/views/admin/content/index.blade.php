@extends('layouts.admin')

@section('page-title', 'Site Content')

@section('content')
<p class="text-gray-400 text-sm mb-6">Edit all website text in English and Myanmar. Services, graphics, testimonials and partners are managed separately.</p>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($groups as $group)
        <a href="{{ route('admin.content.edit', $group['key']) }}" class="block p-5 rounded-xl bg-[#141414] border border-cyan-400/15 hover:border-cyan-400/40 transition-colors">
            <h3 class="font-semibold text-white">{{ $group['label'] }}</h3>
            <p class="text-xs text-gray-500 mt-1">{{ $group['count'] }} text fields</p>
        </a>
    @endforeach
</div>
@endsection
