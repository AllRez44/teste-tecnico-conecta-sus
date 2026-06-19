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
}
