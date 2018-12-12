<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
    * Redirect the user to the Google authentication page.
    *
    * @return \Illuminate\Http\Response
    */

    public function redirectToProvider($provider)
    {
      return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
          $user = Socialite::driver($provider)->user();
          // if ($provider == 'google') {
          //   $user = Socialite::driver('google')->user();
          // } elseif ($provider == 'facebook') {
          //   $user = Socialite::driver('facebook')->user();
          // }
        } catch (\Exception $e) {
          return redirect('/');
        }
        // only allow people with @company.com to login
        // if(explode("@", $user->email)[1] !== 'company.com'){
        //     return redirect()->to('/');
        // }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            if ($provider == 'google') {
              $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id
              ]);
            } elseif ($provider == 'facebook') {
              $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'facebook_id' => $user->getId()
              ]);
            }
            auth()->login($newUser, true);
        }
        return redirect()->to('/');
    }
}
