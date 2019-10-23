<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends AsdhController {
	private $prefix = 'category';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'category';
	}

	public function index() {
		$this->website['categories'] = Category::withCount('questions')->latest()->where('slug', '!=', 'uncategorized')->paginate($this->default_pagination_limit);

		return view('admin.category.index', $this->website);
	}

	public function create() {
		$this->website['edit'] = false;

		return view('admin.category.create', $this->website);
	}

	public function store(CategoryRequest $request) {
		foreach($request->name as $key => $name) {
			$slug = $request->slug[ $key ];
			// $image = is_null($request->image) ?: $request->image[ $key ];
			$image = $request->image[ $key ];
			$icon  = $request->icon[ $key ];
			$color = $request->color[ $key ];

			if(!is_null($name) && !is_null($slug)) {

				$image_name = null;
				if(!is_null($image)) {
					$image_name = upload_image_modified($image, $this->prefix);
				}
				$icon_name = null;
				if(!is_null($icon)) {
					$icon_name = upload_image_modified($icon, $this->prefix);
				}

				// dd($name, $slug, $image_name, $color);

				Category::create([
					'name'  => $name,
					'slug'  => $slug,
					'image' => $image_name,
					'icon'  => $icon_name,
					'color' => $color,
				]);

			}
		}

		return redirect()->route('category.index')->with('success_message', 'Category successfully added.');
	}

	public function show(Category $category) {
		$this->website['routeType'] = 'question';
		$this->website['models']    = $category->questions()->orderBy('difficulty_level_id')->get();

		return view('admin.category.show', $this->website);
	}

	public function edit(Category $category) {
		if($category->slug == 'uncategorized') {
			return back()->with('failure_message', 'Sorry, this category cannot be edited.');
		}
		$this->website['edit']     = true;
		$this->website['category'] = $category;

		return view('admin.category.create', $this->website);
	}

	public function update(CategoryRequest $request, Category $category) {
		if($category->slug == 'uncategorized') {
			return back()->with('failure_message', 'Sorry, this category cannot be edited.');
		}

		$image_name = $category->getOriginal('image');
		if(!is_null($request->image)) {
			$category->delete_image();
			$image_name = upload_image_modified($request->image, $this->prefix);
		}
		$icon_name = $category->getOriginal('icon');
		if(!is_null($request->icon)) {
			$category->delete_image('icon');
			$icon_name = upload_image_modified($request->icon, $this->prefix);
		}

		return $category->update([
			'name'  => $request->name,
			'slug'  => $request->slug,
			'image' => $image_name,
			'icon'  => $icon_name,
			'color' => $request->color,
		])
			? back()->with('success_message', 'Category successfully updated.')
			: back()->with('failure_message', 'Category could not be updated. Please try again later.');
	}

	public function destroy(Category $category) {
		if($category->slug == 'uncategorized') {
			return back()->with('failure_message', 'Sorry, this category cannot be deleted.');
		}

		$uncategorized_category = Category::where('slug', 'uncategorized')->first();
		$category->questions()->update(['category_id' => $uncategorized_category->id]); // customs means all things related to this category

		if($category->delete()) {
			$category->delete_image();
			$category->delete_image('icon');

			return back()->with('success_message', 'Category successfully deleted.');
		}

		return back()->with('failure_message', 'Category could not be deleted. Please try again later.');
	}
}
