<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COACHTECH | @yield('title', '商品一覧')</title>

    @yield('head')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product-detail.css') }}" rel="stylesheet">
    <link href="{{ asset('css/purchase.css') }}" rel="stylesheet">
    <link href="{{ asset('css/verify-email.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mypage.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header class="navbar-dark">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="navbar-logo">
                <img src="{{ asset('storage/logo/logo.svg') }}" alt="COACHTECH ロゴ" class="logo-img">
            </a>

            @unless (Request::is('register') || Request::is('login') || Request::is('email/verify'))
                <form action="{{ route('products.index') }}" method="GET" class="navbar-search">
                    <input
                        type="text"
                        name="keyword"
                        placeholder="なにをお探しですか？"
                        value="{{ request('keyword') }}"
                        onkeydown="if(event.key === 'Enter'){ this.form.submit(); }"
                    >
                </form>
            @endunless

            <div class="navbar-buttons">
                @guest
                    <a href="{{ route('login') }}" class="btn-login">ログイン</a>
                @endguest

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="btn-logout">ログアウト</button>
                    </form>

                    <a href="{{ route('mypage') }}" class="btn-mypage">マイページ</a>
                    <a href="{{ route('products.create') }}" class="btn-exhibit">出品</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="main-wrapper">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>