<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CartModel extends CI_Model {

  	public function __construct()

        {

                parent::__construct();

                // Your own constructor code

        }

  	private $Cart='carts';

	public function AddToCart($p_id,$qty){

		

		$guest_user_id; 

		

		if(isset($this->session->userdata['User']['role']) != ''){

			$guest_user_id = $this->session->userdata['User']['id'];

		}else{

		

			if($this->session->userdata('guest_user_id') != ''){

				$guest_user_id=$this->session->userdata('guest_user_id');

			}else{

				$guest_user_id=$this->GuestUserSeesion();

  			}

		}

  	  

		$condition=['guest_user_id'=>$guest_user_id, 'p_id' => $p_id];

		

		$this->db->select('*');

		$this->db->from($this->Cart);

		$this->db->where($condition);

   		$prevQuery = $this->db->get();

		$prevCheck = $prevQuery->num_rows();

 		if($prevCheck > 0){

 			 //echo 'update cart row';

			 return $this->GetCartItems();

		 } else {

 			$res = $this->db->insert($this->Cart, ['guest_user_id'=>$guest_user_id, 'p_id' => $p_id,'qty' =>$qty] );

			if($res == 1){

				return $this->GetCartItems();

			}else

				return false;

		 }

		 

 	}

	public function GetCartItems(){

		

		$guest_user_id;

		if(isset($this->session->userdata['User']['role']) != ''){

			$guest_user_id = $this->session->userdata['User']['id'];

		}else{

			$guest_user_id = $this->session->userdata('guest_user_id');

 		}

		

		

		$this->db->select('*');

		$this->db->from($this->Cart);

		$this->db->where('guest_user_id',$guest_user_id);

		$q = $this->db->get();

 		

			if($q ){

 				return $q->result_array();

 			}else

 				return false;

	}

	

	public function GuestUserSeesion(){

		

 		$this->db->select_max('id');

		$this->db->from($this->Cart);

		$query = $this->db->get();

		$res = $query->row_array();

		$guest_user_id = $res['id'];

		if(empty($guest_user_id)){$guest_user_id=rand(10,1000);}

		

 		$this->session->set_userdata('guest_user_id',$guest_user_id);

		return $this->session->userdata('guest_user_id');

	}

	

	public function GetGuestUserDataLoginTime($guest_user_id){

		$this->db->select('*');

		$this->db->from($this->Cart);

		$this->db->where('guest_user_id',$guest_user_id);

		$q = $this->db->get();

 		if($q ){

 			return $q->result_array();

 		}else

 			return false;

	

	}

	public function UpdateGuestUserDataLoginSuccess($guest_user_id,$current_user_login_id)

	{  

 		$res = $this->db->update($this->Cart,['guest_user_id' => $current_user_login_id],['guest_user_id' => $guest_user_id ] ); 

		if($res == 1)

			return true;

		else

			return false;

 	}

	

	public function TrashCartItemsAfterAddOrder(){

		

		$guest_user_id;

		if(isset($this->session->userdata['User']['role']) != ''){

			$guest_user_id = $this->session->userdata['User']['id'];

		}else{

			$guest_user_id = $this->session->userdata('guest_user_id');

 		}

		

 		$res = $this->db->delete($this->Cart,['guest_user_id' => $guest_user_id ] ); 

 		if($res == 1)

 			return true;

 		else

 			return false;

			

 	}

  
  public function Countries(){

  	

	$countries = array(

    'AF'=>'AFGHANISTAN',

    'AL'=>'ALBANIA',

    'DZ'=>'ALGERIA',

    'AS'=>'AMERICAN SAMOA',

    'AD'=>'ANDORRA',

    'AO'=>'ANGOLA',

    'AI'=>'ANGUILLA',

    'AQ'=>'ANTARCTICA',

    'AG'=>'ANTIGUA AND BARBUDA',

    'AR'=>'ARGENTINA',

    'AM'=>'ARMENIA',

    'AW'=>'ARUBA',

    'AU'=>'AUSTRALIA',

    'AT'=>'AUSTRIA',

    'AZ'=>'AZERBAIJAN',

    'BS'=>'BAHAMAS',

    'BH'=>'BAHRAIN',

    'BD'=>'BANGLADESH',

    'BB'=>'BARBADOS',

    'BY'=>'BELARUS',

    'BE'=>'BELGIUM',

    'BZ'=>'BELIZE',

    'BJ'=>'BENIN',

    'BM'=>'BERMUDA',

    'BT'=>'BHUTAN',

    'BO'=>'BOLIVIA',

    'BA'=>'BOSNIA AND HERZEGOVINA',

    'BW'=>'BOTSWANA',

    'BV'=>'BOUVET ISLAND',

    'BR'=>'BRAZIL',

    'IO'=>'BRITISH INDIAN OCEAN TERRITORY',

    'BN'=>'BRUNEI DARUSSALAM',

    'BG'=>'BULGARIA',

    'BF'=>'BURKINA FASO',

    'BI'=>'BURUNDI',

    'KH'=>'CAMBODIA',

    'CM'=>'CAMEROON',

    'CA'=>'CANADA',

    'CV'=>'CAPE VERDE',

    'KY'=>'CAYMAN ISLANDS',

    'CF'=>'CENTRAL AFRICAN REPUBLIC',

    'TD'=>'CHAD',

    'CL'=>'CHILE',

    'CN'=>'CHINA',

    'CX'=>'CHRISTMAS ISLAND',

    'CC'=>'COCOS (KEELING) ISLANDS',

    'CO'=>'COLOMBIA',

    'KM'=>'COMOROS',

    'CG'=>'CONGO',

    'CD'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE',

    'CK'=>'COOK ISLANDS',

    'CR'=>'COSTA RICA',

    'CI'=>'COTE D IVOIRE',

    'HR'=>'CROATIA',

    'CU'=>'CUBA',

    'CY'=>'CYPRUS',

    'CZ'=>'CZECH REPUBLIC',

    'DK'=>'DENMARK',

    'DJ'=>'DJIBOUTI',

    'DM'=>'DOMINICA',

    'DO'=>'DOMINICAN REPUBLIC',

    'TP'=>'EAST TIMOR',

    'EC'=>'ECUADOR',

    'EG'=>'EGYPT',

    'SV'=>'EL SALVADOR',

    'GQ'=>'EQUATORIAL GUINEA',

    'ER'=>'ERITREA',

    'EE'=>'ESTONIA',

    'ET'=>'ETHIOPIA',

    'FK'=>'FALKLAND ISLANDS (MALVINAS)',

    'FO'=>'FAROE ISLANDS',

    'FJ'=>'FIJI',

    'FI'=>'FINLAND',

    'FR'=>'FRANCE',

    'GF'=>'FRENCH GUIANA',

    'PF'=>'FRENCH POLYNESIA',

    'TF'=>'FRENCH SOUTHERN TERRITORIES',

    'GA'=>'GABON',

    'GM'=>'GAMBIA',

    'GE'=>'GEORGIA',

    'DE'=>'GERMANY',

    'GH'=>'GHANA',

    'GI'=>'GIBRALTAR',

    'GR'=>'GREECE',

    'GL'=>'GREENLAND',

    'GD'=>'GRENADA',

    'GP'=>'GUADELOUPE',

    'GU'=>'GUAM',

    'GT'=>'GUATEMALA',

    'GN'=>'GUINEA',

    'GW'=>'GUINEA-BISSAU',

    'GY'=>'GUYANA',

    'HT'=>'HAITI',

    'HM'=>'HEARD ISLAND AND MCDONALD ISLANDS',

    'VA'=>'HOLY SEE (VATICAN CITY STATE)',

    'HN'=>'HONDURAS',

    'HK'=>'HONG KONG',

    'HU'=>'HUNGARY',

    'IS'=>'ICELAND',

    'IN'=>'INDIA',

    'ID'=>'INDONESIA',

    'IR'=>'IRAN, ISLAMIC REPUBLIC OF',

    'IQ'=>'IRAQ',

    'IE'=>'IRELAND',

    'IL'=>'ISRAEL',

    'IT'=>'ITALY',

    'JM'=>'JAMAICA',

    'JP'=>'JAPAN',

    'JO'=>'JORDAN',

    'KZ'=>'KAZAKSTAN',

    'KE'=>'KENYA',

    'KI'=>'KIRIBATI',

    'KP'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',

    'KR'=>'KOREA REPUBLIC OF',

    'KW'=>'KUWAIT',

    'KG'=>'KYRGYZSTAN',

    'LA'=>'LAO PEOPLES DEMOCRATIC REPUBLIC',

    'LV'=>'LATVIA',

    'LB'=>'LEBANON',

    'LS'=>'LESOTHO',

    'LR'=>'LIBERIA',

    'LY'=>'LIBYAN ARAB JAMAHIRIYA',

    'LI'=>'LIECHTENSTEIN',

    'LT'=>'LITHUANIA',

    'LU'=>'LUXEMBOURG',

    'MO'=>'MACAU',

    'MK'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',

    'MG'=>'MADAGASCAR',

    'MW'=>'MALAWI',

    'MY'=>'MALAYSIA',

    'MV'=>'MALDIVES',

    'ML'=>'MALI',

    'MT'=>'MALTA',

    'MH'=>'MARSHALL ISLANDS',

    'MQ'=>'MARTINIQUE',

    'MR'=>'MAURITANIA',

    'MU'=>'MAURITIUS',

    'YT'=>'MAYOTTE',

    'MX'=>'MEXICO',

    'FM'=>'MICRONESIA, FEDERATED STATES OF',

    'MD'=>'MOLDOVA, REPUBLIC OF',

    'MC'=>'MONACO',

    'MN'=>'MONGOLIA',

    'MS'=>'MONTSERRAT',

    'MA'=>'MOROCCO',

    'MZ'=>'MOZAMBIQUE',

    'MM'=>'MYANMAR',

    'NA'=>'NAMIBIA',

    'NR'=>'NAURU',

    'NP'=>'NEPAL',

    'NL'=>'NETHERLANDS',

    'AN'=>'NETHERLANDS ANTILLES',

    'NC'=>'NEW CALEDONIA',

    'NZ'=>'NEW ZEALAND',

    'NI'=>'NICARAGUA',

    'NE'=>'NIGER',

    'NG'=>'NIGERIA',

    'NU'=>'NIUE',

    'NF'=>'NORFOLK ISLAND',

    'MP'=>'NORTHERN MARIANA ISLANDS',

    'NO'=>'NORWAY',

    'OM'=>'OMAN',

    'PK'=>'PAKISTAN',

    'PW'=>'PALAU',

    'PS'=>'PALESTINIAN TERRITORY, OCCUPIED',

    'PA'=>'PANAMA',

    'PG'=>'PAPUA NEW GUINEA',

    'PY'=>'PARAGUAY',

    'PE'=>'PERU',

    'PH'=>'PHILIPPINES',

    'PN'=>'PITCAIRN',

    'PL'=>'POLAND',

    'PT'=>'PORTUGAL',

    'PR'=>'PUERTO RICO',

    'QA'=>'QATAR',

    'RE'=>'REUNION',

    'RO'=>'ROMANIA',

    'RU'=>'RUSSIAN FEDERATION',

    'RW'=>'RWANDA',

    'SH'=>'SAINT HELENA',

    'KN'=>'SAINT KITTS AND NEVIS',

    'LC'=>'SAINT LUCIA',

    'PM'=>'SAINT PIERRE AND MIQUELON',

    'VC'=>'SAINT VINCENT AND THE GRENADINES',

    'WS'=>'SAMOA',

    'SM'=>'SAN MARINO',

    'ST'=>'SAO TOME AND PRINCIPE',

    'SA'=>'SAUDI ARABIA',

    'SN'=>'SENEGAL',

    'SC'=>'SEYCHELLES',

    'SL'=>'SIERRA LEONE',

    'SG'=>'SINGAPORE',

    'SK'=>'SLOVAKIA',

    'SI'=>'SLOVENIA',

    'SB'=>'SOLOMON ISLANDS',

    'SO'=>'SOMALIA',

    'ZA'=>'SOUTH AFRICA',

    'GS'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',

    'ES'=>'SPAIN',

    'LK'=>'SRI LANKA',

    'SD'=>'SUDAN',

    'SR'=>'SURINAME',

    'SJ'=>'SVALBARD AND JAN MAYEN',

    'SZ'=>'SWAZILAND',

    'SE'=>'SWEDEN',

    'CH'=>'SWITZERLAND',

    'SY'=>'SYRIAN ARAB REPUBLIC',

    'TW'=>'TAIWAN, PROVINCE OF CHINA',

    'TJ'=>'TAJIKISTAN',

    'TZ'=>'TANZANIA, UNITED REPUBLIC OF',

    'TH'=>'THAILAND',

    'TG'=>'TOGO',

    'TK'=>'TOKELAU',

    'TO'=>'TONGA',

    'TT'=>'TRINIDAD AND TOBAGO',

    'TN'=>'TUNISIA',

    'TR'=>'TURKEY',

    'TM'=>'TURKMENISTAN',

    'TC'=>'TURKS AND CAICOS ISLANDS',

    'TV'=>'TUVALU',

    'UG'=>'UGANDA',

    'UA'=>'UKRAINE',

    'AE'=>'UNITED ARAB EMIRATES',

    'GB'=>'UNITED KINGDOM',

    'US'=>'UNITED STATES',

    'UM'=>'UNITED STATES MINOR OUTLYING ISLANDS',

    'UY'=>'URUGUAY',

    'UZ'=>'UZBEKISTAN',

    'VU'=>'VANUATU',

    'VE'=>'VENEZUELA',

    'VN'=>'VIET NAM',

    'VG'=>'VIRGIN ISLANDS, BRITISH',

    'VI'=>'VIRGIN ISLANDS, U.S.',

    'WF'=>'WALLIS AND FUTUNA',

    'EH'=>'WESTERN SAHARA',

    'YE'=>'YEMEN',

    'YU'=>'YUGOSLAVIA',

    'ZM'=>'ZAMBIA',

    'ZW'=>'ZIMBABWE',

   );

  	return $countries;

  }
	

	

 }

