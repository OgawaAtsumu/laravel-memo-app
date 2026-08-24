<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>API登録テスト</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body>
    <div class="container form-container">
        <h1>API登録テスト</h1>

        <p>
            MemoApiControllerのstore()を使って、
            メモを登録するための確認画面です。
        </p>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

         <form action="{{ route('api-test.memos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="category_id">カテゴリ</label>

                <select id="category_id" name="category_id">
                    <option value="">カテゴリを選択してください</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">タイトル</label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                >
            </div>

            <div class="form-group">
                <label for="content">内容</label>

                <textarea
                    id="content"
                    name="content"
                >{{ old('content') }}</textarea>
            </div>

            <button type="submit" class="submit-button">
                API形式で登録
            </button>
        </form>

        <br>

         <form action="{{ route('api-test.memos.store') }}" class="back-button">
            メモ一覧へ戻る
        </a>
    </div>
</body>
</html>