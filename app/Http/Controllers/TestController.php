<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;

class TestController extends AsdhController
{
  private $prefix = 'test';

  public function __construct()
  {
    parent::__construct();
    $this->website['routeType'] = 'test';
  }

  public function index()
  {
    $this->website['models'] = Test::latest()->paginate($this->default_pagination_limit);

    return view('admin.test.index', $this->website);
  }

  public function create()
  {
    $this->website['edit'] = false;

    return view('admin.test.create', $this->website);
  }

  public function store(Request $request)
  {
    $image_name = null;
    if (!is_null($request->image)) {
      $image_name = upload_image_modified($request->image, $this->prefix);
    }

    return Test::create([
      'name'        => $request->name,
      'image'       => $image_name,
      'description' => $request->description,
    ])
      ? back()->with('success_message', 'Test successfully added.')
      : back()->with('failure_message', 'Test could not be added. Please try again later.');
  }

  public function edit(Test $test)
  {
    $this->website['edit'] = true;
    $this->website['model'] = $test;

    return view('admin.test.create', $this->website);
  }

  public function update(Request $request, Test $test)
  {
    $image_name = $test->getOriginal('image');
    if (!is_null($request->image)) {
      $test->delete_image();
      $image_name = upload_image_modified($request->image, $this->prefix);
    }

    return $test->update([
      'name'        => $request->name,
      'image'       => $image_name,
      'description' => $request->description,
    ])
      ? back()->with('success_message', 'Test successfully updated.')
      : back()->with('failure_message', 'Test could not be updated. Please try again later.');
  }

  public function destroy(Test $test)
  {
    if ($test->delete()) {
      $test->delete_image();

      return back()->with('success_message', 'Test successfully deleted.');
    }

    return back()->with('failure_message', 'Test could not be deleted. Please try again later.');
  }
}
