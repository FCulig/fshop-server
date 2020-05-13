<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewTransactionRequest extends FormRequest
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
            'user_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
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
            'user_id.required' => 'Niste povezali korisnika',
            'address.required' => 'Niste upisali adresu',
            'city.required' => 'Niste upisali grad',
            'country.required' => 'Niste upisali državu',
            'zip_code.required' => 'Niste upisali poštanski broj',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
