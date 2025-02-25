<?php

namespace OnrampLab\CleanArchitecture;

use Illuminate\Support\ServiceProvider;
use OnrampLab\CleanArchitecture\Infrastructure\UseCasePerformer;

class CleanArchitectureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('use-case', static fn () => new UseCasePerformer());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }

    protected function registerRoutes(): void
    {
    }

    /**
     * @return array<string, mixed>
     */
    protected function routeConfiguration(): array
    {
        return [
        ];
    }
}
