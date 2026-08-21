<?php

namespace Database\Seeders;

use App\Models\Graphic;
use App\Models\Service;
use Illuminate\Database\Seeder;

class UpdateMediaSeeder extends Seeder
{
    public function run(): void
    {
        $serviceImages = [
            'images/service-ai.jpg',
            'images/service-cloud.jpg',
            'images/service-security.jpg',
            'images/service-dev.jpg',
            'images/service-iot.jpg',
            'images/service-data.jpg',
        ];

        foreach (Service::orderBy('sort_order')->get() as $i => $service) {
            if (! $service->image && isset($serviceImages[$i])) {
                $service->update(['image' => $serviceImages[$i]]);
            }
        }

        $graphicImages = [
            'images/graphic-brand.jpg',
            'images/graphic-ui.jpg',
            'images/graphic-motion.jpg',
            'images/graphic-3d.jpg',
            'images/graphic-web.jpg',
        ];

        foreach (Graphic::orderBy('sort_order')->get() as $i => $graphic) {
            if (! $graphic->image && isset($graphicImages[$i])) {
                $graphic->update(['image' => $graphicImages[$i]]);
            }
        }
    }
}
