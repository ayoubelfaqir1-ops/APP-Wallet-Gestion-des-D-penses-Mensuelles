<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | WalletApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .mesh-gradient {
            background-color: #5D3FD3;
            background-image: 
                radial-gradient(at 100% 100%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 0% 100%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 50% 50%, hsla(339,49%,30%,1) 0, transparent 50%);
        }
    </style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <div class="hidden lg:flex lg:w-1/2 mesh-gradient p-12 flex-col justify-between text-white">
        <div class="flex items-center gap-2 font-bold text-2xl tracking-tight">
            <i data-lucide="wallet" class="w-8 h-8"></i>
            <span>WalletApp</span>
        </div>
        
        <div class="max-w-md space-y-8">
            <h1 class="text-5xl font-bold leading-tight">Start your journey to financial clarity.</h1>
            
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="bg-white/10 p-2 rounded-lg"><i data-lucide="check-circle" class="text-emerald-400"></i></div>
                    <div>
                        <h4 class="font-bold">Smart Budgeting</h4>
                        <p class="text-slate-400 text-sm">Set monthly goals and track expenses automatically.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="bg-white/10 p-2 rounded-lg"><i data-lucide="zap" class="text-amber-400"></i></div>
                    <div>
                        <h4 class="font-bold">Recurring Payments</h4>
                        <p class="text-slate-400 text-sm">Never miss a bill with automated monthly tracking.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-sm text-slate-400">
            © 2026 WalletApp Inc.
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-md">
            <div class="lg:hidden flex items-center gap-2 font-bold text-2xl text-[#5D3FD3] mb-8">
                <i data-lucide="wallet"></i>
                <span>WalletApp</span>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Create an account</h2>
                <p class="text-slate-500">Sign up in less than 2 minutes.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="/register" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </span>
                        <input type="text" name="nom" placeholder="John Doe" required
                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </span>
                        <input type="email" name="email" placeholder="john@example.com" required
                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </span>
                        <input type="password" name="password" placeholder="••••••••" required minlength="8"
                            class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                    </div>
                    <p class="mt-2 text-xs text-slate-400 flex items-center gap-1">
                        <i data-lucide="info" class="w-3 h-3"></i> Must be at least 8 characters long
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </span>
                        <input type="password" name="confirm_password" placeholder="••••••••" required
                            class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#5D3FD3] hover:bg-[#4B32B3] text-white font-bold py-4 rounded-2xl shadow-lg shadow-violet-200 transition-all transform active:scale-[0.98]">
                    Create Account
                </button>
            </form>

            <p class="text-center text-slate-600 mt-8">
                Already have an account? 
                <a href="/login" class="text-[#5D3FD3] font-bold hover:underline">Log in</a>
            </p>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>