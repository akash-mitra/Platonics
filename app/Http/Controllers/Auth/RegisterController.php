<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\LoginProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    /**
     * list of social drivers enabled for Social Auth
     */
    protected $drivers = [
        'google', 'facebook'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    public function redirectToProvider ($provider)
    {
        if (! in_array($provider, $this->drivers)) 
            return redirect()->route('something_wrong');

        return Socialite::driver($provider)->redirect();   
    }   



    /**
     * This method handles the callback from 
     * social authentication providers and
     * logs in or rejects the user based
     * on if authentication is success
     */
    public function handleProviderCallback ($provider)
    {
        if (! in_array($provider, $this->drivers)) 
            return redirect()->route('something_wrong');

        // attempt to authenticate the user 
        // from the social provider
        try {
            $providerUser = Socialite::driver($provider)->user(); 
        } catch (Exception $e) {
            return redirect()->route('auth_fail');
        }
        
        // now that the user has been authenticated, 
        // check if we already have this user available
        $loginUser = LoginProvider::where('provider_user_id', $providerUser->getId())
                        ->where('provider', $provider)
                        ->first();
        
        // if this login provider for the user already exists
        if ($loginUser)
        {
            // get the user
            $user = $loginUser->user;

            // update the avatar in user and login provider
            $user->avatar = $providerUser->getAvatar();
            $loginUser->avatar = $providerUser->getAvatar();

            // persist the change
            $user->save();
            $loginUser->save();
        }
        else // if the login provider for the user does not exist
        {
            // even though there is no login provider for this
            // user, but the user might still exist in user
            // table. If the user email exists we should
            // retrieve the user and update the user 
            // record with the newy received data
            $user = User::firstOrNew ([
                'email' => $providerUser->getEmail()
            ]);

            // do not update the name if already there
            $user->name   = empty($user->name)? $providerUser->getName(): $user->name;

            // refresh the avatar everytime
            $user->avatar = $providerUser->getAvatar();

            // persist the record to database
            $user->save();

            // create the login provider
            $user->providers()->create ([
                'provider_user_id' => $providerUser->getId(),
                'provider'         => $provider,
                'avatar'           => $providerUser->getAvatar(),
            ]);
        }
        
        // finally log the user in
        Auth::login($user, true);
        return redirect()->route('homepage');
    }


}
