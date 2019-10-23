<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Page;
use Illuminate\Http\Request;

class PageController extends AsdhController
{
  private $prefix = 'page';

  public function __construct()
  {
    parent::__construct();
    $this->website['routeType'] = 'page';
  }

  public function index()
  {
    $this->website['models'] = Page::latest()->paginate($this->default_pagination_limit);

    return view('admin.page.index', $this->website);
  }

  public function create()
  {
    $this->website['edit'] = false;

    return view('admin.page.create', $this->website);
  }

  public function store(PageRequest $request)
  {
    if ($request->slug == 'contact-us' || $request->slug == 'about-us') {
      return back()->with('failure_message', 'Please change the slug name.');
    }

    $image_name = null;
    if (!is_null($request->image)) {
      $image_name = upload_image_modified($request->image, $this->prefix);
    }

    $page = Page::create([
      'title'       => $request->title,
      'slug'        => $request->slug,
      'image'       => $image_name,
      'description' => $request->description,
      'active'      => $request->active,
      'home'        => $request->home,
    ]);

    return $page
      ? redirect()->route('page.edit', $page)->with('success_message', 'Page successfully added.')
      : back()->with('failure_message', 'Page could not be added. Please try again later.');
  }

  public function edit(Page $page)
  {
    $this->website['edit']  = true;
    $this->website['model'] = $page;

    return view('admin.page.create', $this->website);
  }

  public function update(PageRequest $request, Page $page)
  {
    if ($request->slug == 'contact-us' || $request->slug == 'about-us') {
      return back()->with('failure_message', 'Please change the slug name.');
    }

    $image_name = $page->getOriginal('image');
    if (!is_null($request->image)) {
      $page->delete_image();
      $image_name = upload_image_modified($request->image, $this->prefix);
    }

    return $page->update([
      'title'       => $request->title,
      'slug'        => $request->slug,
      'image'       => $image_name,
      'description' => $request->description,
      'active'      => $request->active,
      'home'        => $request->home,
    ])
      ? back()->with('success_message', 'Page successfully updated.')
      : back()->with('failure_message', 'Page could not be updated. Please try again later.');
  }

  public function destroy(Page $page)
  {
    if ($page->delete()) {
      $page->delete_image();

      return back()->with('success_message', 'Page successfully deleted.');
    }

    return back()->with('failure_message', 'Page could not be deleted. Please try again later.');
  }
}
