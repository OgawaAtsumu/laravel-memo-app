<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemoResource;
use App\Http\Requests\MemoRequest;
use App\Models\Memo;
use Illuminate\Http\Request;

class MemoApiController extends Controller
{
    public function index(Request $request)
    {
        $memos = Memo::with('category')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return MemoResource::collection($memos);

    }

    public function show(Request $request, $id)
    {
        $memo = Memo::with('category')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return new MemoResource($memo);
    }

    public function store(MemoRequest $request)
    {
        $validated = $request->validated();

        $memo = Memo::create([
            'user_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        $memo->load('category');

        return (new MemoResource($memo))
        ->additional([
            'message' => 'メモを登録しました。',
        ])
    ->response()
    ->setStatusCode(201);
    }

    public function update(MemoRequest $request, $id)
    {
        $validated = $request->validated();

        $memo = Memo::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $memo->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        $memo->load('category');
        return (new MemoResource($memo))
        ->additional([
            'message' => 'メモを更新しました。',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $memo = Memo::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $memo->delete();

        return response()->json([
            'message' => 'メモを削除しました。',
        ]);
    }


}
