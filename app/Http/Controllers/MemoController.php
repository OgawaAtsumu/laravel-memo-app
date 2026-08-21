<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Memo;
use Illuminate\Http\Request;


class MemoController extends Controller
{
    public function index(Request $request){
        $keyword = $request->keyword;
        $categoryId = $request->category_id;
        $query = Memo::query();
        if(!empty($keyword)){
            $query->where(function ($q) use ($keyword){
            $q->where('title', 'like', '%' . $keyword . '%')
            ->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }

        if (!empty($categoryId)) {
        $query->where('category_id', $categoryId);
        }

        $memos = $query
            ->with('category')
            ->latest()
            ->paginate(5);
            $categories = Category::all();
        return view('memos', compact(
            'memos',
            'keyword',
            'categoryId',
            'categories'
            ));
    }

    public function create(){
        $categories = Category::all();
        return view('memo_create',compact('categories'));
    }

    public function store(Request $request){
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|max:255',
        'content' => 'required|max:1000',
    ],[
        'title.required'=>'タイトルは必須です。',
        'title.max' => 'タイトルは255文字以内で入力してください。',
        'content.required'=>'内容は必須です。',
        'content.max' => '内容は1000文字以内で入力してください。',
    ]);

    Memo::create([
        'category_id' => $request->category_id,
        'title' => $request->title,
        'content' => $request->content
    ]);
    return redirect()->route('memos.index')
        ->with('success','メモを登録しました。');
    }

    public function edit($id){
    $memo = Memo::find($id);
    $categories = Category::all();
    return view('memo_edit', compact('memo','categories'));
    }

    public function update(Request $request, $id){
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|max:255',
        'content' => 'required|max:1000',
    ],[
        'category_id.required' => 'カテゴリを選択してください。',
        'category_id.exists' => '選択したカテゴリが存在しません。',
        'title.required'=>'タイトルは必須です。',
        'title.max' => 'タイトルは255文字以内で入力してください。',
        'content.required'=>'内容は必須です。',
        'content.max' => '内容は1000文字以内で入力してください。',
    ]);
    $memo = Memo::find($id);
    $memo->update([
        'category_id' => $request->category_id,
        'title' => $request->title,
        'content' => $request->content
    ]);
    return redirect()->route('memos.index')
        ->with('success', 'メモを更新しました。');
    }

    public function destroy($id){
    $memo = Memo::find($id);
    $memo->delete();
    return redirect()->route('memos.index')
        ->with('success', 'メモを削除しました。');
    }
}
