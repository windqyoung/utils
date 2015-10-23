<?php

namespace Windqyoung\Utils\Artisan;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Windqyoung\Utils\Sms\VCode;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->regSmsVCodeService();
    }

    /**
     * 注册短信验证码的生送与判断对象
     */
    protected function regSmsVCodeService()
    {
        $this->app->singleton('windq.sms_vcode_service', function () {
            $vcode = new VCode();
            $vcode->setSender($this->makeSmsSender());
            $vcode->setStore($this->app->make('cache.store'));

            return $vcode;
        });
    }

    /**
     * 短信发送对象
     */
    protected function makeSmsSender()
    {
        return $this->app->make('windq.sms_send_service');
    }

}