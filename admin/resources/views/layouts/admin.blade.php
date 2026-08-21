<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Control Panel') — Black Technology</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Orbitron', sans-serif; }
    </style>
</head>
<body class="bg-[#030303] text-gray-200 min-h-screen">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-[#0a0a0a] border-r border-cyan-400/10 flex flex-col fixed h-full">
            <div class="p-6 border-b border-cyan-400/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-cyan-400 to-violet-600 flex items-center justify-center">
                        <span class="font-display font-bold text-black text-sm">BT</span>
                    </div>
                    <div>
                        <div class="font-display font-bold text-white text-sm tracking-wider">BLACK<span class="text-cyan-400">TECH</span></div>
                        <div class="text-xs text-gray-500">Control Panel</div>
                    </div>
                </a>
            </div>

            <nav class="flex-1 p-4 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm mb-3 {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-400/10 text-cyan-400' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>

                <div class="mb-2 px-4 text-xs font-medium text-gray-600 uppercase tracking-wider">Website Sections</div>
                <div class="space-y-0.5">
                    @foreach(collect(\App\Support\SectionRegistry::all())->sortBy('order') as $key => $sec)
                        <a href="{{ route('admin.sections.edit', $key) }}"
                           class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm {{ (request()->routeIs('admin.sections.edit') && request()->route('section') === $key) || (!empty($sec['items']['route_prefix']) && request()->routeIs('admin.'.$sec['items']['route_prefix'].'.*')) ? 'bg-cyan-400/10 text-cyan-400' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ (request()->routeIs('admin.sections.edit') && request()->route('section') === $key) || (!empty($sec['items']['route_prefix']) && request()->routeIs('admin.'.$sec['items']['route_prefix'].'.*')) ? 'bg-cyan-400' : 'bg-gray-600' }}"></span>
                            <span class="truncate">{{ $sec['label'] }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t border-cyan-400/10">
                    <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.messages.*') ? 'bg-cyan-400/10 text-cyan-400' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Messages
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-cyan-400/10">
                <div class="text-xs text-gray-500 mb-2">{{ auth()->user()->name }}</div>
                <a href="/" target="_blank" class="block text-xs text-gray-400 hover:text-cyan-400 mb-2">View Website →</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-red-400 hover:text-red-300">Logout</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-64">
            <header class="sticky top-0 z-10 bg-[#030303]/90 backdrop-blur border-b border-cyan-400/10 px-8 py-4">
                <h1 class="font-display text-xl font-bold text-white">@yield('page-title', 'Dashboard')</h1>
            </header>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-green-400/10 border border-green-400/30 text-green-400 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="mb-6 px-4 py-3 rounded-lg bg-red-400/10 border border-red-400/30 text-red-400 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
