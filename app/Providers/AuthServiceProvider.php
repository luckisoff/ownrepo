<?php

namespace App\Providers;

use App\Leaderboard;
use App\Policies\TestingPolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model'        => 'App\Policies\ModelPolicy',
		User::class        => TestingPolicy::class,
		Leaderboard::class => TestingPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();

		Passport::routes();
		Passport::enableImplicitGrant();
	}
}
