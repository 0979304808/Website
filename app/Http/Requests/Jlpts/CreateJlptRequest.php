<?php

namespace App\Http\Requests\Jlpts;

use Illuminate\Foundation\Http\FormRequest;

class CreateJlptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'shortDes' => 'required',
            'descHtml' => 'required',
            'image' => 'required',
            'language_id' => 'required',
        ];
    }
}
