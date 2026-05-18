<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IAMTEK Billing</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-950 text-white overflow-hidden">

    <!-- Background -->
    <div class="absolute inset-0 overflow-hidden">

        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>

        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl"></div>

    </div>

    <!-- Main -->
    <div class="relative z-10 min-h-screen flex items-center justify-center px-6">

        <div class="max-w-6xl w-full grid lg:grid-cols-2 gap-12 items-center">

            <!-- LEFT -->
            <div>

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 mb-6">

                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>

                    <span class="text-sm text-gray-300">
                        ISP Billing & Network Management
                    </span>

                </div>

                <h1 class="text-5xl lg:text-7xl font-black leading-tight">

                    IAMTEK
                    <span class="text-cyan-400">
                        Billing
                    </span>

                </h1>

                <p class="mt-6 text-lg text-gray-400 leading-relaxed max-w-xl">

                    Modern hotspot billing, voucher management,
                    MikroTik integration, payment automation,
                    and real-time ISP analytics platform.

                </p>

                <!-- Buttons -->
                <div class="mt-10 flex flex-wrap gap-4">

                    <a href="{{ route('login') }}"
                       class="px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:scale-105 transition shadow-2xl font-semibold">

                        Sign In

                    </a>

                    @if(Route::has('register'))

                    <a href="{{ route('register') }}"
                       class="px-8 py-4 rounded-2xl border border-white/20 bg-white/5 hover:bg-white/10 transition font-semibold">

                        Create Account

                    </a>

                    @endif

                </div>

                <!-- Features -->
                <div class="mt-12 grid grid-cols-2 gap-6 text-sm">

                    <div class="bg-white/5 border border-white/10 p-5 rounded-2xl">
                        <h3 class="font-bold text-cyan-400 mb-2">
                            Voucher Management
                        </h3>

                        <p class="text-gray-400">
                            Generate, print and manage hotspot vouchers instantly.
                        </p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-5 rounded-2xl">
                        <h3 class="font-bold text-cyan-400 mb-2">
                            MikroTik Integration
                        </h3>

                        <p class="text-gray-400">
                            Push users and hotspot profiles directly to routers.
                        </p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-5 rounded-2xl">
                        <h3 class="font-bold text-cyan-400 mb-2">
                            Analytics Dashboard
                        </h3>

                        <p class="text-gray-400">
                            Monitor sessions, usage and revenue in real time.
                        </p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-5 rounded-2xl">
                        <h3 class="font-bold text-cyan-400 mb-2">
                            Multi-User System
                        </h3>

                        <p class="text-gray-400">
                            Admin and shopkeeper role management support.
                        </p>
                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="hidden lg:flex justify-center">

                <div class="relative">

                    <!-- Main Card -->
                    <div class="w-[420px] backdrop-blur-2xl bg-white/10 border border-white/20 rounded-3xl shadow-2xl p-8">

                        <div class="flex items-center justify-between mb-8">

                            <div>
                                <h2 class="text-2xl font-bold">
                                    Network Overview
                                </h2>

                                <p class="text-gray-400 text-sm">
                                    Live ISP statistics
                                </p>
                            </div>

                            <div class="w-4 h-4 rounded-full bg-green-400 animate-pulse"></div>

                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4">

                            <div class="bg-slate-900/60 rounded-2xl p-5">
                                <p class="text-gray-400 text-sm">
                                    Active Users
                                </p>

                                <h3 class="text-3xl font-bold mt-2">
                                    1,248
                                </h3>
                            </div>

                            <div class="bg-slate-900/60 rounded-2xl p-5">
                                <p class="text-gray-400 text-sm">
                                    Routers
                                </p>

                                <h3 class="text-3xl font-bold mt-2">
                                    18
                                </h3>
                            </div>

                            <div class="bg-slate-900/60 rounded-2xl p-5">
                                <p class="text-gray-400 text-sm">
                                    Daily Sales
                                </p>

                                <h3 class="text-3xl font-bold mt-2">
                                    UGX 2.4M
                                </h3>
                            </div>

                            <div class="bg-slate-900/60 rounded-2xl p-5">
                                <p class="text-gray-400 text-sm">
                                    Sessions
                                </p>

                                <h3 class="text-3xl font-bold mt-2">
                                    3,892
                                </h3>
                            </div>

                        </div>

                        <!-- Activity -->
                        <div class="mt-8">

                            <h4 class="font-semibold mb-4">
                                Recent Activity
                            </h4>

                            <div class="space-y-3">

                                <div class="flex items-center justify-between bg-slate-900/50 rounded-xl p-3">
                                    <span class="text-sm text-gray-300">
                                        Voucher Generated
                                    </span>

                                    <span class="text-green-400 text-sm">
                                        Success
                                    </span>
                                </div>

                                <div class="flex items-center justify-between bg-slate-900/50 rounded-xl p-3">
                                    <span class="text-sm text-gray-300">
                                        Router Connected
                                    </span>

                                    <span class="text-cyan-400 text-sm">
                                        Online
                                    </span>
                                </div>

                                <div class="flex items-center justify-between bg-slate-900/50 rounded-xl p-3">
                                    <span class="text-sm text-gray-300">
                                        Payment Received
                                    </span>

                                    <span class="text-yellow-400 text-sm">
                                        UGX 25,000
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>