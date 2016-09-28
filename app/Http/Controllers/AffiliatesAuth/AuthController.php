<?php

namespace App\Http\Controllers\AffiliatesAuth;

use App\Http\Controllers\Controller;
use App\AffiliateUser;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
     */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * The guard to use.
     *
     * @var string
     */
    protected $guard = 'affiliate';


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'affiliate-user/home';


    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
    protected $redirectAfterLogout = 'affiliate-user/login';


    /**
     * The login view.
     *
     * @var string
     */
    protected $loginView = 'affiliate-auth.login';


    /**
     * The register view.
     *
     * @var string
     */
    // protected $registerView = 'affiliate-auth.register';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
    
}
