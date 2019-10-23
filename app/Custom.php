<?php

namespace App;

class Custom extends Model
{
  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function scopePosts($query)
  {
    $query->where('name', 'post');
  }
}
