<?php

namespace App\Http\Controllers;

use App\Jobs\ForgotPasswordJob;
use App\Jobs\RegisterCustomerJob;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Str;
use Mail;
use App\Mail\RegisterMail;
use App\Mail\ForgotPasswordMail;
use Yoeunes\Toastr\Facades\Toastr;
use Yoeunes\Toastr\Toastr as ToastrToastr;

class AuthController extends Controller
{
    var $data;
    //login admin
    public function login_admin()
    {
        if (!empty(Auth::guard('admin')->check()) && Auth::guard('user')->user()->is_admin == 0) {
            return redirect('dashboard')->with('error', 'Sorry, you are not allowed to access this page.');
        }

        //check if user already logged in and redirect dashboard
        if (!empty(Auth::guard('admin')->check()) && Auth::guard('admin')->user()->is_admin == 1) {

            return redirect('admin/dashboard');
        }

        return view('admin.auth.login');
    }

    public function auth_login_admin(Request $request)
    {
        $remember = !empty($request->is_remember) ? true : false;
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 1, 'status' => 0, 'is_delete' => 0], $remember)) {
            return redirect('admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Email and password do not match');
        }
    }

    /**
     *
     */
    public function auth_logout_user()
    {

        Auth::guard('customer')->logout();
        return redirect('');
    }

    public function auth_guard_logout_admin()
    {
        Auth::guard('admin')->logout();
        return redirect('');
    }

    public function login_customer(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 0, 'is_delete' => 0], $remember)) {
            if (!empty(Auth::guard('customer')->user()->email_verified_at)) {
                $json['status'] = true;
                $json['message'] = 'Success';
                $json['redirect'] = url('dashboard');
            } else {
                $user = User::getSingle(Auth::guard('customer')->user()->id);

                // Mail::to($user->email)->send(new RegisterMail($user));
                dispatch(new RegisterCustomerJob($user));
                Auth::logout();
                $json['status'] = false;
                $json['message'] = 'Your account email is not verified. Please check your inbox to verify';
            }
        } else {
            $json['status'] = false;
            $json['message'] = 'Email and password do not match';
        }
        echo json_encode($json);
    }

    public function register_customer(Request $request)
    {
        $checkEmailExists = User::checkEmailExists($request->email);
        if (empty($checkEmailExists)) {
            $user = new User();
            $user->name = trim($request->name);
            $user->email = trim($request->email);
            $user->password = Hash::make(trim($request->password));
            $user->save();
            // Mail::to($user->email)->send(new RegisterMail($user));
            dispatch(new RegisterCustomerJob($user));
            $json['status'] = true;
            $json['message'] = 'Account created successfully. An email has been sent to your email address for verification.';
        } else {
            $json['status'] = false;
            $json['message'] = 'The email address already exists. Please contact for account recovery.';
            Toastr('Error','The email address already exists. Please contact for account recovery.');
       
        }
        echo json_encode($json);
    }

    public function activate_customer($id)
    {
        $id_decode = base64_decode($id);
        $user = User::getSingle($id_decode);
        if (empty($user)) {
            return redirect(url(''))->with('error', 'Some technical error occurred. Please try again.');
        }
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();
        return redirect(url(''))->with('success', 'Email successfully verified.');
    }
    public function forgot_password()
    {
        $this->data['meta_title'] = 'Forgot password';
        return view('auth.forgot_password', $this->data);
    }
    public function forgot_password_confirm(Request $request)
    {
        $user = User::checkEmailExists(trim($request->email));
        if (empty($user)) {
            return redirect('forgot-password')->with('error', 'Sorry, the provided email address does not exist');
        }
        if (empty($user->email_verified_at)) {
            return redirect('forgot-password')->with('error', 'Your account email is not verified. Please check your inbox to verify');
        }
        if ($user->status == 1) {
            return redirect('forgot-password')->with('error', 'Sorry, your account is locked. please contact for assistance');
        }
        $user->remember_token = Str::random(30);
        $user->save();
        // Mail::to($user->email)->send(new ForgotPasswordMail($user));
        dispatch(new ForgotPasswordJob($user));
        return redirect()->back()->with('success', 'Please check your email for further instructions on how to reset your password');
    }
    public function password_reset($token)
    {
        $user = User::where(['remember_token' => $token])->first();
        if (empty($user)) {
            return redirect('')->with('error', 'Sorry, some technical error occurred. Please try again later');
        }
        if (empty($user->email_verified_at)) {
            return redirect('')->with('error', 'Your account email is not verified. Please check your inbox to verify');
        }
        if ($user->status == 1) {
            return redirect('')->with('error', 'Sorry, your account is locked. please contact for assistance');
        }
        $this->data['user'] = $user;
        $this->data['meta_title'] = 'Reset password';
        return view('auth.reset_password', $this->data);
    }
    public function password_reset_confirm($token, Request $request)
    {
        $rules = [
            'password'     => 'required|confirmed|min:6',
            'password_confirmation'    => 'required',
        ];

        $request->validate($rules, [
            'password.required'   => 'Please enter your new password',
            'password_confirmation.required'  => 'Please confirm your password',
        ]);
        $user = User::where(['remember_token' => $token])->first();
        if (empty($user)) {
            return redirect('')->with('error', 'Sorry, some technical error occurred. Please try again later');
        }
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(30);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();
        return redirect('')->with('success', 'Your password has been successfully reset.');
    }
}
