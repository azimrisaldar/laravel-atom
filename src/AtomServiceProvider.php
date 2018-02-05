<?php

namespace PaymentGateway\Atom;

use Illuminate\Support\ServiceProvider;

class AtomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => base_path('config/Atompay.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $gateway = 'AtomPayment'; 
        
        $this->app->bind('atompay', '\PaymentGateway\Atom\Atompay');

        $this->app->bind('\PaymentGateway\Atom\Gateway\AtomPaymentGatewayInterface','\PaymentGateway\Atom\Gateway\\Atompay');
    }
}
