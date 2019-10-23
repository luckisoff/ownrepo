<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrizeRequest;
use App\Prize;
use App\Sponsor;
use Illuminate\Http\Request;

class PrizeController extends AsdhController {
	private $viewPath = 'admin.prize';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'prize';
	}

	public function index() {
		$this->website['models'] = Prize::with('sponsor')->select('id', 'week_day', 'position', 'sponsor_id', 'description')->get();

		return view("{$this->viewPath}.index", $this->website);
	}

	public function create() {
		$this->website['edit']     = false;
		$this->website['sponsors'] = Sponsor::select('id', 'name')->get();

		return view("{$this->viewPath}.create", $this->website);
	}

	public function store(PrizeRequest $request) {
		foreach($request->input('sponsor_ids') as $key => $sponsor_id) {
			Prize::create([
				'week_day'    => $request->input('week_day'),
				// 'position'    => $request->input('position'),
				'sponsor_id'  => $sponsor_id,
				'description' => $request->input('prizes')[ $key ],
			]);
		}

		return redirect()->route($this->website['routeType'] . '.index')->with('success_message', 'Prize successfully added.');
	}

	public function edit(Prize $prize) {
		$this->website['edit']     = true;
		$this->website['sponsors'] = Sponsor::select('id', 'name')->get();
		$this->website['model']    = $prize->with('sponsor')->find($prize->id);

		return view("{$this->viewPath}.create", $this->website);
	}

	public function update(Request $request, Prize $prize) {
		return $prize->update([
			'week_day'    => $request->input('week_day'),
			// 'position'    => $request->input('position'),
			'sponsor_id'  => $request->input('sponsor_id'),
			'description' => $request->input('prize'),
		])
			? back()->with('success_message', 'Prize successfully updated.')
			: back()->with('failure_message', 'Prize could not be updated. Please try again later.');
	}

	public function destroy(Prize $prize) {
		if($prize->delete()) {
			return back()->with('success_message', 'Prize successfully deleted.');
		}

		return back()->with('failure_message', 'Prize could not be deleted. Please try again later.');
	}
}
