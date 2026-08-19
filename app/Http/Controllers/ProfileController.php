<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use App\Models\Memo;*/

class ProfileController extends Controller
{
    public function index(){
    $name = "小川";
       $hobbies = [
            'ゲーム',
            'サッカー',
            '勉強',
        ];
    return view('profile', compact('name','hobbies'));
    //return view('profile', compact('name'));
    }

    public function about(){
    return view('about');
    }

    /*public function memos(){
    $memos = Memo::all();
    return view('memos', compact('memos'));
    }

    public function create(){
    return view('memo_create');
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
    return redirect('/memos');
    }

    public function destroy($id){
    $memo = Memo::find($id);
    $memo->delete();
    return redirect('/memos');
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
    return redirect('/memos');
    }*/

}
