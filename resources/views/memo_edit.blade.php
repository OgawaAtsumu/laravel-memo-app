<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メモ編集</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <!--<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .error-box {
            background-color: #ffecec;
            border: 1px solid #e74c3c;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .error-box li {
            color: #e74c3c;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        textarea {
            height: 150px;
        }

        .button-area {
            display: flex;
            gap: 10px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 6px;
            font-size: 15px;
        }

        .update-button {
            background-color: #3498db;
            color: white;
        }

        .back-button {
            background-color: #95a5a6;
            color: white;
        }
    </style>-->
</head>
<body>
    <div class="container form-container">
        <h1>メモ編集</h1>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif  

        <form action="{{ route('memos.update', $memo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category_id">カテゴリ</label>
                <select id="category_id" name="category_id">
                <option value="">カテゴリを選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"{{ old('category_id', $memo->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>タイトル</label>
                <input type="text" name="title" value="{{ old('title', $memo->title) }}">
            </div>

            <br>

            <div class="form-group">
                <label>内容</label>
                <textarea name="content">{{ old('content', $memo->content) }}</textarea>
            </div>

            <br>

            <div class="button-area">
            <button type="submit" class="update-button">
                更新
            </button>
            </div>
        </form>

        <br>

        <a href="{{ route('memos.index') }}" method="GET">
            <button type="submit" class="back-button">
            一覧へ戻る
            </button>
        </a>
    </div>
</body>
</html>