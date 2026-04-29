<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'CampusBy — Platform e-dagang terbaik di Malaysia. Beli-belah dalam talian dengan mudah dan selamat.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CampusBy') — E-Dagang Malaysia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    {{-- ══════════ NAVBAR ══════════ --}}
    @include('components.navbar')

    {{-- ══════════ MAIN CONTENT ══════════ --}}
    <main>
        @yield('content')
    </main>

    {{-- ══════════ FOOTER ══════════ --}}
    @include('components.footer')

    {{-- Toast Notification Container --}}
    <div id="toast-container" class="fixed top-24 right-6 z-[100] space-y-3"></div>

    @yield('scripts')
</body>
</html>
