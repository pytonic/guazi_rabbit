<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-31
 * Time: 下午6:24
 */

namespace Gua;


use Illuminate\Support\ServiceProvider;

class RabbitProvider extends ServiceProvider{

    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
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
    protected function getConfigPath()
    {
        return config_path('rabbit.php');
    }
}