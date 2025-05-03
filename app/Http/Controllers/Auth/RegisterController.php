<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        try {

            $user = User::create([
                'last_name'        => $request->last_name,
                'other_names'      => $request->first_name,
                'email'            => $request->email,
                'phone_number'     => $request->phone_number,
                'password'         => Hash::make($request->password),
                'referral_channel' => $request->referral_channel,
                'role_id'          => 2,
            ]);

            if (! $user) {
                throw new \Exception("Account creation failed");
            }

            event(new Registered($user));

            if (! $user || ! $user instanceof \App\Models\User) {
                throw new \Exception("User registration failed");
            }

            $this->guard()->login($user);

            return $this->registered($request, $user)
            ?: redirect($this->redirectPath());

        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['regError' => $e->getMessage()]);
            report($e);
        }

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
            'last_name'    => ['required', 'string', 'max:255'],
            'first_name'   => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:users'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'terms'        => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'last_name'        => $data['lastName'],
            'other_names'      => $data['firstName'],
            'email'            => $data['email'],
            'phone_number'     => $data['phoneNumber'],
            'password'         => Hash::make($data['password']),
            'referral_channel' => $data['referralChannel'],
            'role_id'          => 2,
        ]);

    }

}
