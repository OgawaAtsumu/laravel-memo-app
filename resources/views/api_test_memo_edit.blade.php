<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>API更新テスト</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
<body>
    <div class="container form-container">
        <h1>API更新テスト</h1>

        <p>
            MemoApiControllerのupdate()を使って、
            メモを更新するための確認画面です。
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

        <form action="{{ route('api-test.memos.update', $memo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category_id">カテゴリ</label>

                <select id="category_id" name="category_id">
                    <option value="">カテゴリを選択してください</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $memo->category_id) == $category->id ? 'selected' : '' }}
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
                    value="{{ old('title', $memo->title) }}"
                >
            </div>

            <div class="form-group">
                <label for="content">内容</label>

                <textarea
                    id="content"
                    name="content"
                >{{ old('content', $memo->content) }}</textarea>
            </div>

            <button type="submit" class="update-button">
                API形式で更新
            </button>
        </form>

        <br>

        <hr>

        <form action="{{ route('api-test.memos.destroy',$memo->id) }}" method="POST"
        onsubmit="return confirm('このメモをAPI形式で削除しますか？');">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button">
                API形式で削除
            </button>
        </form>


         <a href="{{ route('memos.index') }}" class="back-button">
            メモ一覧へ戻る
        </a>
    </div>
</body>
</html>