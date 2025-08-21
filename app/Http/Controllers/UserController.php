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
            "password" => "required|min:6",
        ]);

        $password = Hash::make($validatedData["password"]);

        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "cpf" => $validatedData["cpf"],
            "password" => $password,
            "active" => true
        ]);

        if (!$user) {
            return back()->with("error", "Erro ao criar usuário");
        }

        return redirect("/", 201);
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email," . $user->id,
            "password" => "nullable|min:6",
        ]);

        $updateData = [
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
        ];

        if (!empty($validatedData["password"])) {
            $updateData["password"] = Hash::make($validatedData["password"]);
        }

        if (!$user->update($updateData)) {
            return back()->with("error", "Erro ao atualizar usuário");
        }

        return back()->with("success", "Perfil atualizado com sucesso!");
    }

    public function toggle(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $user->active = !$user->active;

        if (!$user->save()) {
            return back()->with('error', 'Não foi possível atualizar o status.');
        }

        return back()->with('success', $user->active ? 'Usuário ativado com sucesso!' : 'Usuário desativado com sucesso!');
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
