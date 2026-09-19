<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Auth;

class AuthController extends BaseController
{
    
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    protected $loginPath = '/damas-administrator/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    
    /**
    * login post
    *
    * @param Illuminate\Http\Request $request
    * @return void
    */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
			'username'   => 'required',
			'password'   => 'required',
		]);
        $throttles = $this->isUsingThrottlesLoginsTrait();        
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        $credentials = [
            'username'  =>  $request->get('username'),
            'password'  =>  $request->get('password'),
        ];
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.index');
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }
    
    /**
    * logout
    *
    * @return void
    */
    public function getLogout()
    {
        Auth::logout();
        return redirect()->back();
    }
        
}
