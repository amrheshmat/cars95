<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Merchant;
use App\OrganizationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    protected $username = 'username';
    protected $redirectTo = '/Dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:merchant')->except('logout');
        $this->middleware('guest:member')->except('logout');

    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function merchantLoginForm()
    {
        return view('auth.merchant-login');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function merchantLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $merchant = Merchant::where('email',$request->email)->first();
        if (Auth::guard('merchant')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended(route('Merchant.Medical.Requests'));
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function memberLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        $member = OrganizationMember::where('email',$request->email)->first();
        if ($member && Hash::check($request->password, $member->password)) {
            $member->api_token = uniqid(base64_encode(str_random(60)));
            $member->save();
            return response()->json(['data' => ['token' => $member->api_token]]);
        }
        return response()->json(['error' => 'wrong email or password'], 400);
    }
}
