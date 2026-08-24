<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MemoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required' , 'exists:categories,id'],
            'title' => ['required' , 'max:255'],
            'content' => ['required' , 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'カテゴリを選択してください。',
            'category_id.exists' => '選択したカテゴリが存在しません。',
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'content.required' => '内容は必須です。',
            'content.max' => '内容は1000文字以内で入力してください。',
        ];
    }

}
