<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メモアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body>
    <div class="container form-container">
        <h1>メモアプリ</h1>

        <p>Laravelで作成した簡易メモアプリです。</p>

        <br>

        @auth
        <div class="home-user-area">
            <p class="login-user">
                ログイン中：{{ Auth::user()->name }}
            </p>
        <div class="home-button-area">
            <a href="{{ route('memos.index') }}" class="new-button">
                メモ一覧へ
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    ログアウト
                </button>
            </form>
        </div>
         @else
        <div class="home-button-area">
            <a href="{{ route('login') }}" class="new-button">
                ログイン
            </a>
            <a href="{{ route('register') }}" class="new-button">
                ユーザー登録
            </a>
        </div>
        @endauth
    </div>
</body>
</html>