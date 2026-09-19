<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class IsSyndic {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = $request->user();

		if ($user && ($user->role == 'syndic' || $user->subrole == 'superadmin' ))
		{
			return $next($request);
		}
		return abort(403);
	}

}
