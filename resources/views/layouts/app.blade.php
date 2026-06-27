<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'CampusBuy — Marketplace eksklusif kampus anda. Jual-beli dengan mudah dan selamat.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CampusBuy') — Marketplace Kampus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-black font-sans antialiased tracking-tight">

    {{-- ══════════ NAVBAR (Vertical Nav Rail & Mobile Topbar) ══════════ --}}
    @include('components.navbar')

    {{-- ══════════ MAIN CONTENT ══════════ --}}
    <div class="lg:pl-[72px] flex flex-col min-h-screen">
        <main class="flex-1 w-full pb-20">
            @yield('content')
        </main>

        {{-- ══════════ FOOTER ══════════ --}}
        @include('components.footer')
    </div>

    {{-- Toast Notification Container --}}
    <div id="toast-container" class="fixed top-24 right-6 z-[100] space-y-3"></div>

    @yield('scripts')
</body>
</html>
