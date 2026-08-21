<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Partner;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->translations() as $row) {
            Translation::firstOrCreate(['key' => $row['key']], $row);
        }

        foreach ($this->settings() as $key => $value) {
            SiteSetting::firstOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => explode('_', $key)[0]]
            );
        }

        if (Testimonial::count() === 0) {
            foreach ($this->testimonials() as $t) {
                Testimonial::create($t);
            }
        }

        if (Partner::count() === 0) {
            foreach ($this->partners() as $p) {
                Partner::create($p);
            }
        } else {
            foreach ($this->partners() as $p) {
                Partner::where('name', $p['name'])->whereNull('image')->update(['image' => $p['image']]);
            }
        }

        if (Faq::count() === 0) {
            foreach ($this->faqs() as $f) {
                Faq::create($f);
            }
        }
    }

    private function translations(): array
    {
        $rows = [];
        $data = [
            'nav' => [
                'nav.home' => ['Home', 'ပင်မစာမျက်နှာ'],
                'nav.about' => ['About', 'အကြောင်း'],
                'nav.service' => ['Service', 'ဝန်ဆောင်မှု'],
                'nav.graphic' => ['Graphic', 'ဂရပ်ဖစ်'],
                'nav.faq' => ['FAQ', 'FAQ'],
                'nav.contact' => ['Contact', 'ဆက်သွယ်ရန်'],
            ],
            'hero' => [
                'hero.badge' => ['Digital Growth Experts', 'Digital Growth Experts'],
                'hero.title1' => ['DIGITAL', 'DIGITAL'],
                'hero.title2' => ['MARKETING', 'MARKETING'],
                'hero.desc' => ['We help brands grow online through SEO, social media marketing, paid advertising, content strategy, and conversion-focused web design. From strategy to execution, we turn clicks into customers and data into decisions.', 'SEO၊ social media marketing၊ paid advertising၊ content strategy နှင့် conversion-focused web design ဖြင့် brand များကို online တွင် ကြီးထွားစေပါသည်။ Strategy မှ execution အထိ click များကို customer အဖြစ် ပြောင်းလဲပြီး data ကို ဆုံးဖြတ်ချက်အဖြစ် အသုံးချပေးပါသည်။'],
                'hero.cta1' => ['Start a Project', 'ပရောဂျက် စတင်ရန်'],
                'hero.cta2' => ['Explore Service', 'ဝန်ဆောင်မှု ကြည့်ရန်'],
                'hero.stat1' => ['Projects Delivered', 'ပြီးစီးသော ပရောဂျက်များ'],
                'hero.stat2' => ['Uptime SLA', 'Uptime SLA'],
                'hero.stat3' => ['Global Clients', 'ကမ္ဘာ့ ဖောက်သည်များ'],
                'hero.tag1' => ['AI Core', 'AI Core'],
                'hero.tag2' => ['Cloud Edge', 'Cloud Edge'],
                'hero.tag3' => ['Secure', 'လုံခြုံ'],
            ],
            'about' => [
                'about.label' => ['Who We Are', 'ကျွန်ုပ်တို့ အကြောင်း'],
                'about.title' => ['Growing Brands Through Digital Excellence', 'Digital Excellence ဖြင့် Brand များ ကြီးထွားစေခြင်း'],
                'about.p1' => ['Digital Marketing is a full-service digital agency based in Yangon, Myanmar. We specialize in helping businesses of all sizes build a powerful online presence, attract targeted traffic, and convert visitors into loyal customers.', 'Digital Marketing သည် ရန်ကုန်မြို့တွင် တည်ထောင်ထားသော full-service digital agency တစ်ခုဖြစ်ပါသည်။ လုပ်ငန်းအရွယ်အစားမရွေး online presence တည်ဆောက်ရန်၊ targeted traffic ဆွဲယူရန်နှင့် visitor များကို loyal customer အဖြစ် ပြောင်းလဲရန် ကူညီပေးပါသည်။'],
                'about.p2' => ['Our team of strategists, content creators, designers, and analysts work together to deliver campaigns that are creative, data-backed, and results-oriented.', 'ကျွန်ုပ်တို့၏ strategist များ၊ content creator များ၊ designer များနှင့် analyst များသည် creative ဖြစ်ပြီး data-backed campaign များ ပေးအပ်ရန် ပူးပေါင်းလုပ်ဆောင်ပါသည်။'],
                'about.p3' => ['Whether you need to rank higher on Google, grow your social media following, launch a paid ad campaign, or redesign your website — we have the expertise and tools to make it happen.', 'Google တွင် အဆင့်မြှင့်တင်လိုခြင်း၊ social media follower တိုးလိုခြင်း၊ paid ad campaign စတင်လိုခြင်း သို့မဟုတ် website redesign လိုခြင်း — ကျွန်ုပ်တို့တွင် expertise နှင့် tools များ ရှိပါသည်။'],
                'about.founded' => ['Founded', 'တည်ထောင်သည့်နှစ်'],
                'about.engineers' => ['Engineers', 'အင်ဂျင်နီယာများ'],
                'about.countries' => ['Countries', 'နိုင်ငံများ'],
                'about.support' => ['Support', 'အကူအညီ'],
                'about.ai' => ['AI Processing', 'AI လုပ်ဆောင်မှု'],
                'about.network' => ['Network Load', 'ကွန်ရက် ဝန်တင်'],
                'about.security' => ['Security Score', 'လုံခြုံရေး အမှတ်'],
            ],
            'service' => [
                'service.label' => ['What We Do', 'ကျွန်ုပ်တို့ လုပ်ငန်း'],
                'service.title' => ['Our Service', 'ဝန်ဆောင်မှုများ'],
                'service.desc' => ['End-to-end technology solutions built for scale, security, and the speed of innovation.', 'စကေး၊ လုံခြုံရေးနှင့် ဆန်းသစ်မှု အမြန်နှုန်းအတွက် တည်ဆောက်ထားသော နည်းပညာ ဖြေရှင်းနည်းများ။'],
            ],
            'testimonial' => [
                'testimonial.label' => ['Client Voices', 'ဖောက်သည်များ၏ အမြင်များ'],
                'testimonial.title' => ['Testimonial', 'သုံးသပ်ချက်'],
                'testimonial.desc' => ['What our clients say about working with Black Technology.', 'Black Technology နှင့် လုပ်ဆောင်ခဲ့သော ဖောက်သည်များ၏ အမြင်များ။'],
            ],
            'partnership' => [
                'partnership.label' => ['Trusted By', 'ယုံကြည်စိတ်ချရသော'],
                'partnership.title' => ['Partnership', 'ပူးပေါင်းဆောင်ရွက်မှု'],
                'partnership.desc' => ['We collaborate with industry leaders to deliver world-class technology solutions.', 'ကမ္ဘာ့အဆင့်မီ နည်းပညာ ဖြေရှင်းနည်းများ ပေးအပ်ရန် လုပ်ငန်းခေါင်းဆောင်များနှင့် ပူးပေါင်းဆောင်ရွက်ပါသည်။'],
                'partnership.note' => ['Interested in partnering with us? Reach out to explore collaboration opportunities in cloud, AI, and enterprise solutions.', 'ကျွန်ုပ်တို့နှင့် ပူးပေါင်းဆောင်ရွက်လိုပါသလား။ Cloud၊ AI နှင့် enterprise ဖြေရှင်းနည်းများတွင် ပူးပေါင်းဆောင်ရွက်မှုအခွင့်အလမ်းများကို ဆက်သွယ်မေးမြန်းပါ။'],
                'partnership.cta' => ['Become a Partner', 'ပူးပေါင်းဖော်ဖြစ်ရန်'],
            ],
            'graphic' => [
                'graphic.label' => ['Visual Design', 'Visual Design'],
                'graphic.title' => ['Graphic', 'ဂရပ်ဖစ်'],
                'graphic.desc' => ['Bold visuals, brand identities, and digital art crafted for the next generation of tech.', 'နောက်မျိုးဆက် နည်းပညာအတွက် ရဲရင့်သော visual များ၊ brand identity များနှင့် digital art များ။'],
            ],
            'faq' => [
                'faq.label' => ['FAQ', 'FAQ'],
                'faq.title' => ['Frequently Asked Questions', 'မေးလေ့ရှိသော မေးခွန်းများ'],
                'faq.desc' => ['Quick answers about our services, process, and how we can help your business grow.', 'ကျွန်ုပ်တို့၏ ဝန်ဆောင်မှုများ၊ လုပ်ငန်းစဉ်နှင့် သင့်လုပ်ငန်းကို ကူညီပေးနိုင်ပုံ အကြောင်း အဖြေများ။'],
            ],
            'terminal' => [
                'terminal.command' => ['blacktech --status', 'blacktech --status'],
                'terminal.systems_label' => ['├── systems: ', '├── systems: '],
                'terminal.uptime_label' => ['├── uptime: ', '├── uptime: '],
                'terminal.nodes_label' => ['├── active_nodes: ', '├── active_nodes: '],
                'terminal.threat_label' => ['└── threat_level: ', '└── threat_level: '],
            ],
            'footer' => [
                'footer.rights' => ['© 2026 Digital Marketing. All rights reserved.', '© 2026 Digital Marketing. မူပိုင်ခွင့်များ ရယူထားပါသည်။'],
                'footer.privacy' => ['Privacy', 'ကိုယ်ရေးအချက်အလက်'],
                'footer.terms' => ['Terms', 'စည်းမျဉ်းများ'],
                'footer.admin' => ['Admin Panel', 'Admin Panel'],
                'footer.home' => ['Back to Home', 'ပင်မစာမျက်နှာ'],
            ],
            'contact' => [
                'contact.label' => ['Get In Touch', 'ဆက်သွယ်ရန်'],
                'contact.title' => ['Contact <span class="gradient-text">Us</span>', '<span class="gradient-text">ဆက်သွယ်ပါ</span>'],
                'contact.desc' => ["Have a project in mind? We'd love to hear from you. Send us a message and we'll respond within 24 hours.", 'ပရောဂျက်တစ်ခု ရှိပါသလား။ သင့်ထံမှ ကြားလိုပါသည်။'],
                'contact.email' => ['Email', 'အီးမေးလ်'],
                'contact.email.desc' => ['Send us an email anytime', 'အချိန်မရွေး အီးမေးလ်ပို့နိုင်ပါသည်'],
                'contact.phone' => ['Phone', 'ဖုန်း'],
                'contact.phone.desc' => ['Mon–Fri, 9am–6pm', 'တနင်္လာ–သောကြာ၊ ၉နာရီ–၆နာရီ'],
                'contact.office' => ['Office', 'ရုံးခန်း'],
                'contact.office.desc' => ['Yangon, Myanmar', 'ရန်ကုန်၊ မြန်မာ'],
                'contact.office.addr' => ['Tech Innovation Hub, Floor 12', 'Tech Innovation Hub, အထပ် ၁၂'],
                'contact.follow' => ['Follow Us', 'Follow လုပ်ပါ'],
            ],
            'form' => [
                'contact.form.title' => ['Send a Message', 'မက်ဆေ့ချ် ပို့ရန်'],
                'contact.form.desc' => ['Fill out the form below and our team will get back to you shortly.', 'အောက်ပါ form ကို ဖြည့်ပါ။'],
                'contact.form.name' => ['Your Name', 'အမည်'],
                'contact.form.email' => ['Email Address', 'အီးမေးလ်'],
                'contact.form.phone' => ['Phone Number', 'ဖုန်းနံပါတ်'],
                'contact.form.subject' => ['Subject', 'ခေါင်းစဉ်'],
                'contact.form.message' => ['Message', 'မက်ဆေ့ချ်'],
                'contact.form.submit' => ['Send Message', 'မက်ဆေ့ချ် ပို့မည်'],
                'contact.form.topic' => ['Select a topic', 'ခေါင်းစဉ် ရွေးပါ'],
                'contact.form.opt.ai' => ['AI & Machine Learning', 'AI & Machine Learning'],
                'contact.form.opt.cloud' => ['Cloud Infrastructure', 'Cloud Infrastructure'],
                'contact.form.opt.security' => ['Cybersecurity', 'Cybersecurity'],
                'contact.form.opt.graphic' => ['Graphic Design', 'Graphic Design'],
                'contact.form.opt.other' => ['Other', 'အခြား'],
                'contact.ph.name' => ['John Doe', 'သင့်အမည်'],
                'contact.ph.email' => ['john@example.com', 'email@example.com'],
                'contact.ph.phone' => ['+95 9 XXX XXX XXX', '+95 9 XXX XXX XXX'],
                'contact.ph.message' => ['Tell us about your project...', 'ပရောဂျက်အကြောင်း ပြောပြပါ...'],
                'form.sending' => ['Sending...', 'ပို့နေသည်...'],
                'form.sent' => ['Message Sent!', 'မက်ဆေ့ချ် ပို့ပြီးပါပြီ!'],
                'form.failed' => ['Failed — try again', 'မအောင်မြင် — ထပ်စမ်းပါ'],
            ],
            'page' => [
                'page.title' => ['Digital Marketing | Future-Ready Tech Solutions', 'Digital Marketing | နည်းပညာ ဖြေရှင်းနည်းများ'],
                'page.contact.title' => ['Contact | Digital Marketing', 'ဆက်သွယ်ရန် | Digital Marketing'],
            ],
            'lang' => [
                'lang.btn' => ['မြန်မာ', 'English'],
            ],
        ];

        foreach ($data as $group => $items) {
            foreach ($items as $key => [$en, $mm]) {
                $rows[] = ['key' => $key, 'group' => $group, 'value_en' => $en, 'value_mm' => $mm];
            }
        }

        return $rows;
    }

    private function settings(): array
    {
        return [
            'brand_logo' => 'DM',
            'brand_name' => 'DIGITAL<span class="text-cyan-400">MARKETING</span>',
            'meta_description_home' => 'Digital Marketing — Pioneering the future with cutting-edge AI, cloud, and cybersecurity solutions.',
            'meta_description_contact' => 'Contact Digital Marketing — Get in touch for AI, cloud, and tech solutions.',
            'hero_stat1_count' => '150',
            'hero_stat1_suffix' => '+',
            'hero_stat2_count' => '99.9',
            'hero_stat2_suffix' => '%',
            'hero_stat2_decimals' => '1',
            'hero_stat3_count' => '40',
            'hero_stat3_suffix' => '+',
            'hero_image' => 'images/hero.jpg',
            'about_founded' => '2018',
            'about_engineers' => '50+',
            'about_countries' => '12',
            'about_support' => '24/7',
            'about_ai' => '87',
            'about_network' => '42',
            'about_security' => '98',
            'about_image' => 'images/about.jpg',
            'terminal_systems' => 'operational',
            'terminal_uptime' => '99.97%',
            'terminal_nodes' => '847',
            'terminal_threat' => 'minimal',
            'icon_about_founded' => 'images/icon-founded.jpg',
            'icon_about_engineers' => 'images/icon-engineers.jpg',
            'icon_about_countries' => 'images/icon-global.jpg',
            'icon_about_support' => 'images/icon-support.jpg',
            'icon_email' => 'images/icon-email.jpg',
            'icon_phone' => 'images/icon-phone.jpg',
            'contact_email' => 'hello@blacktech.com',
            'contact_phone' => '+95 9 123 456 789',
            'social_linkedin' => '#',
            'social_facebook' => '#',
            'social_twitter' => '#',
            'contact_office_image' => 'images/contact-office.jpg',
            'footer_privacy_url' => '#',
            'footer_terms_url' => '#',
            'admin_panel_url' => 'http://localhost:8001/login',
            'form_subject_options' => json_encode([
                ['value' => 'ai', 'label_en' => 'AI & Machine Learning', 'label_mm' => 'AI & Machine Learning'],
                ['value' => 'cloud', 'label_en' => 'Cloud Infrastructure', 'label_mm' => 'Cloud Infrastructure'],
                ['value' => 'security', 'label_en' => 'Cybersecurity', 'label_mm' => 'Cybersecurity'],
                ['value' => 'graphic', 'label_en' => 'Graphic Design', 'label_mm' => 'Graphic Design'],
                ['value' => 'other', 'label_en' => 'Other', 'label_mm' => 'အခြား'],
            ], JSON_UNESCAPED_UNICODE),
        ];
    }

    private function testimonials(): array
    {
        return [
            ['quote_en' => '"Black Technology transformed our cloud infrastructure. Their team delivered a scalable platform that cut our deployment time by 60%."', 'quote_mm' => '"Black Technology က ကျွန်ုပ်တို့၏ cloud infrastructure ကို ပြောင်းလဲပေးခဲ့သည်။"', 'name' => 'James Chen', 'role_en' => 'CTO, Nexus Digital', 'role_mm' => 'CTO, Nexus Digital', 'avatar' => 'images/testimonial-1.jpg', 'rating' => 5, 'sort_order' => 1, 'is_active' => true],
            ['quote_en' => '"Their AI integration was seamless. We now process data 10x faster with predictive insights that drive real business decisions."', 'quote_mm' => '"သူတို့၏ AI ပေါင်းစပ်မှုသည် ချောမွေ့ခဲ့သည်။"', 'name' => 'Sarah Mitchell', 'role_en' => 'CEO, DataFlow Inc', 'role_mm' => 'CEO, DataFlow Inc', 'avatar' => 'images/testimonial-2.jpg', 'rating' => 5, 'sort_order' => 2, 'is_active' => true],
            ['quote_en' => '"Outstanding cybersecurity work. Black Technology built a zero-trust system that gave us complete peace of mind."', 'quote_mm' => '"ထူးချွန်သော cybersecurity လုပ်ငန်း။"', 'name' => 'David Park', 'role_en' => 'Director, SecureNet Global', 'role_mm' => 'Director, SecureNet Global', 'avatar' => 'images/testimonial-3.jpg', 'rating' => 5, 'sort_order' => 3, 'is_active' => true],
        ];
    }

    private function partners(): array
    {
        $data = [
            ['name' => 'Microsoft Azure', 'image' => 'images/partner-cloud.jpg'],
            ['name' => 'Amazon AWS', 'image' => 'images/partner-aws.jpg'],
            ['name' => 'Google Cloud', 'image' => 'images/partner-google.jpg'],
            ['name' => 'NVIDIA', 'image' => 'images/partner-nvidia.jpg'],
            ['name' => 'Cisco', 'image' => 'images/partner-cisco.jpg'],
            ['name' => 'Oracle', 'image' => 'images/partner-oracle.jpg'],
        ];

        return collect($data)->map(fn ($item, $i) => [
            'name' => $item['name'],
            'image' => $item['image'],
            'sort_order' => $i + 1,
            'is_active' => true,
        ])->all();
    }

    private function faqs(): array
    {
        return [
            ['question_en' => 'What services does Black Technology offer?', 'question_mm' => 'Black Technology မှာ ဘယ်ဝန်ဆောင်မှုများ ပေးပါသလဲ?', 'answer_en' => 'We provide AI & machine learning, cloud infrastructure, cybersecurity, graphic design, and custom software development tailored to your business needs.', 'answer_mm' => 'AI နှင့် machine learning၊ cloud infrastructure၊ cybersecurity၊ graphic design နှင့် သင့်လုပ်ငန်းလိုအပ်ချက်အတွက် custom software development များ ပေးပါသည်။', 'sort_order' => 1, 'is_active' => true],
            ['question_en' => 'How long does a typical project take?', 'question_mm' => 'ပုံမှန် ပရောဂျက်တစ်ခု ဘယ်လောက်ကြာမလဲ?', 'answer_en' => 'Timelines vary by scope — a branding project may take 2–4 weeks, while enterprise cloud or AI solutions typically run 2–6 months. We provide a detailed timeline after the initial consultation.', 'answer_mm' => 'အချိန်ကာလသည် project scope ပေါ်မူတည်ပါသည် — branding project သည် ၂–၄ ပတ်ကြာနိုင်ပြီး enterprise cloud သို့မဟုတ် AI solution များသည် ၂–၆ လ ကြာနိုင်ပါသည်။', 'sort_order' => 2, 'is_active' => true],
            ['question_en' => 'Do you offer ongoing support and maintenance?', 'question_mm' => 'ongoing support နှင့် maintenance ပေးပါသလား?', 'answer_en' => 'Yes. We offer 24/7 monitoring, security updates, performance optimization, and dedicated support plans to keep your systems running smoothly after launch.', 'answer_mm' => 'ပေးပါသည်။ 24/7 monitoring၊ security update များ၊ performance optimization နှင့် dedicated support plan များဖြင့် launch ပြီးနောက် system များ ချောမွေ့စွာ လည်ပတ်နိုင်အောင် ကူညီပါသည်။', 'sort_order' => 3, 'is_active' => true],
            ['question_en' => 'What industries do you work with?', 'question_mm' => 'ဘယ်လုပ်ငန်းများ နှင့် အလုပ်လုပ်ပါသလဲ?', 'answer_en' => 'We serve clients across finance, healthcare, e-commerce, manufacturing, and startups — from Fortune 500 companies to early-stage ventures in Myanmar and beyond.', 'answer_mm' => 'finance၊ healthcare、e-commerce、manufacturing နှင့် startup များအပါအဝင် Fortune 500 ကုမ္ပဏီများမှ early-stage venture များအထိ မြန်မာနိုင်ငံနှင့် နိုင်ငံတကာတွင် ဝန်ဆောင်မှုပေးပါသည်။', 'sort_order' => 4, 'is_active' => true],
            ['question_en' => 'How do I get started?', 'question_mm' => 'ဘယ်လို စတင်ရမလဲ?', 'answer_en' => "Simply reach out via our contact form or email. We'll schedule a free discovery call to understand your goals and propose a tailored solution.", 'answer_mm' => 'contact form သို့မဟုတ် email ဖြင့် ဆက်သွယ်ပါ။ သင့်ရည်မှန်းချက်များကို နားလည်ရန် free discovery call ချိန်းဆိုပြီး သင့်လျော်သော solution ကို အဆိုပြုပါမည်။', 'sort_order' => 5, 'is_active' => true],
            ['question_en' => 'Can you integrate with our existing systems?', 'question_mm' => 'ကျွန်ုပ်တို့၏ existing system များနှင့် ပေါင်းစပ်နိုင်ပါသလား?', 'answer_en' => 'Absolutely. We specialize in seamless integration with legacy systems, third-party APIs, and multi-cloud environments without disrupting your operations.', 'answer_mm' => 'ပေါင်းစပ်နိုင်ပါသည်။ legacy system များ၊ third-party API များနှင့် multi-cloud environment များနှင့် လုပ်ငန်းကို disruption ဖြစ်စေဘဲ seamless integration လုပ်ဆောင်နိုင်ပါသည်။', 'sort_order' => 6, 'is_active' => true],
        ];
    }
}
