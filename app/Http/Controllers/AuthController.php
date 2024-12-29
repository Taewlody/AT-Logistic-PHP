<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
 
class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        $credentials['usercode'] = $credentials['username'];
        $credentials['password'] = $request->password;
        $credentials['isActive'] = true;
        unset($credentials['username']);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // return redirect()->route('dashboard');

            $user = Auth::user()->userType;
            
            if($user->userTypeName === 'Shipping Operation') {
                return redirect()->route('shipping-payment-voucher');

            }else if($user->userTypeName === 'Customer') {
                return redirect()->route('advance-payment');

            }else if($user->userTypeName === 'Supplier') {
                return redirect()->route('account-payment-voucher');
                
            }else if($user->userTypeName === 'Sale') {
                return redirect()->route('job-order');

            }
            else {
                return redirect()->route('dashboard');
            }
        }
        
        $request->session()->reflash();
        return back()
        ->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}