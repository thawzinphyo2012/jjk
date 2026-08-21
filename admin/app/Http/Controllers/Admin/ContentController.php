<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    private const GROUPS = [
        'nav' => 'Navigation',
        'brand' => 'Brand & Logo',
        'hero' => 'Hero Section',
        'about' => 'About Section',
        'terminal' => 'Terminal Widget',
        'service' => 'Service Section',
        'testimonial' => 'Testimonial Section',
        'partnership' => 'Partnership Section',
        'graphic' => 'Graphic Section',
        'faq' => 'FAQ Section Header',
        'footer' => 'Footer',
        'contact' => 'Contact Page',
        'form' => 'Forms & Messages',
        'page' => 'Page Titles',
        'lang' => 'Language',
    ];

    public function index()
    {
        $groups = collect(self::GROUPS)->map(function ($label, $key) {
            return [
                'key' => $key,
                'label' => $label,
                'count' => Translation::where('group', $key)->count(),
            ];
        });

        return view('admin.content.index', compact('groups'));
    }

    public function edit(string $group)
    {
        abort_unless(isset(self::GROUPS[$group]), 404);

        $translations = Translation::where('group', $group)->orderBy('key')->get();
        $label = self::GROUPS[$group];

        return view('admin.content.edit', compact('group', 'translations', 'label'));
    }

    public function update(Request $request, string $group)
    {
        abort_unless(isset(self::GROUPS[$group]), 404);

        $data = $request->validate([
            'translations' => ['required', 'array'],
            'translations.*.value_en' => ['required', 'string'],
            'translations.*.value_mm' => ['nullable', 'string'],
        ]);

        foreach ($data['translations'] as $id => $values) {
            Translation::where('id', $id)->where('group', $group)->update([
                'value_en' => $values['value_en'],
                'value_mm' => $values['value_mm'] ?? null,
            ]);
        }

        return redirect()->route('admin.sections.index')->with('success', self::GROUPS[$group].' content updated.');
    }
}
