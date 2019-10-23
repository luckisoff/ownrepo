<?php

namespace App;

class Menu extends Model
{
  public function getUrlAttribute()
  {
    return url($this->path);
  }

  public function scopeWithPriority($query, $order = 'asc')
  {
    return $query->orderBy('order_priority', $order);
  }

  public function scopePrimary($query)
  {
    return $query->whereNull('parent_id');
  }

  public function sub_menus()
  {
    return Menu::where('parent_id', $this->id)->withPriority()->get();
  }

  public function has_sub_menus()
  {
    return $this->sub_menus()->count() > 0;
  }
}
