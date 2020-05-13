<?php

namespace App\Http\Requests;

use App\Rules\ValidEmail;
use App\Rules\ValidUsername;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'birth_date' => 'required',
            'email' => ['required', 'email'],
            'profile_picture' => 'image|mimes:jpeg,jpg,png|nullable|max:1999',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'Niste upisali ime',
            'last_name.required' => 'Niste upisali prezime',
            'username.required' => 'Niste upisali korisničko ime',
            'birth_date.required' => 'Niste upisali datum rođenja',
            'profile_picture.image' => 'Odabrana datoteka nije slika',
            'profile_picture.max' => 'Odabrana slika je prevelika',
            'email.required' => 'Niste upisali email',
            'email.email' => 'Nije email',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
