<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtistRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'events' => 'nullable|array',
            'events.*' => 'exists:events,id',
        ];
    }
    
    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'photo.required' => 'Foto artist wajib diupload',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format foto harus: jpeg, jpg, atau png',
            'photo.max' => 'Ukuran foto maksimal 2MB',
        ];
    }
}
