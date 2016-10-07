<?php 

namespace PaymentGateway\Atom\Gateway;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use PaymentGateway\Atom\Exceptions\AtomParametermissingException;

class AtomPaymentGateway implements AtomPaymentGatewayInterface
{	

	protected $parameters = '';
    protected $testMode = true;
    protected $merchantKey = '';
    protected $salt = '';
    protected $hash = '';
    protected $liveEndPoint = 'https://payment.atomtech.in/paynetz/epi/fts';
    protected $testEndPoint = 'https://paynetzuat.atomtech.in/paynetz/epi/fts';
    public $response = '';
	
	function __construct()
	{
		$this->atomlogin 	  = Config::get('indipay.Atom.ATOM_LOGIN');
        $this->atompassword   = Config::get('indipay.Atom.ATOM_PASSWORD');
        $this->atomport    	  = Config::get('indipay.Atom.ATOM_PORT');
        $this->atomproid      = Config::get('indipay.Atom.ATOM_PRO_ID');
        $this->atomclientcode = Config::get('indipay.Atom.ATOM_CLIENT_CODE');

        $this->parameters['atomlogin']        = $this->atomlogin;
        $this->parameters['atompassword']     = $this->atompassword;
        $this->parameters['atomport']         = $this->atomport;
        $this->parameters['atomproid']        = $this->atomproid;
        $this->parameters['atomclientcode']   = $this->atomclientcode;
        $this->parameters['txnid']            = $this->generateTransactionID();
        $this->parameters['surl']             = url(Config::get('indipay.Atom.successUrl'));
	}

	public function getEndPoint()
    {
        return $this->testMode?$this->testEndPoint:$this->liveEndPoint;
    }

    public function request($parameters)
    {

    	$datenow = date("d/m/Y h:i:s");
		
		$modifiedDate = str_replace(" ", "%20", $datenow);
        
        $this->parameters = array_merge($this->parameters,$parameters);

        $this->checkParameters($this->parameters);
        
        $arraytourl = '&login='.$this->parameters['atomlogin'].'&pass='.$this->parameters['atompassword'].'&ttype=NBFundTransfer'.'&prodid='.$this->parameters['atomproid'].'&amt='.$this->parameters['Amount'].'&txncurr=INR'.'&txnscamt=0'.'&clientcode='.$this->parameters['atomclientcode'].'&txnid='.$this->parameters['txnid'].'&date='.$modifiedDate.'&custacc=1234567890'.'&udf2='.$this->parameters['email'].'&udf3='.$this->parameters['phone'].'&ru='.$this->parameters['surl'];
        
        $atomurl =  $this->callatompaymentgateway($arraytourl);

        return $atomurl;

    }
    

    public function checkParameters($parameters)
    {
        
        $validator = Validator::make($parameters, [
            'atomlogin'        => 'required',
            'atompassword'     => 'required',
            'atomport'         => 'required',
            'atomproid'        => 'required',
            'atomclientcode'   => 'required',
            'surl'             => 'required',
            'phone'            => 'required',
            'Amount'           => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            throw new AtomParametermissingException;
        }

    }

    public function generateTransactionID()
    {
        return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    }

    public function callatompaymentgateway($parameters)
    {
    	
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getEndPoint());
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_PORT ,$this->parameters['atomport']); 
		curl_setopt($ch, CURLOPT_SSLVERSION,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);

		$content = curl_exec($ch);
		curl_close($ch);
		
		$xmlObjArray = $this->xmltoarray($content);

		$postFields  = "";
		$postFields .= "&ttype=NBFundTransfer";
		$postFields .= "&tempTxnId=".$xmlObjArray['tempTxnId'];
		$postFields .= "&token=".$xmlObjArray['token'];
		$postFields .= "&txnStage=1";
		$url = $this->getEndPoint()."?".$postFields;

		$tempId = $xmlObjArray['tempTxnId'];

		return $url;
    
    }

    public function xmltoarray($data)
    {
		
		$parser = xml_parser_create('');
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); 
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($data), $xml_values);
		xml_parser_free($parser);
		$returnArray = array();
		$returnArray['url'] = $xml_values[3]['value'];
		$returnArray['tempTxnId'] = $xml_values[5]['value'];
		$returnArray['token'] = $xml_values[6]['value'];

		return $returnArray;
	
	}

	public function response($request)
	{
		$response = $request->all();

		return $response;
	}
}