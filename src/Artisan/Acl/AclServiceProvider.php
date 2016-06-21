<?php


namespace Windqyoung\Utils\Artisan\Acl;


use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * {@inheritDoc}
     * @see \Illuminate\Support\ServiceProvider::register()
     */
    public function register()
    {
    }

    public function boot()
    {

        $this->publishFile();
    }

    private function publishFile()
    {
        $paths = [
            __DIR__ . '/resources/migrations' => database_path('migrations'),
//             __DIR__ . '/resources/config' => config_path(),
        ];

        $this->publishes($paths);
    }

}
