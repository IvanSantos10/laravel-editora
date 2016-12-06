<?php

namespace Editora\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $book = $this->route('book');
        if($this->method() === 'PUT'){
            return $book->user_id === auth()->id();
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $book = $this->route('book');
        $id = $book ? $book->id : null;

        return [
            'title' => "required|max:255|unique:books,title,$id",
            'subtitle' => "required|max:255",
            'price' => "required",
            'user_id' => "required"
        ];
    }
}
