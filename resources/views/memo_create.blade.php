<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メモ登録</title>
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

        .submit-button {
            background-color: #2ecc71;
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