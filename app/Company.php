<?php

namespace App;

use Carbon\Carbon;

class Company extends Model
{
  public function getEstablishedDateAttribute($value)
  {
    return new Carbon($value);
  }

  public function name()
  {
    return ucfirst($this->name);
  }

  public function logo()
  {
    return $this->logo != null
        ? asset($this->image_path . $this->logo)
        : asset($this->image_path . "no-image.jpg");
  }

  public function logo_path()
  {
    return public_path('images/' . $this->logo);
  }
}
