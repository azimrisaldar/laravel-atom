<?php

namespace PaymentGateway\Atom\Facades;

use Illuminate\Support\Facades\Facade;

/**
* 
*/
class Atompay extends Facade
{
	
	protected static function getFacadeAccessor() { 
    	return 'atompay'; 
    }
}