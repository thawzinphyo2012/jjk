<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use HandlesUploads;

    private const FIELDS = [
        'brand' => [
            ['key' => 'brand_logo', 'label' => 'Logo Monogram (e.g. BT)', 'type' => 'text'],
            ['key' => 'brand_name', 'label' => 'Brand Name HTML (e.g. BLACK<span class="text-cyan-400">TECH</span>)', 'type' => 'text'],
        ],
        'seo' => [
            ['key' => 'meta_description_home', 'label' => 'Home Meta Description', 'type' => 'textarea'],
            ['key' => 'meta_description_contact', 'label' => 'Contact Meta Description', 'type' => 'textarea'],
        ],
        'hero' => [
            ['key' => 'hero_stat1_count', 'label' => 'Stat 1 Number', 'type' => 'text'],
            ['key' => 'hero_stat1_suffix', 'label' => 'Stat 1 Suffix', 'type' => 'text'],
            ['key' => 'hero_stat2_count', 'label' => 'Stat 2 Number', 'type' => 'text'],
            ['key' => 'hero_stat2_suffix', 'label' => 'Stat 2 Suffix', 'type' => 'text'],
            ['key' => 'hero_stat2_decimals', 'label' => 'Stat 2 Decimals', 'type' => 'number'],
            ['key' => 'hero_stat3_count', 'label' => 'Stat 3 Number', 'type' => 'text'],
            ['key' => 'hero_stat3_suffix', 'label' => 'Stat 3 Suffix', 'type' => 'text'],
            ['key' => 'hero_image', 'label' => 'Hero Image', 'type' => 'image'],
        ],
        'about' => [
            ['key' => 'about_founded', 'label' => 'Founded Year', 'type' => 'text'],
            ['key' => 'about_engineers', 'label' => 'Engineers Count', 'type' => 'text'],
            ['key' => 'about_countries', 'label' => 'Countries Count', 'type' => 'text'],
            ['key' => 'about_support', 'label' => 'Support', 'type' => 'text'],
            ['key' => 'about_ai', 'label' => 'AI Processing %', 'type' => 'number'],
            ['key' => 'about_network', 'label' => 'Network Load %', 'type' => 'number'],
            ['key' => 'about_security', 'label' => 'Security Score %', 'type' => 'number'],
            ['key' => 'about_image', 'label' => 'About Image', 'type' => 'image'],
            ['key' => 'terminal_systems', 'label' => 'Terminal Systems Status', 'type' => 'text'],
            ['key' => 'terminal_uptime', 'label' => 'Terminal Uptime', 'type' => 'text'],
            ['key' => 'terminal_nodes', 'label' => 'Terminal Active Nodes', 'type' => 'text'],
            ['key' => 'terminal_threat', 'label' => 'Terminal Threat Level', 'type' => 'text'],
        ],
        'icons' => [
            ['key' => 'icon_about_founded', 'label' => 'About Founded Icon', 'type' => 'image'],
            ['key' => 'icon_about_engineers', 'label' => 'About Engineers Icon', 'type' => 'image'],
            ['key' => 'icon_about_countries', 'label' => 'About Countries Icon', 'type' => 'image'],
            ['key' => 'icon_about_support', 'label' => 'About Support Icon', 'type' => 'image'],
            ['key' => 'icon_email', 'label' => 'Contact Email Icon', 'type' => 'image'],
            ['key' => 'icon_phone', 'label' => 'Contact Phone Icon', 'type' => 'image'],
        ],
        'contact' => [
            ['key' => 'contact_email', 'label' => 'Email Address', 'type' => 'email'],
            ['key' => 'contact_phone', 'label' => 'Phone Number', 'type' => 'text'],
            ['key' => 'social_linkedin', 'label' => 'LinkedIn URL', 'type' => 'url'],
            ['key' => 'social_facebook', 'label' => 'Facebook URL', 'type' => 'url'],
            ['key' => 'social_twitter', 'label' => 'Twitter/X URL', 'type' => 'url'],
            ['key' => 'contact_office_image', 'label' => 'Office Image', 'type' => 'image'],
        ],
        'footer' => [
            ['key' => 'footer_privacy_url', 'label' => 'Privacy Policy URL', 'type' => 'url'],
            ['key' => 'footer_terms_url', 'label' => 'Terms URL', 'type' => 'url'],
            ['key' => 'admin_panel_url', 'label' => 'Admin Panel URL', 'type' => 'url'],
        ],
        'form' => [
            ['key' => 'form_subject_options', 'label' => 'Form Subject Options (JSON array)', 'type' => 'textarea'],
        ],
    ];

    public function edit()
    {
        $settings = SiteSetting::allKeyed();
        $sections = self::FIELDS;

        return view('admin.settings.edit', compact('settings', 'sections'));
    }

    public function update(Request $request)
    {
        $pairs = [];

        foreach (self::FIELDS as $fields) {
            foreach ($fields as $field) {
                $key = $field['key'];

                if ($field['type'] === 'image') {
                    $pairs[$key] = $this->storeUpload($request, $key, SiteSetting::get($key));
                } elseif ($request->has($key)) {
                    $pairs[$key] = $request->input($key);
                }
            }
        }

        SiteSetting::setMany($pairs);

        return redirect()->route('admin.sections.index')->with('success', 'Site settings updated.');
    }
}
