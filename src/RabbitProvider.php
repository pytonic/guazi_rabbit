<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 下午6:24
 */

namespace Gua;


use Illuminate\Support\ServiceProvider;

class RabbitProvider extends ServiceProvider {

    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(dirname(__DIR__).'/config/rabbit.php','rabbit');
        $this->app->singleton('rabbit.publisher', function ($app) {
            return Publisher::with($app->config['rabbit']);
        });
        $this->app->singleton('rabbit.consumer', function ($app) {
            return Consumer::with($app->config['rabbit']);
        });
    }

    public function boot() {
        $configPath = __DIR__ . '/../config/rabbit.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath() {
        return config_path('rabbit.php');
    }

    public function provides() {
        return ['rabbit.consumer','rabbit.publisher'];
    }


}