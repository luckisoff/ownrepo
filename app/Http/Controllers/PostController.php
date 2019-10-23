<?php

namespace App\Http\Controllers;

use App\Category;
use App\Custom;
use Illuminate\Http\Request;

class PostController extends AsdhController
{
  private $prefix = 'post';
  private $view_path = 'admin.custom.';

  public function __construct()
  {
    parent::__construct();
    $this->website['routeType'] = $this->prefix;
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
    $image_name = null;
    if (!is_null($request->image)) {
      $image_name = upload_image_modified($request->image, $this->prefix);
    }
    $post = Custom::create([
      'category_id' => $request->category_id,
      'name'        => $this->prefix,
      'title'       => $request->title,
      'slug'        => $request->slug,
      'image'       => $image_name,
      'description' => $request->description,
      'active'      => $request->active,
      'home'        => $request->home,
    ]);

    return $post
      ? redirect()->route($this->prefix . '.edit', $post)->with('success_message', 'Data successfully added.')
      : back()->with('failure_message', 'Data could not be added. Please try again later.');
  }

  public function edit(Custom $post)
  {
    $this->website['edit']       = true;
    $this->website['model']      = $post;
    $this->website['categories'] = Category::orderBy('name')->get();

    return view($this->view_path . 'create', $this->website);
  }

  public function update(Request $request, Custom $post)
  {
    $image_name = $post->getOriginal('image');
    if (!is_null($request->image)) {
      $post->delete_image();
      $image_name = upload_image_modified($request->image, $this->prefix);
    }

    return $post->update([
      'category_id' => $request->category_id,
      'title'       => $request->title,
      'slug'        => $request->slug,
      'image'       => $image_name,
      'description' => $request->description,
      'active'      => $request->active,
      'home'        => $request->home,
    ])
      ? back()->with('success_message', 'Data successfully updated.')
      : back()->with('failure_message', 'Data could not be updated. Please try again later.');
  }

  public function destroy(Custom $post)
  {
    if ($post->delete()) {
      $post->delete_image();

      return back()->with('success_message', 'Data successfully deleted.');
    }

    return back()->with('failure_message', 'Data could not be deleted. Please try again later.');
  }
}
