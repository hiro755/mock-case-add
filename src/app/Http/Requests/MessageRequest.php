<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required|max:400',
            'image' => 'nullable|mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'body.required' => '本文を入力してください',
            'body.max' => '本文は400文字以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}