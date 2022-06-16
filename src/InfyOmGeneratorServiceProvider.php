<?php

namespace LaravelRussian\Generator;

use Illuminate\Support\ServiceProvider;
use LaravelRussian\Generator\Commands\API\APIControllerGeneratorCommand;
use LaravelRussian\Generator\Commands\API\APIGeneratorCommand;
use LaravelRussian\Generator\Commands\API\APIRequestsGeneratorCommand;
use LaravelRussian\Generator\Commands\API\TestsGeneratorCommand;
use LaravelRussian\Generator\Commands\APIScaffoldGeneratorCommand;
use LaravelRussian\Generator\Commands\Common\MigrationGeneratorCommand;
use LaravelRussian\Generator\Commands\Common\ModelGeneratorCommand;
use LaravelRussian\Generator\Commands\Common\RepositoryGeneratorCommand;
use LaravelRussian\Generator\Commands\Publish\GeneratorPublishCommand;
use LaravelRussian\Generator\Commands\Publish\LayoutPublishCommand;
use LaravelRussian\Generator\Commands\Publish\PublishTemplateCommand;
use LaravelRussian\Generator\Commands\Publish\PublishUserCommand;
use LaravelRussian\Generator\Commands\RollbackGeneratorCommand;
use LaravelRussian\Generator\Commands\Scaffold\ControllerGeneratorCommand;
use LaravelRussian\Generator\Commands\Scaffold\RequestsGeneratorCommand;
use LaravelRussian\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use LaravelRussian\Generator\Commands\Scaffold\ViewsGeneratorCommand;

class InfyOmGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $configPath = __DIR__.'/../config/laravel_generator.php';
            $this->publishes([
                $configPath => config_path('laravel-russian/laravel_generator.php'),
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel_generator.php', 'laravel-russian.laravel_generator');

        $this->app->singleton('laravel-russian.publish', function ($app) {
            return new GeneratorPublishCommand();
        });

        $this->app->singleton('laravel-russian.api', function ($app) {
            return new APIGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.scaffold', function ($app) {
            return new ScaffoldGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.publish.layout', function ($app) {
            return new LayoutPublishCommand();
        });

        $this->app->singleton('laravel-russian.publish.templates', function ($app) {
            return new PublishTemplateCommand();
        });

        $this->app->singleton('laravel-russian.api_scaffold', function ($app) {
            return new APIScaffoldGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.migration', function ($app) {
            return new MigrationGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.model', function ($app) {
            return new ModelGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.repository', function ($app) {
            return new RepositoryGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.api.controller', function ($app) {
            return new APIControllerGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.api.requests', function ($app) {
            return new APIRequestsGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.api.tests', function ($app) {
            return new TestsGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.scaffold.controller', function ($app) {
            return new ControllerGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.scaffold.requests', function ($app) {
            return new RequestsGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.scaffold.views', function ($app) {
            return new ViewsGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.rollback', function ($app) {
            return new RollbackGeneratorCommand();
        });

        $this->app->singleton('laravel-russian.publish.user', function ($app) {
            return new PublishUserCommand();
        });

        $this->commands([
            'laravel-russian.publish',
            'laravel-russian.api',
            'laravel-russian.scaffold',
            'laravel-russian.api_scaffold',
            'laravel-russian.publish.layout',
            'laravel-russian.publish.templates',
            'laravel-russian.migration',
            'laravel-russian.model',
            'laravel-russian.repository',
            'laravel-russian.api.controller',
            'laravel-russian.api.requests',
            'laravel-russian.api.tests',
            'laravel-russian.scaffold.controller',
            'laravel-russian.scaffold.requests',
            'laravel-russian.scaffold.views',
            'laravel-russian.rollback',
            'laravel-russian.publish.user',
        ]);
    }
}
