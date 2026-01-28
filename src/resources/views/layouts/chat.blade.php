<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>取引チャット | COACHTECH</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="navbar-dark">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="navbar-logo">
                <img src="{{ asset('storage/logo/logo.svg') }}" alt="COACHTECH ロゴ" class="logo-img">
            </a>
        </div>
    </header>

    <main class="main-wrapper">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>