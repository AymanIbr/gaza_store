<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        // $rules = 'required|unique:categories,name';
        // if($this->method() != 'POST'){
        //     $rules = 'required|unique:categories,name,'.$this->category->id;
        // }
        return [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image' => ($this->method('POST') ? 'required' : 'nullable')
        ];
    }
}


//   //null safe operator
//   $id = $this->category?->id;

//   return [
//       'name_en' => [
//           'required',
//           Rule::unique('categories', 'name_en')->ignore($id),
//       ],
//       'name_ar' => [
//           'required',
//           Rule::unique('categories', 'name_ar')->ignore($id),
//       ],
//       'description_en' => 'required|string',
//       'description_ar' => 'required|string',
//       'image' => $this->isMethod('post') ? 'required|image|max:2048' : 'nullable|image|max:2048',
//   ];
