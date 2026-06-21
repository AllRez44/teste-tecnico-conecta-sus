<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
      'name' => 'required|string|max:255',
      'street' => 'required|string|max:255',
      'zip_code' => 'required|string|string|size:8|regex:/^[0-9]+$/',
      'neighborhood' => 'required|string|max:255',
      'city' => 'required|string|max:255',
      'state' => 'required|string|size:2|uf',
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
      'required' => 'O campo :attribute é obrigatório.',
      'string' => 'O campo :attribute deve ser um texto.',
      'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
      'size' => 'O campo :attribute deve ter exatamente :size caracteres.',
      'regex' => 'O formato do campo :attribute é inválido.',
      'uf' => 'A UF informada é inválida.',
    ];
  }

  /**
   * Get custom attributes for validator errors.
   *
   * @return array
   */
  public function attributes()
  {
    return [
      'name' => 'nome',
      'street' => 'rua',
      'zip_code' => 'CEP',
      'neighborhood' => 'bairro',
      'city' => 'cidade',
      'state' => 'estado',
    ];
  }
}
