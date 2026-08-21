@extends('layouts.admin')

@section('page-title', 'Testimonials')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-400 text-sm">Manage client testimonials shown on the homepage.</p>
    <a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2 bg-cyan-400 text-black text-sm font-semibold rounded-lg hover:bg-cyan-300">Add Testimonial</a>
</div>

<div class="space-y-3">
    @forelse($testimonials as $t)
        <div class="flex items-center justify-between p-4 rounded-xl bg-[#141414] border border-cyan-400/15">
            <div>
                <div class="font-medium text-white">{{ $t->name }}</div>
                <div class="text-sm text-gray-500">{{ Str::limit($t->quote_en, 80) }}</div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs {{ $t->is_active ? 'text-green-400' : 'text-gray-500' }}">{{ $t->is_active ? 'Active' : 'Hidden' }}</span>
                <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-sm text-cyan-400 hover:text-cyan-300">Edit</a>
                <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('Delete this testimonial?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-400 hover:text-red-300">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-sm">No testimonials yet.</p>
    @endforelse
</div>
@endsection
