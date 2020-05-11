<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class Admin {

	public function handle($request, Closure $next) {
		if (auth()->check()) {

			if (auth()->user()->isAdmin()) {
				return $next($request);
			}
		}

		return redirect(route('home'));
	}
}
