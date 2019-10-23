<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
    // $company_id = $this->route('company');

    return [
      'name'             => 'required|string|max:255',
      'email'            => 'required|email',
      'logo'             => 'nullable|image|max:5120',
      'established_date' => 'nullable|date',
      'address'          => 'nullable|string|max:255',
      'phone'            => 'nullable|string|max:255',
      'about'            => 'nullable',
    ];
  }
}
