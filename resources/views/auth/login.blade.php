<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Gateway - Laptop Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    <style>
        /* Neon Green Focus Ring Effect */
        .neon-input:focus {
            border-color: #00ff66 !important;
            box-shadow: 0 0 15px rgba(0, 255, 102, 0.4), inset 0 0 5px rgba(0, 255, 102, 0.2);
        }
    </style>
</head>
<body class="bg-[#0b0f19] bg-gradient-to-br from-[#0f172a] via-[#0b0f19] to-[#1e1b4b] min-h-screen font-sans antialiased flex flex-col justify-between relative overflow-hidden">

    <!-- Ambient Neon Orbs for Visual Glow -->
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Top Branding Line -->
    <header class="p-6 z-10">
        <h1 class="text-[#3498db] font-black text-xl uppercase tracking-wider text-center sm:text-left drop-shadow-[0_0_10px_rgba(52,152,219,0.3)]">
            LAPTOP <span class="text-white">SHOP</span>
        </h1>
    </header>

    <!-- Main Card Viewport -->
    <div class="flex-grow flex items-center justify-center px-4 z-10">
        <div class="max-w-md w-full bg-slate-900/40 backdrop-blur-xl rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)] border border-white/10 p-8 md:p-10">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-black text-white tracking-tight">SYSTEM AUTHENTICATION</h2>
                <p class="text-[10px] text-emerald-400 font-extrabold uppercase tracking-widest mt-1">Authorized Operations Desk Access Only</p>
            </div>

            <!-- Laravel Breeze Session Status Display -->
            @if (session('status'))
                <div class="mb-5 bg-blue-950/40 border border-blue-500/30 text-blue-400 text-xs font-semibold rounded-2xl p-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Unified Breeze Validation Errors Banner -->
            @if($errors->any())
                <div class="mb-5 bg-red-950/40 backdrop-blur-sm border border-red-500/30 text-red-400 text-xs font-semibold rounded-2xl p-4 shadow-[0_0_15px_rgba(239,68,68,0.1)]">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Pointing to Native Breeze Login Route -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Identity Input Element -->
                <div>
                    <label for="email" class="block text-[11px] font-black text-slate-400 uppercase tracking-wider mb-2">Email Identity</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           placeholder="admin@laptopshop.com"
                           class="neon-input w-full bg-slate-950/60 border border-slate-800 text-white placeholder-slate-600 font-semibold text-sm px-4 py-3.5 rounded-xl focus:outline-none transition duration-300">
                </div>

                <!-- Protected Security Key Input Element -->
                <div>
                    <label for="password" class="block text-[11px] font-black text-slate-400 uppercase tracking-wider mb-2">Security Key</label>
                    <input type="password" name="password" id="password" required autocomplete="current-password"
                           placeholder="••••••••"
                           class="neon-input w-full bg-slate-950/60 border border-slate-800 text-white placeholder-slate-600 font-semibold text-sm px-4 py-3.5 rounded-xl focus:outline-none transition duration-300">
                </div>

                <!-- Remember Workstation Checkbox & Forgot Password Link -->
                <div class="flex items-center justify-between pt-1 text-xs font-bold">
                    <label class="flex items-center gap-2 cursor-pointer select-none group">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-800 bg-slate-950 text-emerald-500 focus:ring-0 focus:ring-offset-0 checked:bg-emerald-500 cursor-pointer">
                        <span class="text-slate-400 group-hover:text-slate-300 transition">Remember workstation</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-slate-500 hover:text-slate-400 transition underline decoration-slate-700 underline-offset-4" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Authorization Submission Action Button -->
                <div class="pt-3">
                    <button type="submit" 
                            style="background: linear-gradient(135deg, #00ff66 0%, #00b347 100%); color: #052e16; font-weight: 900; padding: 14px; border-radius: 14px; width: 100%; border: none; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0, 255, 102, 0.25);"
                            onmouseover="this.style.boxShadow='0 4px 25px rgba(0, 255, 102, 0.45)'; this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.boxShadow='0 4px 20px rgba(0, 255, 102, 0.25)'; this.style.transform='translateY(0px)'">
                        ⚡ Enter Dashboard
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- Footer Security Gateway Label -->
    <footer class="text-center py-6 text-[10px] font-bold text-slate-600 tracking-wider z-10 uppercase">
        🔒 SECURE GATEWAY ACCESS LAYER &bull; LAPTOP SHOP MANAGEMENT INFRASTRUCTURE
    </footer>

</body>
</html>