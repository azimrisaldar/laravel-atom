<?php

namespace PaymentGateway\Atom\Gateway;

interface AtomPaymentGatewayInterface{
	public function request($parameters);
    public function response($request);
}
