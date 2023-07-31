<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCheckSheetRequest extends FormRequest
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
            'date' => ['required'],
            'location' => ['required'],
            'descs' => ['required'],
            'reports' => ['required'],
            'validation' => ['required'],
            'created_by' => ['required'],
            'checked_by' => ['required'],
        ];
    }
}
