@extends('layouts.admin')

@section('page-title', 'Site Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="max-w-3xl space-y-8">
    @csrf
    @method('PUT')

    @foreach($sections as $section => $fields)
        <div>
            <h2 class="font-display text-lg font-bold text-white mb-4 capitalize">{{ $section }}</h2>
            <div class="space-y-4 p-5 rounded-xl bg-[#141414] border border-cyan-400/15">
                @foreach($fields as $field)
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
    @endforeach

    <button type="submit" class="px-6 py-2.5 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300">Save Settings</button>
</form>
@endsection
