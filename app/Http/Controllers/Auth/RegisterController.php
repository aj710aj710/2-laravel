<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\FileManager;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        $rules = [
            "email" => ['required','email', 'max:255', 'unique:users'],
            "name" => ['required', 'string', 'max:255'],
            "mobile" => 'bail|required|min:6|unique:users',
            "batch_id" => 'required',
            "department_id" => 'required',
            "passing_year_id" => 'required',
            "id_number" => 'bail|required|min:1',
            "file" => ['bail', 'nullable', 'mimetypes:application/pdf'],
            "date_of_birth" => 'required|date|before:today',
            "gender" =>  'bail|required',
            "password" => ['required', 'string', 'min:6', 'confirmed'],
        ];

        if (getOption('register_file_required', 0)) {
            $rules['file'] = ['bail', 'required', 'mimetypes:application/pdf'];
        }

        if (!empty(getOption('google_recaptcha_status')) && getOption('google_recaptcha_status') == STATUS_ACTIVE) {
            $rules['g-recaptcha-response'] ='required|recaptchav3:register';
        }
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $remember_token = Str::random(64);

        $google2fa = app('pragmarx.google2fa');

        $file = NULL;
        if (isset($data['file']) && !is_null($data['file'])) {
            $new_file = new FileManager();
            $uploaded = $new_file->upload('users', $data['file']);
            $file = $uploaded->id;
        }
        if (getOption('registration_approval') == 1) {
            $status = USER_STATUS_INACTIVE ;
        }
        else{
            $status = USER_STATUS_ACTIVE ;
        }
        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            'remember_token' => $remember_token,
            'status' => $status,
            'verify_token' => str_replace('-', '', Str::uuid()->toString()),
            'google2fa_secret' => $google2fa->generateSecretKey(),
            'email_verification_status' => (!empty(getOption('email_verification_status')) && getOption('email_verification_status') == STATUS_ACTIVE) ? STATUS_PENDING : STATUS_ACTIVE,
            'phone_verification_status' =>  0
        ]);




        return $newUser;

    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        if (getOption('disable_registration') != 1)
        {
            return view('auth.register');
        }
        else{
            return redirect()->back()->with('error', 'Registration is not possible!');
        }
    }
}
