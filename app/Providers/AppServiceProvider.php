<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Informacion;
use App\Models\userInfo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $usuario = Auth::user();
            $nombreUsuario = null;
    
            if ($usuario) {
                $idPersona = userInfo::where('id_user', $usuario->id)->value('id_persona');
                $nombreUsuario = Informacion::where('id_persona', $idPersona)->value('nombre');
            }
    
            $view->with('nombreUsuario', $nombreUsuario);
        });
    }
}
