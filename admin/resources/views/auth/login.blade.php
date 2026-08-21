<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Black Technology Control Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Orbitron', sans-serif; }
    </style>
</head>
<body class="bg-[#030303] min-h-screen flex items-center justify-center p-6">
    <div class="absolute inset-0 bg-gradient-to-b from-cyan-400/5 via-transparent to-violet-600/5 pointer-events-none"></div>

    <div class="relative w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-xl bg-gradient-to-br from-cyan-400 to-violet-600 items-center justify-center mb-4">
                <span class="font-display font-bold text-black">BT</span>
            </div>
            <h1 class="font-display text-2xl font-bold text-white">Control Panel</h1>
            <p class="text-gray-500 text-sm mt-1">Black Technology Admin</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="bg-[#141414] border border-cyan-400/20 rounded-2xl p-8 space-y-5">
            @csrf

            @if($errors->any())
                <div class="px-4 py-3 rounded-lg bg-red-400/10 border border-red-400/30 text-red-400 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block text-sm text-gray-400 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white placeholder-gray-600 focus:outline-none focus:border-cyan-400/50">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1.5">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg bg-[#1a1a1a] border border-cyan-400/20 text-white placeholder-gray-600 focus:outline-none focus:border-cyan-400/50">
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-400">
                <input type="checkbox" name="remember" class="rounded border-cyan-400/30 bg-[#1a1a1a] text-cyan-400">
                Remember me
            </label>

            <button type="submit" class="w-full py-3 bg-cyan-400 text-black font-semibold rounded-lg hover:bg-cyan-300 transition-colors">
                Sign In
            </button>
        </form>

        <p class="text-center text-gray-600 text-xs mt-6">
            Default: admin@blacktech.com / password
        </p>
    </div>
</body>
</html>
