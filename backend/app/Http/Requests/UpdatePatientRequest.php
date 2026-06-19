<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdatePatientRequest extends StorePatientRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $rules = parent::rules();

    $rules['cpf'] = [
      'required',
      'string',
      'size:11',
      'regex:/^[0-9]+$/',
      'cpf',
      Rule::unique('patients', 'cpf')->ignore($this->route('patient')),
    ];

    $rules['cns'] = [
      'required',
      'string',
      'size:15',
      'regex:/^[0-9]+$/',
      'cns',
      Rule::unique('patients', 'cns')->ignore($this->route('patient'))
    ];

    return $rules;
  }
}
