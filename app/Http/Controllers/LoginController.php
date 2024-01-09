<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
 
class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $User = User::where('usercode', $request->username)
                    ->where('userpass', md5($request->password))
                    ->where('isActive', true)
                    ->first();
        Log::info("get user: ".$User);
        if(!$User)
        {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');
        }
        Auth::login($User);
        $request->session()->regenerate();
        return redirect('/dashboard');
        // if(Auth::check()) {
        //     $request->session()->regenerate();
            
        // }
    }
}