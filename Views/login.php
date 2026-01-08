<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | WalletApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .mesh-gradient {
            background-color: #5D3FD3;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        }
    </style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <div class="hidden lg:flex lg:w-1/2 mesh-gradient p-12 flex-col justify-between text-white">
        <div class="flex items-center gap-2 font-bold text-2xl tracking-tight">
            <i data-lucide="wallet" class="w-8 h-8"></i>
            <span>WalletApp</span>
        </div>
        
        <div class="max-w-md">
            <h1 class="text-5xl font-bold leading-tight mb-6">Master your cash flow with confidence.</h1>
            <p class="text-slate-300 text-lg">Join over 10,000 users managing their personal finances with our modern, automated tracking system.</p>
        </div>

        <div class="flex items-center gap-4 text-sm text-slate-400">
            <span>© 2026 WalletApp Inc.</span>
            <span>•</span>
            <a href="#" class="hover:text-white transition">Privacy Policy</a>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
        <div class="w-full max-w-md">
            <div class="lg:hidden flex items-center gap-2 font-bold text-2xl text-[#5D3FD3] mb-8">
                <i data-lucide="wallet"></i>
                <span>WalletApp</span>
            </div>

            <div class="mb-10">
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Welcome back</h2>
                <p class="text-slate-500">Please enter your details to sign in.</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['register_success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['register_success']; ?></span>
                </div>
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>

            <form action="/login" method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </span>
                        <input type="email" id="email" name="email" placeholder="name@company.com" required
                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-sm font-semibold text-[#5D3FD3] hover:text-[#4B32B3]">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </span>
                        <input type="password" id="password" name="password" placeholder="••••••••" required
                            class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#5D3FD3] hover:bg-[#4B32B3] text-white font-bold py-4 rounded-2xl shadow-lg shadow-violet-200 transition-all transform active:scale-[0.98]">
                    Sign In
                </button>
            </form>

            <p class="text-center text-slate-600 mt-10">
                Don't have an account? 
                <a href="/register" class="text-[#5D3FD3] font-bold hover:underline">Sign up for free</a>
            </p>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>