<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'KedaiKu — Platform e-dagang terbaik di Malaysia. Beli-belah dalam talian dengan mudah dan selamat.')">
    <title>@yield('title', 'KedaiKu') — E-Dagang Malaysia</title>
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

    @yield('scripts')
</body>
</html>
