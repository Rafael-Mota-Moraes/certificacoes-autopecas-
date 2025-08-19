<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email|email",
            "cpf" => "required|unique:users,cpf|min:11|max:11",
            "password" => "required",
        ]);

        $password = Hash::make($validatedData["password"]);

        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "cpf" => $validatedData["cpf"],
            "password" => $password,
        ]);

        if (!$user) {
            return back()->with("error", "Erro ao criar usuário");
        }

        return redirect("/", 201);
    }

    public function authenticate(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect("/", 201);
        }

        return back()->withErrors(["email" => "O email inserido não está cadastrado"])->onlyInput('email');
    }
}
