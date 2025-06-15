<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Informacion;
use App\Models\Permisos;
use Illuminate\Support\Facades\Log;
use App\Models\userInfo;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string',
            'DNI' => 'required|string|unique:informacion,DNI',
            'tlf' => 'required|integer|min:0',
            'fecha_nac' => 'required',
            'direcc' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Ese email ya está en uso por otro usuario',
            'DNI.unique' => 'Ese DNI ya está en uso por otro usuario',
        ]);

        $user = User::create([
            'name'=> 'name',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $cliente = Informacion::crearClienteDesdeRequest($request);

        userInfo::create([
            'id_persona' => $cliente->id_persona,
            'id_user' => $user->id
        ]);

        if(Permisos::count()==0){
            Permisos::create([
                'id_persona'=>$cliente->id_persona,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
