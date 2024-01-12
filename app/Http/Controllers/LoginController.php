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
        // $User = User::where('usercode', $request->username)
        //             ->where('userpass', md5($request->password))
        //             ->where('isActive', true)
        //             ->first();
        // $password = md5($request->password);

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        $credentials['usercode'] = $credentials['username'];
        $credentials['password'] = $request->password;
        $credentials['isActive'] = '1';
        unset($credentials['username']);
        Log::info("get credentials: ".implode(", ", $credentials));
        // if(isset($User))
        // {
        //     Log::info("get user: ".$User);
        //     Auth::login($User);
        //     // Auth::attempt(['email' => $email, 'password' => $password])
        //     $request->session()->regenerate();
        //     return redirect()->route('dashboard');
        // }

        if(Auth::attempt($credentials)) {
            Log::info("get user: ".Auth::user());
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        
        $request->session()->reflash();
            $request->session()->keep(['username', 'password']);
            return back()
            ->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');
    }
}