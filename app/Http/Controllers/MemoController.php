<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Memo;
use Illuminate\Http\Request;


class MemoController extends Controller
{
    public function index(Request $request){
        $keyword = $request->keyword;
        $query = Memo::query();
        if(!empty($keyword)){
            $query->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('content', 'like', '%' . $keyword . '%');
        }
        $memos = $query->latest()->paginate(5);
        return view('memos', compact('memos','keyword'));
    }

    public function create(){
        $categories = Category::all();
        return view('memo_create',compact('categories'));
    }

    public function store(Request $request){
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required|max:1000',
    ],[
        'title.required'=>'タイトルは必須です。',
        'title.max' => 'タイトルは255文字以内で入力してください。',
        'content.required'=>'内容は必須です。',
        'content.max' => '内容は1000文字以内で入力してください。',
    ]);

    Memo::create([
        'title' => $request->title,
        'content' => $request->content
    ]);
    return redirect()->route('memos.index')
        ->with('success','メモを登録しました。');
    }

    public function destroy($id){
    $memo = Memo::find($id);
    $memo->delete();
    return redirect()->route('memos.index')
        ->with('success', 'メモを削除しました。');
    }

    public function edit($id){
    $memo = Memo::find($id);
    return view('memo_edit', compact('memo'));
    }

    public function update(Request $request, $id){
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required|max:1000',
    ],[
        'title.required'=>'タイトルは必須です。',
        'title.max' => 'タイトルは255文字以内で入力してください。',
        'content.required'=>'内容は必須です。',
        'content.max' => '内容は1000文字以内で入力してください。',
    ]);
    $memo = Memo::find($id);
    $memo->update([
        'title' => $request->title,
        'content' => $request->content
    ]);
    return redirect()->route('memos.index')
        ->with('success', 'メモを更新しました。');
    }
}
