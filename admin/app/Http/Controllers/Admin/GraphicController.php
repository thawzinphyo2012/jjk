<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Graphic;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;

class GraphicController extends Controller
{
    use HandlesUploads, RedirectsToSection;

    public function index()
    {
        return redirect()->route('admin.sections.edit', 'graphic');
    }

    public function create()
    {
        return view('admin.graphics.form', ['graphic' => new Graphic]);
    }

    public function store(Request $request)
    {
        Graphic::create($this->validated($request));

        return $this->backToSection('graphics', 'Graphic created successfully.');
    }

    public function edit(Graphic $graphic)
    {
        return view('admin.graphics.form', compact('graphic'));
    }

    public function update(Request $request, Graphic $graphic)
    {
        $graphic->update($this->validated($request, $graphic));

        return $this->backToSection('graphics', 'Graphic updated successfully.');
    }

    public function destroy(Graphic $graphic)
    {
        $this->deleteUpload($graphic->image);
        $graphic->delete();

        return $this->backToSection('graphics', 'Graphic deleted successfully.');
    }

    private function validated(Request $request, ?Graphic $existing = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_mm' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'category_mm' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'description_mm' => ['nullable', 'string'],
            'gradient' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['image'] = $this->storeUpload($request, 'image', $existing?->image);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
