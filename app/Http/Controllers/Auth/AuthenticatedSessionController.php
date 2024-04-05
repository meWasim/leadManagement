<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Utility;
use App\Models\UsersOperatorsServices;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\role_operators;

// use Session;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // die('+++++');
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function __construct()
    {
        if(!file_exists(storage_path() . "/installed"))
        {
            header('location:install');
            die;
        }
    }

    /*protected function authenticated(Request $request, $user)
    {
        if($user->delete_status == 1)
        {
            auth()->logout();
        }

        return redirect('/check');
    }*/

    public function store(LoginRequest $request)
    {

        $request->authenticate();
        // print_r($request->all());
        // dd('+++++');
        $request->session()->regenerate();
        //
        $operatorsServices=UsersOperatorsServices::GetOperaterServiceByUserId(Auth::user()->id)->get();
        $operators=array_unique($operatorsServices->pluck('id_operator')->toArray());
        $services=array_unique($operatorsServices->pluck('id_service')->toArray());
        $userOperatorService=['id_operators' => $operators,'id_services'=>$services];
        // dd($userOperatorService);
        // dd($operatorsServices->pluck('id_operator',));
        // $operators=role_operators::select('operator_id')->GetRoleOperator($role_id)->pluck('operator_id')->toArray();
        if(!empty($operators) && !empty($services))
        {
            session(['userOperatorService'=>$userOperatorService]);
        }
        // else{

        //     session(['id_operator' => [1,2,3,4]]);
        // }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function showLoginForm($lang = '')
    {
        if(empty($lang))
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);
        return view('auth.login', compact('lang'));
    }

    public function showLinkRequestForm($lang = '')
    {
        if(empty($lang))
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.forgot-password', compact('lang'));
        /*return view('auth.passwords.email', compact('lang'));*/
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
