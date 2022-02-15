<?php	
    class iWallet { /*----- T M N 5.31.0 -----*/
        private $phoneNumber;
        private $Passkey;		
		public $curl_options = array(
			CURLOPT_SSL_VERIFYPEER => false //lnwseed
		);
		public $api_gateway = "https://3ird.online/Gateway/";
        public function __construct($phoneNumber = null, $Passkey = null) {
            $this->phoneNumber = $phoneNumber;
            $this->Passkey = $Passkey;
		}
		public function request ($api_path, $headers = array(), $data = null) {
			$this->data = null;
			$handle = curl_init($this->api_gateway.ltrim($api_path, "/"));
			if (!is_null($data)) {
				curl_setopt_array($handle, array(
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => is_array($data) ? json_encode($data) : $data
				));
				if (is_array($data)) $headers = array_merge(array("Content-Type" => "application/json"), $headers);
			}
			curl_setopt_array($handle, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => "okhttp/3.8.0",
			CURLOPT_HTTPHEADER => $this->buildHeaders($headers)
			));
			if (is_array($this->curl_options)) curl_setopt_array($handle, $this->curl_options);
			$this->response = curl_exec($handle);
			$this->http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
			if ($result = json_decode($this->response, true)) {
			//if ($result = $this->response) {
				if (isset($result["data"])) $this->data = $result["data"];
				return $result;
			}
			return $this->response;
		}	
		public function buildHeaders ($array) {
			$headers = array();
			foreach ($array as $key => $value) {
				$headers[] = $key.": ".$value;
			}
			return $headers;
		}	

		public function RequestLoginOTP($pass, $pin) {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("RequestLoginOTP/".$this->phoneNumber."/".$pass."/".$pin."/".$this->Passkey);
			

		}	

		public function SubmitLoginOTP($sms, $ref) {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("SubmitLoginOTP/".$this->phoneNumber."/".$sms."/".$ref);
		}	

		public function GetProfile() {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("GetProfile/".$this->phoneNumber."/".$this->Passkey);
		}	

		public function GetBalance() {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("GetBalance/".$this->phoneNumber."/".$this->Passkey);
		}					
						
		public function GetTransaction() {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("GetTransaction/".$this->phoneNumber."/".$this->Passkey);
		}
											
	}
	
	
		$tw = new iWallet( "PHONE","KEY" );
		
		//$row = $tw->RequestLoginOTP("PASS", "PIN");
		//$row = $tw->SubmitLoginOTP("369831", "PGZT");
		
		//$row = $tw->GetProfile();
		//$row = $tw->GetBalance();
		
		//$row = $tw->GetTransaction();

		
		print_r($row);
					
				
?> 
