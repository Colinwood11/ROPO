<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Laravel\Fortify\Fortify;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Fortify::registerView(function () {
            $data['tittle'] = __('messages.Register');
            $data['sidebar_active'] = 0;
            $data['fix_position_top'] = 1;
            $data['navbar_transparent'] = 0;
            return view('auth.register', $data);
        });

        Fortify::loginView(function () {
            $data['tittle'] = __('messages.Login');
            $data['sidebar_active'] = 0;
            $data['fix_position_top'] = 1;
            $data['navbar_transparent'] = 0;
            return view('auth.login', $data);
        });

        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
