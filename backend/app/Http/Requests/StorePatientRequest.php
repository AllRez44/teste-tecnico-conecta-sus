<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
      'cpf' => [
        'required',
        'string',
        'size:11',
        'regex:/^[0-9]+$/',
        'cpf',
        'unique:patients,cpf'
      ],
      'cns' => [
        'required',
        'string',
        'size:15',
        'regex:/^[0-9]+$/',
        'cns',
        'unique:patients,cns'
      ],
      'birth_date' => 'required|date|before_or_equal:today',
      'gender' => 'required|string|size:1|in:M,F,O',
      'address_id' => 'required|integer|exists:addresses,id',
      'phone' => 'nullable|string|size:11|regex:/^[0-9]+$/',
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
      'unique' => 'O :attribute informado já está em uso.',
      'date' => 'O campo :attribute não é uma data válida.',
      'before_or_equal' => 'O campo :attribute deve ser uma data anterior ou igual a hoje.',
      'in' => 'O campo :attribute selecionado é inválido.',
      'integer' => 'O campo :attribute deve ser um número inteiro.',
      'exists' => 'O :attribute selecionado é inválido.',
      'cpf' => 'O CPF informado não é válido.',
      'cns' => 'O CNS informado não é válido.',
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
      'cpf' => 'CPF',
      'cns' => 'CNS',
      'birth_date' => 'data de nascimento',
      'gender' => 'gênero',
      'address_id' => 'endereço',
      'phone' => 'telefone',
    ];
  }
}
