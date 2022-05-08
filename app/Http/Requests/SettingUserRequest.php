<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingUserRequest extends FormRequest
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
            'name' => ['required', 'min:4', 'string'],
            'email' => ['email', 'required']
        ];
    }

    /**
     * Get Message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Kolom nama tidak boleh kosong',
            'name.min' => 'Nama minimal memiliki panjang 4 karakter',
            'name.string' => 'Kolom nama harus diisi string',
            'email.required' => 'Kolom email harus tidak boleh kosong',
            'email.email' => 'Kolom email harus diisi dengan benar',
        ];
    }
}
