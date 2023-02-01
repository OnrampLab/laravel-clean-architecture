<?php

namespace OnrampLab\CleanArchitecture;

use Illuminate\Support\ServiceProvider;

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
