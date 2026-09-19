<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class CheckPermission {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $permission)
	{
		$user = $request->user();

		if ($user && ($user->is('superadmin') || $user->can($permission)))
		{
			return $next($request);
		}
		return abort(403);
	}

}
