<?php

namespace App\Http\Controllers;

use App\DifficultyLevel;
use Illuminate\Http\Request;

class DifficultyLevelController extends AsdhController {
	private $prefix = 'difficulty-level';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'difficulty-level';
	}

	public function index() {
		$this->website['models'] = DifficultyLevel::orderBy('level')->paginate($this->default_pagination_limit);

		return view('admin.difficulty-level.index', $this->website);
	}

	public function create() {
		$this->website['edit'] = false;

		return view('admin.difficulty-level.create', $this->website);
	}

	public function store(Request $request) {
		$image_name = null;
		if(!is_null($request->sponser_image)) {
			$image_name = upload_image_modified($request->sponser_image, $this->prefix);
		}

		return DifficultyLevel::create([
			'level'         => $request->level,
			'duration'      => $request->duration,
			'price'         => $request->price,
			'point'         => $request->point,
			'sponser_image' => $image_name,
		])
			? redirect()->route('difficulty-level.index')->with('success_message', 'DifficultyLevel successfully added.')
			: redirect()->route('difficulty-level.index')->with('failure_message', 'DifficultyLevel could not be added. Please try again later.');
	}

	public function edit(DifficultyLevel $difficulty_level) {
		$this->website['edit']  = true;
		$this->website['model'] = $difficulty_level;

		return view('admin.difficulty-level.create', $this->website);
	}

	public function update(Request $request, DifficultyLevel $difficulty_level) {
		$image_name = $difficulty_level->getOriginal('sponser_image');
		if(!is_null($request->sponser_image)) {
			$difficulty_level->delete_image('sponser_image');
			$image_name = upload_image_modified($request->sponser_image, $this->prefix);
		}

		return $difficulty_level->update([
			'level'         => $request->level,
			'duration'      => $request->duration,
			'price'         => $request->price,
			'point'         => $request->point,
			'sponser_image' => $image_name,
		])
			? back()->with('success_message', 'DifficultyLevel successfully updated.')
			: back()->with('failure_message', 'DifficultyLevel could not be updated. Please try again later.');
	}

	public function destroy(DifficultyLevel $difficulty_level) {
		if($difficulty_level->delete()) {
			$difficulty_level->delete_image('sponser_image');
			return back()->with('success_message', 'DifficultyLevel successfully deleted.');
		}

		return back()->with('failure_message', 'DifficultyLevel could not be deleted. Please try again later.');
	}

}
