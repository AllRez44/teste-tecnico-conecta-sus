<?php

namespace App\Http\Requests;

class UpdateAddressRequest extends StoreAddressRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return parent::rules();
  }
}
