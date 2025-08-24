<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ummahatul Mukminin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    <div class="logo">
            <a href="/"><img src="/img/logoyayasan.png" alt="Ummahatul Mukminin Logo"></a>
        </div>
    <div class="container">
        @include('partials.header')
        @include('partials.nav')

        {{-- Konten halaman ditaruh disini --}}
        <main>
            @yield('content')
        </main>

        {{-- Modal disatukan agar bisa dipanggil dari mana saja --}}
        
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
