<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HandlesUploads, RedirectsToSection;

    public function index()
    {
        return redirect()->route('admin.sections.edit', 'service');
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service]);
    }

    public function store(Request $request)
    {
        Service::create($this->validated($request));

        return $this->backToSection('services', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validated($request, $service));

        return $this->backToSection('services', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $this->deleteUpload($service->image);
        $service->delete();

        return $this->backToSection('services', 'Service deleted successfully.');
    }

    private function validated(Request $request, ?Service $existing = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_mm' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'description_mm' => ['nullable', 'string'],
            'icon_color' => ['required', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['image'] = $this->storeUpload($request, 'image', $existing?->image);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
