<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    use RedirectsToSection;

    public function index()
    {
        return redirect()->route('admin.sections.edit', 'faq');
    }

    public function create()
    {
        return view('admin.faqs.form', ['faq' => new Faq]);
    }

    public function store(Request $request)
    {
        Faq::create($this->validated($request));

        return $this->backToSection('faqs', 'FAQ created.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $faq->update($this->validated($request));

        return $this->backToSection('faqs', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return $this->backToSection('faqs', 'FAQ deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'question_en' => ['required', 'string'],
            'question_mm' => ['nullable', 'string'],
            'answer_en' => ['required', 'string'],
            'answer_mm' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
