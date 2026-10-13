<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

        protected function prepareForValidation(): void
{
    if (auth()->check()) {
        // Авторизованный пользователь — берём имя из БД
        $this->merge([
            'author_name' => auth()->user()->name,
        ]);
    } else {
        // Гость — генерируем случайное имя
        $this->merge([
            'author_name' => 'Гость_' . random_int(1000, 9999),
        ]);
    }
}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules(): array
{
    return [
        'commentable_id' => 'required|integer|min:1',
        'commentable_type' => 'required|string|max:255',
        'content' => 'required|string|max:5000',
        'parent_id' => 'nullable|integer|exists:comments,id',
        'author_name' => 'required|string|max:100',
    ];
}
}
