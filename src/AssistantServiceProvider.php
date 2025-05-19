<?php

namespace Ijodkor\Dastyor;

use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Ijodkor\Dastyor\Boot\Boot;
use Ijodkor\Dastyor\Livewire\AdvancedCrudWire;
use Ijodkor\Dastyor\Livewire\ControllerWire;
use Ijodkor\Dastyor\Livewire\EnumWire;
use Ijodkor\Dastyor\Livewire\MethodWire;
use Ijodkor\Dastyor\Livewire\MigrationWire;
use Ijodkor\Dastyor\Livewire\ModelRelationWire;
use Ijodkor\Dastyor\Livewire\ModelWire;
use Ijodkor\Dastyor\Livewire\RequestWire;
use Ijodkor\Dastyor\Livewire\ResourceWire;
use Ijodkor\Dastyor\Livewire\ServiceWire;

class AssistantServiceProvider extends ServiceProvider {

    private string $namespace;

    public function __construct($app) {
        parent::__construct($app);

        $this->namespace = Boot::ROOT;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void {
        $this->registerCommands();

        $this->registerRoutes();
        $this->registerResources();

        $this->registerLiveWire();
//        $this->offerPublishing();

        $this->assetsPublish();
        $this->registerHelper();
    }

    /**
     * Register the H routes.
     *
     * @return void
     */
    protected function registerRoutes(): void {
        if ($this->app instanceof CachesRoutes && $this->app->routesAreCached()) {
            return;
        }

        Route::group([
            'domain' => config("$this->namespace.domain", null),
            'prefix' => config("$this->namespace.path"),
            'middleware' => config("$this->namespace.middleware", 'web'),
        ], function() {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Register the H resources.
     *
     * @return void
     */
    protected function registerResources(): void {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->namespace);
    }

    /**
     * @return void
     */
    public function registerHelper(): void {
        require_once __DIR__ . '/Helpers/helper.php';
    }

    /**
     * Register the H Artisan commands.
     *
     * @return void
     */
    protected function registerCommands(): void {
        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {
        if (!defined('GENERATOR_PATH')) {
            define('GENERATOR_PATH', realpath(__DIR__ . '/../'));
        }

        $this->configure();
    }

    /**
     * Set up the configuration for H.
     *
     * @return void
     */
    protected function configure(): void {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/generator.php', $this->namespace
        );

        // H::use(config('H.use', 'default'));
    }


    private function registerLiveWire(): void {
        Livewire::component(Boot::getWire("method-wire"), MethodWire::class);
        Livewire::component(Boot::getWire("model-wire"), ModelWire::class);
        Livewire::component(Boot::getWire("controller-wire"), ControllerWire::class);
        Livewire::component(Boot::getWire("request-wire"), RequestWire::class);
        Livewire::component(Boot::getWire("service-wire"), ServiceWire::class);
        Livewire::component(Boot::getWire("resource-wire"), ResourceWire::class);
        Livewire::component(Boot::getWire("model-relation-wire"), ModelRelationWire::class);
        Livewire::component(Boot::getWire("advanced-crud-wire"), AdvancedCrudWire::class);
        Livewire::component(Boot::getWire("migration-wire"), MigrationWire::class);
        Livewire::component(Boot::getWire("enum-wire"), EnumWire::class);
    }

    private function assetsPublish(): void {
        $this->publishes([
            __DIR__ . '/../assets' => public_path('vendor/generator/assets'),
        ], 'assets');

        // Add gitignore
        $this->publishes([
            __DIR__ . '/../external' => public_path('vendor/generator/assets'),
        ], 'assets');
    }
}