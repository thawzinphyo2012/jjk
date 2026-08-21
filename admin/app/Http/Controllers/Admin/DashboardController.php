<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Graphic;
use App\Models\Service;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'services' => Service::count(),
                'graphics' => Graphic::count(),
                'messages' => ContactMessage::count(),
                'unread' => ContactMessage::where('is_read', false)->count(),
            ],
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
        ]);
    }
}
