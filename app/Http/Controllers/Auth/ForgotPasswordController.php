<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view("auth.passwords.email");
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(["email" => "required|email"]);

        try {
            $status = Password::sendResetLink($request->only("email"));

            if ($status == Password::RESET_LINK_SENT) {
                return back()->with("status", __("passwords.sent"));
            }

            return back()->withErrors(["email" => __($status)]);
        } catch (\Exception $e) {

            return back()->withErrors(["email" => "Não foi possível enviar o e-mail no momento. Tente novamente mais tarde."]);
        }
    }
}
