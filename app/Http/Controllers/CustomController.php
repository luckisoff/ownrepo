<?php

namespace App\Http\Controllers;

use App\Category;
use App\Custom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomController extends AsdhController
{
  // the prefix should be singular form of the name of table
  private $prefix;
  private $view_path = 'admin.custom.';

  public function __construct()
  {
    parent::__construct();
    // let custom = post
    // admin/{custom} explodes to ['admin', 'post']. So we assign post to prefix and routeType
    // I did this so that the route field could be customizable and thus prefix.
    $this->prefix = $this->website['routeType'] = explode('/', request()->path())[1];
  }

  public function index()
  {
    $this->website['models'] = Custom::where('name', $this->prefix)->latest()->paginate($this->default_pagination_limit);

    return view($this->view_path . 'index', $this->website);
  }

  public function create()
  {
    $this->website['edit']       = false;
    $this->website['categories'] = Category::orderBy('name')->get();

    return view($this->view_path . 'create', $this->website);
  }

  public function store(Request $request)
  {
    $request->validate([
      'category_id' => 'required|integer|min:0',
      'title'       => 'required|string|max:255',
      'slug'        => 'required|string|unique:customs|max:350',
      'image'       => 'image|max:5120',
      'active'      => 'nullable|boolean',
      'home'        => 'nullable|boolean',
    ]);

    $image_name = null;
    if (!is_null($request->image)) {
      $image_name = upload_image_modified($request->image, $this->prefix);
    }
    $custom = Custom::create([
      'category_id' => $request->category_id,
      'name'        => $this->prefix,
      'title'       => $request->title,
      'slug'        => $request->slug,
      'image'       => $image_name,
      'description' => $request->description,
      'active'      => $request->active,
      'home'        => $request->home,
    ]);

    return $custom
      ? redirect()->route($this->prefix . '.edit', $custom)->with('success_message', ucwords($this->prefix) . ' successfully added.')
      : back()->with('failure_message', ucwords($this->prefix) . ' could not be added. Please try again later.');
  }

  public function edit($id)
  {
    $this->website['edit']       = true;
    $this->website['model']      = Custom::find($id);
    $this->website['categories'] = Category::orderBy('name')->get();

    return view($this->view_path . 'create', $this->website);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'category_id' => 'required|integer|min:0',
      'title'       => 'required|string|max:255',
      'slug'        => ['required', 'string', 'max:300', Rule::unique('customs')->ignore($id)],
      'image'       => 'image|max:5120',
      'active'      => 'nullable|boolean',
      'home'        => 'nullable|boolean',
    ]);

    $custom     = Custom::find($id);
    $image_name = $custom->getOriginal('image');
    if (!is_null($request->image)) {
      $custom->delete_image();
      $image_name = upload_image_modified($request->image, $this->prefix);
    }

    return $custom->update([
      'category_id' => $request->category_id,
      'title'       => $request->title,
      'slug'        => $request->slug,
      'image'       => $image_name,
      'description' => $request->description,
      'active'      => $request->active,
      'home'        => $request->home,
    ])
      ? back()->with('success_message', ucwords($this->prefix) . ' successfully updated.')
      : back()->with('failure_message', ucwords($this->prefix) . ' could not be updated. Please try again later.');
  }

  public function destroy($id)
  {
    $custom = Custom::find($id);
    if ($custom->delete()) {
      $custom->delete_image();

      return back()->with('success_message', ucwords($this->prefix) . ' successfully deleted.');
    }

    return back()->with('failure_message', ucwords($this->prefix) . ' could not be deleted. Please try again later.');
  }
}
