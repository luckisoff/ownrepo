<?php

namespace App\Http\Controllers;

use App\Category;
use App\Custom;
use App\Menu;
use App\Page;
use Illuminate\Http\Request;

class MenuController extends AsdhController
{
  public function __construct()
  {
    parent::__construct();
    $this->website['routeType'] = 'menu';
  }

  public function index()
  {
    $this->website['menus']      = Menu::primary()->withPriority()->get();
    $this->website['all_menus']  = Menu::withPriority()->get();
    $this->website['categories'] = Category::get();
    $this->website['pages']      = Page::get();
    $this->website['posts']      = Custom::posts()->latest()->get();

    return view('admin.menu.index', $this->website);
  }

  public function store(Request $request)
  {
    $request->validate([
      'menu_items' => 'required|array',
    ]);

    $menu_items = $request->menu_items;
    foreach ($menu_items as $key => $menu_item) {
      $menu_items[$key] = explode('|||', $menu_item);
    }
    if (!is_null($request->custom_menu[0]) && !is_null($request->custom_menu[1])) {
      $menu_items[] = $request->custom_menu;
    }

    // assign the newly created menu the last priority
    $last_menu = Menu::primary()->withPriority('desc')->first();
    // if there are no menus then $last_menu will be null
    if (is_null($last_menu)) {
      $order_priority = 1;
      $last_menu_id   = 0;
    } else {
      $order_priority = $last_menu->order_priority + 1;
      $last_menu_id   = $last_menu->id;
    }
    foreach ($menu_items as $key => $menu_item) {
      $menu = Menu::firstOrCreate(
        ['path' => $menu_item[1]],
        ['label' => $menu_item[0], 'order_priority' => $order_priority]
      );

      // if menu is present initially, we wouldn't want to increase the order priority.
      if ($menu->id > $last_menu_id) {
        $order_priority++;
      }
    }

    return back()->with('success_message', 'Menu successfully added.');
  }

  public function update(Request $request)
  {
    foreach ($request->menu_ids as $key => $menu_id) {
      $menu = Menu::find($menu_id);
      $menu->update([
        'label'          => $request->menu_labels[$key],
        'order_priority' => $request->order_prioritys[$key],
      ]);
    }


    return back()->with('success_message', 'Menu saved successfully');
  }

  public function destroy(Menu $menu)
  {
    $menu->delete();

    return back()->with('success_message', 'Menu deleted successfully');
  }

  public function change_label(Request $request, Menu $menu)
  {
    $menu->update(['label' => $request->label]);

    return back()->with('success_message', 'Menu label successfully changed.');
  }

  public function change_order(Request $request)
  {
    $data      = $request->input('serialized_data');
    $menu_data = json_decode($data, true);

    foreach ($menu_data as $key => $menu_datum) {
      // if $menu_datum array has key children then it is a parent menu and has sub menus
      if (array_key_exists('children', $menu_datum)) {
        // make the menu with children as parent
        $menu = Menu::find($menu_datum['id']);
        $menu->update(['parent' => true, 'order_priority' => $key + 1]);
        // assign parent_id to children and reorder their priority
        foreach ($menu_datum['children'] as $sub_key => $child) {
          $sub_menu = Menu::find($child['id']);
          $sub_menu->update(['parent_id' => $menu_datum['id'], 'order_priority' => $sub_key + 1]);
        }
      } else {
        $menu = Menu::find($menu_datum['id']);
        $menu->update(['parent' => false, 'parent_id' => null, 'order_priority' => $key + 1]);
      }
    }

    return response()->json(['message' => 'The order of menu successfully saved.']);
  }

}
