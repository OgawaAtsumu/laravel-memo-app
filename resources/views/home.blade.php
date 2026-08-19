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

        <a href="{{ route('memos.index') }}" method="GET">
            <button type="submit" class="new-button">
                メモ一覧へ
            </button>
        </a>
    </div>
</body>
</html>