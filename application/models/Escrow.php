<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 class Escrow extends CI_Model {
   	public function __construct()
         {
                 parent::__construct();
                 // Your own constructor code
         }
	private $Email = 'billing@appdrawing.com';
	private $Password = 'LwEoN021w$AV';
	private $Key = '336_yLkASl6PXpdAZrFciTpqGwhkqSunGqxvscuzPz8GDBOmR3NaX7lfhnCmpVVgkZeM';
	private $ApiUrl = 'https://api.escrow-sandbox.com/2017-09-01/';
	
	public function CreateCustomer($data){
		 
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->ApiUrl.'customer',
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_USERPWD => $this->Email.':'.$this->Key,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
			CURLOPT_POSTFIELDS => json_encode(
				array(
					'phone_number' => $data['phone_number'],
					'first_name' => $data['first_name'],
					'last_name' => $data['last_name'],
					'middle_name' => '',
					'address' => array( 
						'city' => $data['city'],
						'post_code' => $data['post_code'],
						'country' => $data['country'],
						'line2' => $data['line2'],
						'line1' => $data['line1'],
						'state' => $data['state'],
					),
					'email' => $data['email'],
				)
			)
		)); 
 		$output = curl_exec($curl);
  		curl_close($curl);
		return json_decode($output,true);
	}
	
	public function CreateTransction($data){
		$curl = curl_init();
		 curl_setopt_array($curl, array(
			CURLOPT_URL => $this->ApiUrl.'transaction',
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_USERPWD => $this->Email.':'.$this->Password,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
			CURLOPT_POSTFIELDS => json_encode(
				array(
					'currency' => 'usd',
					'items' => array(
						array(
							'description' => $data['description'],
							'schedule' => array(
								array(
									'payer_customer' => 'me',
									'amount' => $data['amount'],
									'beneficiary_customer' => $data['email'],
								), 
							),
							'title' => $data['title'],
							'inspection_period' => '259200',
							'type' => 'domain_name',
							'quantity' => '1',
						) 
					),
					'description' => $data['description'],
					'parties' => array(
						array(
							'customer' => 'me',
							'role' => 'buyer',
						),
						array(
							'customer' => $data['email'],
							'role' => 'seller',
						)
					),
				)
			)
		));
		
 		$output = curl_exec($curl);
  		curl_close($curl);
		return json_decode($output,true);
	}



 }