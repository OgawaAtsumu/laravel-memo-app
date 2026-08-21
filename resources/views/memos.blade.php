<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メモ一覧</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>

<body>

    <div class="container">
    <h1>メモ一覧</h1>
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('memos.index') }}" method="GET" class="search-form">
        <input
            type="text"
            name="keyword"
            value="{{ $keyword ?? '' }}"
            placeholder="キーワードを入力"
        >

        <select name="category_id">
        <option value="">すべてのカテゴリ</option>

            @foreach ($categories as $category)
                    <option
                    value="{{ $category->id }}"
                    {{ (string) $categoryId === (string) $category->id ? 'selected' : '' }}
                    >
                    {{ $category->name }}
                    </option>
            @endforeach
        </select>


        <button type="submit" class="search-button">
            検索
        </button>
   
    <a href="{{ route('memos.index') }}" class="reset-button">
            リセット
    </a>
    </form>
    @if (!empty($keyword))
    <p class="search-keyword">
        キーワード「{{ $keyword }}」で検索中
    </p>
    @endif

    @if (!empty($categoryId))
        <p class="search-category">
            カテゴリ「{{ $categories->firstWhere('id', $categoryId)?->name ?? '不明' }}」で絞り込み中
        </p>
    @endif

    @if ($memos->total() > 0)
        <p class="memo-count">
            全{{ $memos->total() }}件中{{ $memos->firstItem() }}〜{{ $memos->lastItem() }}件を表示中
        </p>
    @else
        <p class="memo-count">
            表示件数：0件
        </p>
    @endif

        <a href="{{ route('memos.create') }}" class="new-button">
        新規登録
        </a>

    <hr>

    @if ($memos->count() === 0)
        @if(!empty($keyword))
        <p>『{{$keyword}}』に一致するメモは見つかりませんでした。</p>
        @else    
        <p>メモはまだ登録されていません。</p>
        @endif
    @else
        @foreach ($memos as $memo)
            <div class="memo-card">
                @php
                    $categoryClass = match ($memo->category?->name) {
                        '仕事' => 'category-work',
                        '学習' => 'category-study',
                        'プライベート' => 'category-private',
                        'その他' => 'category-other',
                        default => 'category-unset',
                    };
                @endphp

                <p class="memo-category {{ $categoryClass }}">
                    カテゴリ：{{ $memo->category?->name ?? '未設定' }}
                </p>
                <h2>{{ $memo->title }}</h2>
                <p>{{ $memo->content }}</p>
                <p class="memo-date">
                    作成日：{{ $memo->created_at->format('Y-m-d H:i') }}
                    </p>
                <div class="button-area">
                    <a href="{{ route('memos.edit', $memo->id) }}" class="edit-button">
                            編集
                    </a>
                    <form action="{{ route('memos.destroy', $memo->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="delete-button">
                    削除
                    </button>
                    </form>
                </div>        
            </div>
            <hr>
        @endforeach
    @endif

    <div class="pagination-wrapper">
    {{ $memos->appends([
    'keyword' => $keyword,
    'category_id' => $categoryId
    ])->links('pagination::bootstrap-5') }}
    </div>

</body>
</html>