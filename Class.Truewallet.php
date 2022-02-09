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

		public function RequestLoginOTP() {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("RequestLoginOTP/".$this->phoneNumber."/".$this->Passkey);
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

		public function GetTransactionReport($report_id) {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("GetTransactionReport/".$this->phoneNumber."/".$this->Passkey."/".$report_id);
		}

		public function DraftTransferP2P($mobile_number, $amount) {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("DraftTransferP2P/".$this->phoneNumber."/".$this->Passkey."/".$mobile_number."/".$amount);
		}

		public function ConfirmTransferP2P($draft_transaction_id, $reference_key) {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("ConfirmTransferP2P/".$this->phoneNumber."/".$this->Passkey."/".$draft_transaction_id."/".$reference_key);
		}		

		public function Fast_P2P($mobile_number, $amount) {
			if (is_null($this->Passkey) || is_null($this->phoneNumber)) return false; 
			return $this->request("Fast_P2P/".$this->phoneNumber."/".$this->Passkey."/".$mobile_number."/".$amount);
		}

											
	}
	
	
		$tw = new iWallet( "xxxxxxxx","xxxxxxxx" );
		
		//$row = $tw->RequestLoginOTP();
		//$row = $tw->SubmitLoginOTP("369831", "PGZT");
		
		//$row = $tw->GetProfile();
		//$row = $tw->GetBalance();
		
		//$row = $tw->GetTransaction();
		//$row = $tw->GetTransactionReport("npah3219290895");
		
		//$row = $tw->DraftTransferP2P("0639866960", "1");
		//$row = $tw->ConfirmTransferP2P("c7618c9a-0ac8-4b00-9ed2-7fe6b01c5664", "P2P_202202012f29e71276e34dcdb147684ab59df17e");
		//$row = $tw->Fast_P2P("0639866960", "1");
		
		print_r($row);

    /*-----TMN 5.31.0-----*/
				
		
		
		
				
?> 
