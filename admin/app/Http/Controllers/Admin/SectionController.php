<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Translation;
use App\Support\HandlesUploads;
use App\Support\SectionRegistry;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        $sections = collect(SectionRegistry::all())
            ->sortBy('order')
            ->map(fn ($config, $key) => array_merge($config, ['key' => $key]));

        return view('admin.sections.index', compact('sections'));
    }

    public function edit(string $section)
    {
        $config = SectionRegistry::get($section);
        abort_unless($config, 404);

        $translations = Translation::query()
            ->whereIn('group', $config['translation_groups'])
            ->orderBy('key')
            ->get();

        $settings = SiteSetting::allKeyed();
        $settingFields = $config['settings'] ?? [];

        $items = [];
        $itemsConfig = $config['items'] ?? null;
        if ($itemsConfig) {
            $model = $itemsConfig['model'];
            $items = $model::orderBy('sort_order')->get();
        }

        return view('admin.sections.edit', [
            'section' => $section,
            'config' => $config,
            'translations' => $translations,
            'settings' => $settings,
            'settingFields' => $settingFields,
            'items' => $items,
            'itemsConfig' => $itemsConfig,
        ]);
    }

    public function update(Request $request, string $section)
    {
        $config = SectionRegistry::get($section);
        abort_unless($config, 404);

        if ($request->has('translations')) {
            $data = $request->validate([
                'translations' => ['required', 'array'],
                'translations.*.value_en' => ['required', 'string'],
                'translations.*.value_mm' => ['nullable', 'string'],
            ]);

            foreach ($data['translations'] as $id => $values) {
                Translation::where('id', $id)
                    ->whereIn('group', $config['translation_groups'])
                    ->update([
                        'value_en' => $values['value_en'],
                        'value_mm' => $values['value_mm'] ?? null,
                    ]);
            }
        }

        $pairs = [];
        foreach ($config['settings'] ?? [] as $field) {
            $key = $field['key'];

            if ($field['type'] === 'image') {
                $pairs[$key] = $this->storeUpload($request, $key, SiteSetting::get($key));
            } elseif ($request->has($key)) {
                $pairs[$key] = $request->input($key);
            }
        }

        if ($pairs) {
            SiteSetting::setMany($pairs);
        }

        return redirect()
            ->route('admin.sections.edit', $section)
            ->with('success', $config['label'].' updated successfully.');
    }
}
