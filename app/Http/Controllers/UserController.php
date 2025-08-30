<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cpf' => [
                'required',
                'string',
                'unique:users,cpf',
                function ($attribute, $value, $fail) {
                    if (!$this->isValidCPF($value)) {
                        $fail('O campo :attribute não é um CPF válido.');
                    }
                },
            ],
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validatedData->fails()) {
            return redirect()->route('register')
                ->withErrors($validatedData)
                ->withInput(); // withInput() mantém os dados antigos no formulário
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            return back()->with("error", "Erro ao criar usuário");
        }

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso! Faça seu login.');
    }

    private function isValidCPF(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
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
            return back()->with(
                "error",
                "Não foi possível atualizar o status.",
            );
        }

        return back()->with(
            "success",
            $user->active
            ? "Usuário ativado com sucesso!"
            : "Usuário desativado com sucesso!",
        );
    }
    public function authenticate(
        Request $request,
    ): \Illuminate\Http\RedirectResponse {
        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect("/", 201);
        }

        return back()
            ->withErrors(["email" => "O email inserido não está cadastrado"])
            ->onlyInput("email");
    }
}
