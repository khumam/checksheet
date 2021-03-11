<?php

namespace App\Http\Requests;

use App\Rules\CheckOldPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'old_password' => ['required', new CheckOldPasswordRule],
            'password' => ['required', 'confirmed', 'min:8']
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
            'old_password.required' => 'Kolom password lama tidak boleh kosong',
            'password.required' => 'Kolom password baru tidak boleh kosong',
            'password.confirmed' => 'Password konfirmasi tidak sesuai',
            'password.min' => 'Password minimal memiliki panjang 8 karakter',
        ];
    }
}
