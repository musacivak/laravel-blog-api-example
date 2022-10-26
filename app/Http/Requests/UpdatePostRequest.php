<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
class UpdatePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'id'            => 'required|integer',
            'title'         => 'required|min:5|max:255',
            'description'   => 'required|min:5|max:255',
            'keywords'      => 'required|min:3|max:125',
            'tags'          => 'required|min:3|max:100',
            'content'       => 'required|min:10',
            'slug'          => 'required|unique:posts,slug,' . $this->id,
            'status'        => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'something went wrong',
            'data' => $validator->errors()
        ]));
    }
}
