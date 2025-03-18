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
        $this->app->singleton(LyAlunoService::class, function ($app) {
            return new LyAlunoService();
        });
    
        $this->app->singleton(LyPessoaService::class, function ($app) {
            return new LyPessoaService();
        });
    
        $this->app->singleton(LyDisciplinaService::class, function ($app) {
            return new LyDisciplinaService();
        });
    
        $this->app->singleton(LyLoginService::class, function ($app) {
            return new LyLoginService(
                $app->make(LyAlunoService::class),
                $app->make(LyPessoaService::class),
                $app->make(LyDisciplinaService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
