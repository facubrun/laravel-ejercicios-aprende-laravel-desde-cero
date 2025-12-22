<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; # validamos en el controlador con policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone_number' => 'required|digits:9',
            'age' => 'required|numeric|min:1|max: 255',
            'email' => [
                'required',
                Rule::unique('contacts', 'email')
                ->where('user_id', auth()->id())
                ->ignore(request()->route('contact')),
            ],
            'profile_picture' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'You already have a contact with this email.',
        ];
    }
}
