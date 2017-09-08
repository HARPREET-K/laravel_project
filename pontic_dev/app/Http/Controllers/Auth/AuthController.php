<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

#AccountActivation
use Illuminate\Http\Request;
use App\ActivationService;
#DB
use DB;
use App\Classes\Common;

#Models
use App\User;
use App\OfficeInformation;
use App\OfficeTimings;

class AuthController extends Controller {
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

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */

    protected $activationService;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    /* public function __construct()
      {
      $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
      } */

    #AccountActivation
    public function __construct(ActivationService $activationService) {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->activationService = $activationService;


        $this->Common = new Common;
        $this->DateInstance = new \DateTime();
        $this->offset = $this->Common->getLocalOffsetValue();
        $this->utcSeconds = $this->DateInstance->getTimestamp() - $this->offset;
        $interval = new \DateInterval('P6M');
        $this->utcSecondsWith6MonthsSubscription = $this->DateInstance->add($interval)->getTimestamp() - $this->offset;
         $this->MyClassInstance = new Common;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {


        $messsages = array();
        $rules = array(
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'user_type' => 'required',
            'zipcode' => 'required|numeric|digits_between:3,6',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'terms_conditions' => 'required'
        );

        return $validator = Validator::make($data, $rules, $messsages);
    }

    /**
     * Loading registration form for user
     *
     * @param  array  $data
     * @return view
     */
    public function showRegistrationForm() {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }
        $userTypes = DB::table('user_types')->get();
        return view('auth.register', compact('userTypes'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {

        $lat_long = $this->MyClassInstance->get_lat_long($data['zipcode']);
        $userObject = USER::create([
                    'email' => $data['email'],
                    'name' =>$data['name'],
                    'userType' => (isset($data['user_type']) ? $data['user_type'] : NULL),
                    'zipcode' => (isset($data['zipcode']) ? $data['zipcode'] : NULL),
                    'password' => bcrypt($data['password']),
                    'latitude' =>$lat_long['lat'],
                    'longitude'=>$lat_long['lng'],
                    'created_at' => $this->utcSeconds,
                    'updated_at' => $this->utcSeconds
        ]);

        //Dental office user
        if(isset($data['user_type'])&& $data['user_type'] == 1){

            $officeProfile = OfficeInformation::create([
                'user_id' => $userObject->id,
                'zipcode' => (isset($data['zipcode']) ? $data['zipcode'] : NULL),
                'latitude' =>$lat_long['lat'],
                'longitude'=>$lat_long['lng'],
                'created_at' => $this->utcSeconds,
                'updated_at' => $this->utcSeconds
            ]);

            $officeTimings = OfficeTimings::create([
              'office_id' =>$officeProfile->id
            ]);
        }

        return $userObject;
    }

    #AccountActivation

    public function register(Request $request) {


        try {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                $this->throwValidationException(
                        $request, $validator
                );
            }

            $user = $this->create($request->all());

            $this->activationService->sendActivationMail($user);

            return redirect('/login')->with('status', 'We sent you an activation code. Check your email.');
        } catch (\Exception $e) {
            \Log::info('Exception:' . $e->getMessage());
            return redirect('/register')->with('status', $e->getMessage());
        }
    }

    #AccountActivation

    public function authenticated(Request $request, $user) {
       /* if (!$user->activated) {
            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        * *
        */
        if (!$user->in_active) {
            auth()->logout();
            return back()->with('warning', 'Your account was deleted. Please contact the Admin to reactivate your account.');
        }
        if ($user->activated==0) {
            auth()->logout();
            $activationAlert = 'Your account is not activated yet. Please check your E-mail for an Account Verification E-mail from PONTIC. If you don`t find your E-mail, check your spam mail. Contact PONTIC at  <a href="mailto:contact@pontic.com" target="_top">contact@pontic.co</a>';
            return back()->with('warning', $activationAlert);
        }
        return redirect()->intended($this->redirectPath());
    }

    #AccountActivation

    public function activateUser($token) {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect($this->redirectPath());
        }
        abort(404);
    }

}
