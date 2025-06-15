<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Informacion;
use App\Models\User;
use App\Models\userInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function ajustes(): View
    {
        $usu = auth()->user();
        $idpersona = userInfo::where('id_user', $usu->id)->get()->value('id_persona');
        $infoUser = Informacion::obtenerPorId($idpersona);
        Log::info($idpersona . "  " . $infoUser);
        return view('profile.edit', compact('usu', 'infoUser'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $usuario = $request->user();

        $usuario->fill($request->validated());

        $idpersona = userInfo::where('id_user', $usuario->id)->get()->value('id_persona');

        $info = Informacion::obtenerPorId($idpersona);

        if ($info->email != $request->email) {
            $info->email = $request->email;
            $info->save();

            if ($usuario->isDirty('email')) {
                $usuario->email_verified_at = null;
                $usuario->save();
                $usuario->sendEmailVerificationNotification();
            } else {
                $usuario->save();
            }
        }

        return Redirect::route('ajustes')->with('status', 'perfil actualizado');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
