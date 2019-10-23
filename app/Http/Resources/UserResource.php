<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'user_id'             => $this->id,
      'name'                => $this->name,
      'social_id'           => $this->social_id,
      'address'             => $this->address,
      'phone_number'        => $this->phone,
      'date_of_birth'       => $this->dob->toDayDateTimeString(),
      'image'               => $this->image,
      'about'               => $this->about,
      'authorization_token' => $this->auth_token,
    ];
  }
}
