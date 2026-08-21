<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use HandlesUploads, RedirectsToSection;

    public function index()
    {
        return redirect()->route('admin.sections.edit', 'testimonial');
    }

    public function create()
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial]);
    }

    public function store(Request $request)
    {
        Testimonial::create($this->validated($request));

        return $this->backToSection('testimonials', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->validated($request, $testimonial));

        return $this->backToSection('testimonials', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->deleteUpload($testimonial->avatar);
        $testimonial->delete();

        return $this->backToSection('testimonials', 'Testimonial deleted.');
    }

    private function validated(Request $request, ?Testimonial $existing = null): array
    {
        $data = $request->validate([
            'quote_en' => ['required', 'string'],
            'quote_mm' => ['nullable', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'role_en' => ['required', 'string', 'max:255'],
            'role_mm' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['avatar'] = $this->storeUpload($request, 'avatar', $existing?->avatar);
        $data['is_active'] = $request->boolean('is_active');
        $data['rating'] = $data['rating'] ?? 5;

        return $data;
    }
}
