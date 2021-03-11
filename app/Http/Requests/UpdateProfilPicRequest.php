<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilPicRequest extends FormRequest
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
            'photo' => ['image', 'max:1024', 'mimes:jpeg,png,jpg', 'required']
        ];
    }

    /**
     * Get messages
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'photo.required' => 'Tidak ada file yang diupload',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format file harus jpeg, png, atau jpg',
            'photo.max' => 'File tidak boleh melebihi 1MB',
        ];
    }
}
