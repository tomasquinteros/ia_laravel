<?php

namespace App\Providers;

use App\Interfaces\IAProcessorInterface;
use App\Processors\GeminiAI;
use App\Processors\IAChainImageProcessor;
use App\Processors\OpenAI;
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
        // Para que laravel sepa que a la hora de instanciar nustro IAProcessorInterface debe usar la cadena de IA
        $this->app->bind(IAProcessorInterface::class, function () {
            return new IAChainImageProcessor([
                new OpenAI(),
                new GeminiAI(),
            ]);
        });
    }
}
