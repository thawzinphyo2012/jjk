<?php

namespace App\Support;

class SectionRegistry
{
    public static function all(): array
    {
        return [
            'nav' => [
                'label' => 'Navigation & Brand',
                'description' => 'Menu links, logo monogram and brand name',
                'order' => 1,
                'translation_groups' => ['nav'],
                'settings' => [
                    ['key' => 'brand_logo', 'label' => 'Logo Monogram (e.g. BT)', 'type' => 'text'],
                    ['key' => 'brand_name', 'label' => 'Brand Name (HTML allowed)', 'type' => 'text'],
                ],
            ],
            'hero' => [
                'label' => 'Hero Section',
                'description' => 'Homepage hero headline, CTAs, stats and image',
                'order' => 2,
                'translation_groups' => ['hero'],
                'settings' => [
                    ['key' => 'hero_stat1_count', 'label' => 'Stat 1 Number', 'type' => 'text'],
                    ['key' => 'hero_stat1_suffix', 'label' => 'Stat 1 Suffix', 'type' => 'text'],
                    ['key' => 'hero_stat2_count', 'label' => 'Stat 2 Number', 'type' => 'text'],
                    ['key' => 'hero_stat2_suffix', 'label' => 'Stat 2 Suffix', 'type' => 'text'],
                    ['key' => 'hero_stat2_decimals', 'label' => 'Stat 2 Decimals', 'type' => 'number'],
                    ['key' => 'hero_stat3_count', 'label' => 'Stat 3 Number', 'type' => 'text'],
                    ['key' => 'hero_stat3_suffix', 'label' => 'Stat 3 Suffix', 'type' => 'text'],
                    ['key' => 'hero_image', 'label' => 'Hero Image', 'type' => 'image'],
                ],
            ],
            'about' => [
                'label' => 'About Section',
                'description' => 'About text, stats, progress bars, terminal widget and icons',
                'order' => 3,
                'translation_groups' => ['about', 'terminal'],
                'settings' => [
                    ['key' => 'about_founded', 'label' => 'Founded Year', 'type' => 'text'],
                    ['key' => 'about_engineers', 'label' => 'Engineers Count', 'type' => 'text'],
                    ['key' => 'about_countries', 'label' => 'Countries Count', 'type' => 'text'],
                    ['key' => 'about_support', 'label' => 'Support', 'type' => 'text'],
                    ['key' => 'about_ai', 'label' => 'AI Processing %', 'type' => 'number'],
                    ['key' => 'about_network', 'label' => 'Network Load %', 'type' => 'number'],
                    ['key' => 'about_security', 'label' => 'Security Score %', 'type' => 'number'],
                    ['key' => 'about_image', 'label' => 'About Background Image', 'type' => 'image'],
                    ['key' => 'terminal_systems', 'label' => 'Terminal — Systems Status', 'type' => 'text'],
                    ['key' => 'terminal_uptime', 'label' => 'Terminal — Uptime', 'type' => 'text'],
                    ['key' => 'terminal_nodes', 'label' => 'Terminal — Active Nodes', 'type' => 'text'],
                    ['key' => 'terminal_threat', 'label' => 'Terminal — Threat Level', 'type' => 'text'],
                    ['key' => 'icon_about_founded', 'label' => 'Founded Icon', 'type' => 'image'],
                    ['key' => 'icon_about_engineers', 'label' => 'Engineers Icon', 'type' => 'image'],
                    ['key' => 'icon_about_countries', 'label' => 'Countries Icon', 'type' => 'image'],
                    ['key' => 'icon_about_support', 'label' => 'Support Icon', 'type' => 'image'],
                ],
            ],
            'service' => [
                'label' => 'Service Section',
                'description' => 'Service section header and service cards',
                'order' => 4,
                'translation_groups' => ['service'],
                'settings' => [],
                'items' => [
                    'label' => 'Service Cards',
                    'route_prefix' => 'services',
                    'model' => \App\Models\Service::class,
                    'title' => 'title',
                    'subtitle' => 'description',
                ],
            ],
            'testimonial' => [
                'label' => 'Testimonial Section',
                'description' => 'Testimonial section header and client reviews',
                'order' => 5,
                'translation_groups' => ['testimonial'],
                'settings' => [],
                'items' => [
                    'label' => 'Testimonials',
                    'route_prefix' => 'testimonials',
                    'model' => \App\Models\Testimonial::class,
                    'title' => 'name',
                    'subtitle' => 'role_en',
                ],
            ],
            'partnership' => [
                'label' => 'Partnership Section',
                'description' => 'Partnership header, CTA and partner logos',
                'order' => 6,
                'translation_groups' => ['partnership'],
                'settings' => [],
                'items' => [
                    'label' => 'Partners',
                    'route_prefix' => 'partners',
                    'model' => \App\Models\Partner::class,
                    'title' => 'name',
                    'subtitle' => null,
                ],
            ],
            'graphic' => [
                'label' => 'Graphic Section',
                'description' => 'Graphic section header and portfolio items',
                'order' => 7,
                'translation_groups' => ['graphic'],
                'settings' => [],
                'items' => [
                    'label' => 'Graphic Items',
                    'route_prefix' => 'graphics',
                    'model' => \App\Models\Graphic::class,
                    'title' => 'title',
                    'subtitle' => 'category',
                ],
            ],
            'faq' => [
                'label' => 'FAQ Section',
                'description' => 'FAQ section header and question/answer items',
                'order' => 8,
                'translation_groups' => ['faq'],
                'settings' => [],
                'items' => [
                    'label' => 'FAQ Items',
                    'route_prefix' => 'faqs',
                    'model' => \App\Models\Faq::class,
                    'title' => 'question_en',
                    'subtitle' => null,
                ],
            ],
            'footer' => [
                'label' => 'Footer',
                'description' => 'Footer text and link URLs',
                'order' => 9,
                'translation_groups' => ['footer'],
                'settings' => [
                    ['key' => 'footer_privacy_url', 'label' => 'Privacy Policy URL', 'type' => 'url'],
                    ['key' => 'footer_terms_url', 'label' => 'Terms URL', 'type' => 'url'],
                    ['key' => 'admin_panel_url', 'label' => 'Admin Panel URL', 'type' => 'url'],
                ],
            ],
            'contact' => [
                'label' => 'Contact Page',
                'description' => 'Contact info, form labels, social links and icons',
                'order' => 10,
                'translation_groups' => ['contact', 'form'],
                'settings' => [
                    ['key' => 'contact_email', 'label' => 'Email Address', 'type' => 'email'],
                    ['key' => 'contact_phone', 'label' => 'Phone Number', 'type' => 'text'],
                    ['key' => 'social_linkedin', 'label' => 'LinkedIn URL', 'type' => 'url'],
                    ['key' => 'social_facebook', 'label' => 'Facebook URL', 'type' => 'url'],
                    ['key' => 'social_twitter', 'label' => 'Twitter/X URL', 'type' => 'url'],
                    ['key' => 'contact_office_image', 'label' => 'Office Image', 'type' => 'image'],
                    ['key' => 'icon_email', 'label' => 'Email Icon', 'type' => 'image'],
                    ['key' => 'icon_phone', 'label' => 'Phone Icon', 'type' => 'image'],
                    ['key' => 'form_subject_options', 'label' => 'Form Subject Options (JSON)', 'type' => 'textarea'],
                ],
            ],
            'general' => [
                'label' => 'SEO & General',
                'description' => 'Page titles, meta descriptions and language toggle',
                'order' => 11,
                'translation_groups' => ['page', 'lang'],
                'settings' => [
                    ['key' => 'meta_description_home', 'label' => 'Home Meta Description', 'type' => 'textarea'],
                    ['key' => 'meta_description_contact', 'label' => 'Contact Meta Description', 'type' => 'textarea'],
                ],
            ],
        ];
    }

    public static function get(string $key): ?array
    {
        return self::all()[$key] ?? null;
    }

    public static function labelForKey(string $key): string
    {
        $parts = explode('.', $key);
        $name = end($parts);

        return ucwords(str_replace(['_', '-'], ' ', $name));
    }

    public static function sectionForRoutePrefix(string $prefix): ?string
    {
        foreach (self::all() as $key => $config) {
            if (($config['items']['route_prefix'] ?? null) === $prefix) {
                return $key;
            }
        }

        return null;
    }
}
