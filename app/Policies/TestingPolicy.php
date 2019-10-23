<?php

namespace App\Policies;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Auth\HandlesAuthentication;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestingPolicy {
	use HandlesAuthorization, HandlesAuthentication;

	public function a() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function b() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function c() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function d() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function e() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function f() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function g() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function h() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function i() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}

	public function j() {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}
}
