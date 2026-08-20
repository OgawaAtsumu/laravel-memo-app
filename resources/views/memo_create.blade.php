<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メモ登録</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>
    <body>
    <div class="container form-container">
        <h1>メモ登録</h1>

            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif      


            <form action="{{ route('memos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                <label for="category_id">カテゴリ</label>
                    <select id="category_id" name="category_id">
                        <option value="">カテゴリを選択してください</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"{{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                                </option>
                            @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>タイトル</label>
                    <input type="text" name="title" value="{{ old('title') }}">
                </div>

                <br>

                <div class="form-group">
                    <label>内容</label>
                    <textarea name="content">{{ old('content') }}</textarea>
                </div>

                <br>

                <div class="button-area">
                <button type="submit" class="submit-button">
                    登録
                </button>
                </div>
            </form>

            <a href="{{ route('memos.index') }}" method="GET">
                <button type="submit" class="back-button">
                    一覧へ戻る
                </button>
            </a>


        </div>
    </body>
</html>