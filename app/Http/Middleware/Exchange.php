<?php

namespace App\Http\Middleware;
use MaxMind\Db\Reader;
use Closure;
//use Jenssegers\Agent\Agent;
class Exchange
{

    public function handle($request, Closure $next)
    {
        if ($request->is('webhooks/whatsapp')) {
            return $next($request);
        }
		//device
        /*if (@session()->get("device")=='') {
		$agent = new Agent();
		$inputs["device_type"] = $agent->device();//Iphone
		$inputs["platform"] = $agent->platform();//iOS
		$inputs["browser"] = $agent->browser();//chrome
		$request->session()->put('device', $inputs);
echo '<pre>';
			print_r(session()->get("device"));
			echo '</pre>';
			exit('dd');
		}*/
		
		
		if(!session()->has("country") or !session()->has("iso_country") or !session()->has("call_country")){
			
			$country_call_code = ["US" => "1","CA" => "1","RU" => "7","KZ" => "7","EG" => "20","ZA" => "27","GR" => "30","NL" => "31","BE" => "32","FR" => "33","ES" => "34","HU" => "36","IT" => "39","RO" => "40","CH" => "41","AT" => "43","GB" => "44","GG" => "44","IM" => "44","JE" => "44","DK" => "45","SE" => "46","NO" => "47","SJ" => "47","PL" => "48","DE" => "49","PE" => "51","MX" => "52","CU" => "53","AR" => "54","BR" => "55","CL" => "56","CO" => "57","VE" => "58","MY" => "60","AU" => "61","CC" => "61","CX" => "61","ID" => "62","PH" => "63","NZ" => "64","SG" => "65","TH" => "66","JP" => "81","KR" => "82","VN" => "84","CN" => "86","TR" => "90","IN" => "91","PK" => "92","AF" => "93","LK" => "94","MM" => "95","IR" => "98","SS" => "211","MA" => "212","EH" => "212","DZ" => "213","TN" => "216","LY" => "218","GM" => "220","SN" => "221","MR" => "222","ML" => "223","GN" => "224","CI" => "225","BF" => "226","NE" => "227","TG" => "228","BJ" => "229","MU" => "230","LR" => "231","SL" => "232","GH" => "233","NG" => "234","TD" => "235","CF" => "236","CM" => "237","CV" => "238","ST" => "239","GQ" => "240","GA" => "241","CG" => "242","CD" => "243","AO" => "244","GW" => "245","IO" => "246","AC" => "247","SC" => "248","SD" => "249","RW" => "250","ET" => "251","SO" => "252","DJ" => "253","KE" => "254","TZ" => "255","UG" => "256","BI" => "257","MZ" => "258","ZM" => "260","MG" => "261","RE" => "262","YT" => "262","ZW" => "263","NA" => "264","MW" => "265","LS" => "266","BW" => "267","SZ" => "268","KM" => "269","SH" => "290","ER" => "291","AW" => "297","FO" => "298","GL" => "299","GI" => "350","PT" => "351","LU" => "352","IE" => "353","IS" => "354","AL" => "355","MT" => "356","CY" => "357","FI" => "358","AX" => "358","BG" => "359","LT" => "370","LV" => "371","EE" => "372","MD" => "373","AM" => "374","BY" => "375","AD" => "376","MC" => "377","SM" => "378","VA" => "379","UA" => "380","RS" => "381","ME" => "382","HR" => "385","SI" => "386","BA" => "387","MK" => "389","CZ" => "420","SK" => "421","LI" => "423","FK" => "500","BZ" => "501","GT" => "502","SV" => "503","HN" => "504","NI" => "505","CR" => "506","PA" => "507","PM" => "508","HT" => "509","GP" => "590","BL" => "592","MF" => "592","BO" => "591","GY" => "592","EC" => "593","GF" => "594","PY" => "595","MQ" => "596","SR" => "597","UY" => "598","CW" => "599","BQ" => "599","TL" => "670","NF" => "672","BN" => "673","NR" => "674","PG" => "675","TO" => "676","SB" => "677","VU" => "678","FJ" => "679","PW" => "680","WF" => "681","CK" => "682","NU" => "683","WS" => "685","KI" => "686","NC" => "687","TV" => "688","PF" => "689","TK" => "690","FM" => "691","MH" => "692","KP" => "850","HK" => "852","MO" => "853","KH" => "855","LA" => "856","BD" => "880","TW" => "886","MV" => "960","LB" => "961","JO" => "962","SY" => "963","IQ" => "964","KW" => "965","SA" => "966","YE" => "967","OM" => "968","PS" => "970","AE" => "971","IL" => "972","BH" => "973","QA" => "974","BT" => "975","MN" => "976","NP" => "977","TJ" => "992","TM" => "993","AZ" => "994","GE" => "995","KG" => "996","UZ" => "998","BS" => "1242","BB" => "1246","AI" => "1264","AG" => "1268","VG" => "1284","VI" => "1340","KY" => "1345","BM" => "1441","GD" => "1473","TC" => "1649","MS" => "1664","GU" => "1671","AS" => "1684","LC" => "1758","DM" => "1767","VC" => "1784","PR" => "1787","DO" => "1809","TT" => "1868","KN" => "1869","JM" => "1876"];
			
			
	        	$isocode = 'US';
				if(isset($_SERVER['GEOIP_COUNTRY_CODE'])){
					$isocode = $_SERVER['GEOIP_COUNTRY_CODE'];
				}
				
				
				//$request->session()->put("country",@$reader->get($ipAddress)['country']['names']['en']);
				$request->session()->put("country",$isocode);
				$request->session()->put("iso_country",$isocode);
				$request->session()->put("call_country",'+' . @$country_call_code[$isocode]);
				
		}
		
		
		
		
		/*
		//currency
        if (@session()->get("currency")=='' ) {//and isset($_SERVER['HTTP_CF_IPCOUNTRY'])
            
			$curr = 'USD';
			switch(session()->get("iso_country")){
				case 'TR':
				$curr = 'TRY';
				break;
				case 'GB':
				$curr = 'GBP';
				break;
				case 'SA':
				$curr = 'SAR';
				break;
				case 'IQ':
				$curr = 'IQD';
				break;
				case 'AE':
				$curr = 'AED';
				break;
				case 'KW':
				$curr = 'KWD';
				break;
				case 'OM':
				$curr = 'OMR';
				break;
				case 'SY':
				$curr = 'SYP';
				break;
				case 'QA':
				$curr = 'QAR';
				break;
				case 'BH':
				$curr = 'BHD';
				break;
				case 'JO':
				$curr = 'JOD';
				break;
				case 'DZ':
				$curr = 'EUR';
				break;
				case 'EG':
				$curr = 'EGP';
				break;
				case 'IL':
				$curr = 'ILS';
				break;
				case 'LY':
				$curr = 'LYD';
				break;
				case 'MA':
				$curr = 'MAD';
				break;
				case 'TN':
				$curr = 'TND';
				break;
				
				
			}
			
			if($curr == 'USD')
			if(in_array(session()->get("iso_country"),array('AD', 'AL', 'AT', 'AX', 'BA', 'BE', 'BG', 'BY', 'CH', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FO', 'FR', 'GG', 'GI', 'GR', 'HR', 'HU', 'IE', 'IM', 'IS', 'IT', 'JE', 'LI', 'LT', 'LU', 'LV', 'MC', 'MD', 'ME', 'MK', 'MT', 'NL', 'NO', 'PL', 'PT', 'RO', 'RS', 'RU', 'SE', 'SI', 'SJ', 'SK', 'SM', 'UA', 'VA')))
			$curr = 'EUR';
			

			//$request->session()->put('currency', $curr);
			
			// user value cannot be found in session
            //return redirect('/');
        }*/
			if(!session()->has("currency"))//cache cloudflare
				$request->session()->put('currency', 'USD');//cache cloudflare

        return $next($request);
    }

}