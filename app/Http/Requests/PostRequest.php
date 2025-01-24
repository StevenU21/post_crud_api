<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:6', 'max:40', Rule::unique('posts')->ignore($this->post)],
            'content' => ['required', 'string', 'min:6', 'max:255'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.min' => 'Title must be at least :min characters',
            'title.max' => 'Title must be at most :max characters',
            'title.unique' => 'Title must be unique',
            'content.required' => 'Content is required',
            'content.string' => 'Content must be a string',
            'content.min' => 'Content must be at least :min characters',
            'content.max' => 'Content must be at most :max characters',
        ];
    }
}
