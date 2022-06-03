<?php	
    class iWallet { /*----- T M N 5.35.0 -----*/
        private $phoneNumber;
        private $Pass;
		private $Pin;		
		public $curl_options = array(
			CURLOPT_SSL_VERIFYPEER => false 
		);
		public $api_gateway = "https://truewallet.me/";
        public function __construct($phoneNumber = null, $Pass = null, $Pin = null) {
            $this->phoneNumber = $phoneNumber;
            $this->Pass = $Pass;
			$this->Pin = $Pin;
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
			if (is_null($this->Pass) || is_null($this->phoneNumber)) return false; 
			return $this->request("otp.php?phone=".$this->phoneNumber."&pin=".$Pin."&pass=".$this->Pass."&pin=".$this->Pin."&type=RequestLoginOTP");
		}	

		public function SubmitLoginOTP($sms, $ref) {
			if (is_null($this->Pass) || is_null($this->phoneNumber)) return false; 
			return $this->request("otp.php?phone=".$this->phoneNumber."&pin=".$Pin."&pass=".$this->Pass."&pin=".$this->Pin."&type=SubmitLoginOTP&otp=".$sms."&ref=".$ref);
		}	

		public function GetProfile() {
			if (is_null($this->Pin) || is_null($this->phoneNumber)) return false; 
			return $this->request("iden.php?phone=".$this->phoneNumber."&pin=".$Pin."&type=Profile");
		}	

		public function GetBalance() {
			if (is_null($this->Pin) || is_null($this->phoneNumber)) return false; 
			return $this->request("iden.php?phone=".$this->phoneNumber."&pin=".$Pin."&type=Balance");
		}					
						
		public function GetTransaction() {
			if (is_null($this->Pin) || is_null($this->phoneNumber)) return false; 
			return $this->request("iden.php?phone=".$this->phoneNumber."&pin=".$Pin."&type=Transaction");
		}

		public function Login_nox() {
			if (is_null($this->Pin) || is_null($this->phoneNumber)) return false; 
			return $this->request("iden.php?phone=".$this->phoneNumber."&pin=".$Pin."&type=Login");
		}
		
		public function Checkname($phone) {
			if (is_null($this->Pin) || is_null($this->phoneNumber)) return false; 
			return $this->request("iden.php?phone=".$this->phoneNumber."&pin=".$Pin."&ref=".$phone."&type=Cp2p");
		}
		
		public function P2p($phone, $amount) {
			if (is_null($this->Pin) || is_null($this->phoneNumber)) return false; 
			return $this->request("iden.php?phone=".$this->phoneNumber."&pin=".$Pin."&ref=".$phone."&amount=".$amount."&type=P2p");
		}							
											
	}
	
		### 1 กรอกข้อมูลบัญชีทรูวอลเล็ท
		//$tw = new iWallet( "PHONE","PASS", "PIN" );
		
		### 2 ขอโอทีพีและยืนยันบัญชีก่อนใช้งาน
		//$row = $tw->RequestLoginOTP();
		//$row = $tw->SubmitLoginOTP("111834", "NXZK");
		
		//$row = $tw->GetProfile(); // รายละเอียดโปรไฟล์
		//$row = $tw->GetBalance(); // เชคยอดเงินคงเหลือ
		//$row = $tw->GetTransaction(); // ดึง reportid
		
		//$row = $tw->Checkname("0639866960"); // เชคชื่อบัญชี
		//$row = $tw->P2p("0639866960", "10"); // โอนเงินทันที



/*
		$tw->Login_nox(); 
		$row = $tw->GetTransaction();
*/
		
		print_r($row);
		
		
			
?> 
