<?php

namespace Database\Seeders;

use App\Models\Graphic;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@blacktech.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $services = [
            ['title' => 'AI & Machine Learning', 'title_mm' => 'AI နှင့် Machine Learning', 'description' => 'Custom neural networks, LLM integration, and predictive analytics that transform raw data into actionable intelligence.', 'description_mm' => 'စိတ်ကြိုက် neural network များ၊ LLM ပေါင်းစပ်မှုနှင့် ခန့်မှန်းချက် analytics။', 'icon_color' => 'cyan', 'image' => 'images/service-ai.jpg', 'sort_order' => 1],
            ['title' => 'Cloud Infrastructure', 'title_mm' => 'Cloud Infrastructure', 'description' => 'Multi-cloud architecture, serverless pipelines, and auto-scaling systems designed for zero-downtime performance.', 'description_mm' => 'Multi-cloud architecture၊ serverless pipeline များနှင့် auto-scaling စနစ်များ။', 'icon_color' => 'violet', 'image' => 'images/service-cloud.jpg', 'sort_order' => 2],
            ['title' => 'Cybersecurity', 'title_mm' => 'Cybersecurity', 'description' => 'Zero-trust frameworks, penetration testing, and real-time threat detection to keep your assets impenetrable.', 'description_mm' => 'Zero-trust framework၊ penetration testing နှင့် real-time ခြိမ်းခြောက်မှု ရှာဖွေခြင်း။', 'icon_color' => 'green', 'image' => 'images/service-security.jpg', 'sort_order' => 3],
            ['title' => 'Software Development', 'title_mm' => 'Software Development', 'description' => 'Full-stack applications, microservices, and API ecosystems built with modern frameworks and clean architecture.', 'description_mm' => 'Full-stack application များ၊ microservice များနှင့် API ecosystem များ။', 'icon_color' => 'orange', 'image' => 'images/service-dev.jpg', 'sort_order' => 4],
            ['title' => 'IoT & Edge Computing', 'title_mm' => 'IoT & Edge Computing', 'description' => 'Connected device networks and edge processing solutions that bring computation closer to the source.', 'description_mm' => 'ချိတ်ဆက်ထားသော device network များနှင့် edge processing ဖြေရှင်းနည်းများ။', 'icon_color' => 'pink', 'image' => 'images/service-iot.jpg', 'sort_order' => 5],
            ['title' => 'Data Analytics', 'title_mm' => 'Data Analytics', 'description' => 'Big data pipelines, real-time dashboards, and business intelligence platforms that drive smarter decisions.', 'description_mm' => 'Big data pipeline များ၊ real-time dashboard များနှင့် business intelligence platform များ။', 'icon_color' => 'blue', 'image' => 'images/service-data.jpg', 'sort_order' => 6],
        ];

        foreach ($services as $service) {
            Service::create($service + ['is_active' => true]);
        }

        $graphics = [
            ['title' => 'Neon Brand System', 'category' => 'Brand Identity', 'description' => 'Complete visual identity with logo, color palette, and typography for a cyber-tech startup.', 'image' => 'images/graphic-brand.jpg', 'gradient' => 'from-cyan-400/30 via-violet-600/20 to-obsidian', 'sort_order' => 1],
            ['title' => 'Dark Dashboard UI', 'category' => 'UI Design', 'description' => 'Futuristic admin panel with data visualization, dark mode, and neon accent elements.', 'image' => 'images/graphic-ui.jpg', 'gradient' => 'from-violet-600/30 via-pink-500/20 to-obsidian', 'sort_order' => 2],
            ['title' => 'Tech Intro Animation', 'category' => 'Motion Graphic', 'description' => 'Dynamic motion graphics and particle effects for product launch videos.', 'image' => 'images/graphic-motion.jpg', 'gradient' => 'from-green-400/20 via-cyan-400/30 to-obsidian', 'sort_order' => 3],
            ['title' => 'Holographic Product', 'category' => '3D Render', 'description' => 'Photorealistic 3D renders and holographic product visualizations for marketing.', 'image' => 'images/graphic-3d.jpg', 'gradient' => 'from-orange-400/20 via-red-500/10 to-obsidian', 'sort_order' => 4],
            ['title' => 'Landing Page Assets', 'category' => 'Web Graphic', 'description' => 'Custom icons, illustrations, and hero graphics for high-converting web experiences.', 'image' => 'images/graphic-web.jpg', 'gradient' => 'from-blue-400/20 via-indigo-600/30 to-obsidian', 'sort_order' => 5],
        ];

        foreach ($graphics as $graphic) {
            Graphic::create($graphic + ['is_active' => true]);
        }
    }
}
