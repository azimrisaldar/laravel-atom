# Atom Payment Gateway Intergration Using Laravel 5 above version

This package will help you to Intergrate Atom Payment Gateway in Laravel framework

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

<h2>Installation</h2>
<b>Step 1:</b> Install package using composer
<pre><code>
    composer require legendconsulting/atom
</pre></code>

<b>Step 2:</b> Add the service provider to the config/app.php file in Laravel
<pre><code>
    'PaymentGateway\Atom\AtomServiceProvider::class',
</pre></code>

<b>Step 4:</b> Publish the config by running in your terminal
<pre><code>
    php artisan vendor:publish
</pre></code>

Edit the config/Atompay.php. Set the Mode of Tesing for True and False... <br>
<pre><code> use PaymentGateway\Atom\Facades\Atompay;  </code></pre>
Initiate Purchase Request and Redirect using the default gateway:-
```php 
      /* All Required Parameters by your Gateway */
      
      $parameters = [
        'email'        => 'xyz@xyz.com',
        'phone'        => '**********',
        'Amount'        => '100',
      ];
        
        $return = Atompay::prepare($parameters);

        return redirect($return) ;
```

<pre><code> 
    public function response(Request $request)
    
    {
        // For default Gateway
        $response = Atompay::response($request);

        dd($response);
    
    }  
</code></pre>


