<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Graphic;
use App\Support\ImageUrl;
use App\Models\Partner;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\Translation;

class SiteController extends Controller
{
    public function __invoke()
    {
        $flat = ['en' => [], 'mm' => []];
        foreach (Translation::all() as $t) {
            $flat['en'][$t->key] = $t->value_en;
            $flat['mm'][$t->key] = $t->value_mm ?? $t->value_en;
        }

        $settings = SiteSetting::allKeyed();
        $formOptions = json_decode($settings['form_subject_options'] ?? '[]', true) ?: [];

        return response()->json([
            'translations' => $flat,
            'settings' => $settings,
            'form_options' => $formOptions,
            'services' => Service::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn ($s) => $this->formatService($s)),
            'graphics' => Graphic::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn ($g) => $this->formatGraphic($g)),
            'testimonials' => Testimonial::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn ($t) => $this->formatTestimonial($t)),
            'partners' => Partner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn ($p) => $this->formatPartner($p)),
            'faqs' => Faq::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn ($f) => $this->formatFaq($f)),
        ]);
    }

    private function imageUrl(?string $path): ?string
    {
        return ImageUrl::frontend($path);
    }

    private function formatService(Service $s): array
    {
        return [
            'id' => $s->id,
            'title_en' => $s->title,
            'title_mm' => $s->title_mm,
            'description_en' => $s->description,
            'description_mm' => $s->description_mm,
            'icon_color' => $s->icon_color,
            'image' => $this->imageUrl($s->image),
        ];
    }

    private function formatGraphic(Graphic $g): array
    {
        return [
            'id' => $g->id,
            'title_en' => $g->title,
            'title_mm' => $g->title_mm,
            'category_en' => $g->category,
            'category_mm' => $g->category_mm,
            'description_en' => $g->description,
            'description_mm' => $g->description_mm,
            'gradient' => $g->gradient,
            'image' => $this->imageUrl($g->image),
        ];
    }

    private function formatTestimonial(Testimonial $t): array
    {
        return [
            'id' => $t->id,
            'quote_en' => $t->quote_en,
            'quote_mm' => $t->quote_mm,
            'name' => $t->name,
            'role_en' => $t->role_en,
            'role_mm' => $t->role_mm,
            'avatar' => $this->imageUrl($t->avatar),
            'rating' => $t->rating,
        ];
    }

    private function formatPartner(Partner $p): array
    {
        return [
            'id' => $p->id,
            'name' => $p->name,
            'image' => $this->imageUrl($p->image),
        ];
    }

    private function formatFaq(Faq $f): array
    {
        return [
            'id' => $f->id,
            'question_en' => $f->question_en,
            'question_mm' => $f->question_mm,
            'answer_en' => $f->answer_en,
            'answer_mm' => $f->answer_mm,
        ];
    }
}
