<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    use HandlesUploads, RedirectsToSection;

    public function index()
    {
        return redirect()->route('admin.sections.edit', 'partnership');
    }

    public function create()
    {
        return view('admin.partners.form', ['partner' => new Partner]);
    }

    public function store(Request $request)
    {
        Partner::create($this->validated($request));

        return $this->backToSection('partners', 'Partner created.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $partner->update($this->validated($request, $partner));

        return $this->backToSection('partners', 'Partner updated.');
    }

    public function destroy(Partner $partner)
    {
        $this->deleteUpload($partner->image);
        $partner->delete();

        return $this->backToSection('partners', 'Partner deleted.');
    }

    private function validated(Request $request, ?Partner $existing = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['image'] = $this->storeUpload($request, 'image', $existing?->image);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
