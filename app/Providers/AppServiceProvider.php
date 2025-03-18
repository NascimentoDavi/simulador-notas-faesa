<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $services = [
            \App\Services\LyLoginService::class,
            \App\Services\LyAlunoService::class,
            \App\Services\LyDisciplinaService::class,
            \App\Services\LyPessoaService::class,
            \App\Services\LySimuladorNotaFormulaService::class
        ];

        forEach($services as $service) {
            $this->app->singleton($service, function ($app) use ($service) {
                return new $service();
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
