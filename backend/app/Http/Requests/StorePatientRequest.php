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
      'birth_date' => 'required|date',
      'gender' => 'required|string|size:1|in:M,F,O',
      'address_id' => 'required|integer|exists:addresses,id',
      'phone' => 'nullable|string|size:11|regex:/^[0-9]+$/',
    ];
  }
}
