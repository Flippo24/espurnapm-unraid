<?php
$espurnapm_cfg = parse_ini_file( "/boot/config/plugins/espurnapm/espurnapm.cfg" );
$espurnapm_device_ip	= isset($espurnapm_cfg['DEVICE_IP']) ? $espurnapm_cfg['DEVICE_IP'] : "";
$espurnapm_device_api	= isset($espurnapm_cfg['DEVICE_API']) ? $espurnapm_cfg['DEVICE_API'] : "";
$espurnapm_costs_price	= isset($espurnapm_cfg['COSTS_PRICE']) ? $espurnapm_cfg['COSTS_PRICE'] : "0.0";
$espurnapm_costs_unit	= isset($espurnapm_cfg['COSTS_UNIT']) ? $espurnapm_cfg['COSTS_UNIT'] : "USD";

if ($espurnapm_device_ip == "") {
	die("ESPurna Device IP missing!");
}

if ($espurnapm_device_api == "") {
	die("ESPurna Api key missing!");
}

$json = array(
	'Power' => getvalue($espurnapm_device_ip,"power",$espurnapm_device_api),
	'Voltage' => getvalue($espurnapm_device_ip,"voltage",$espurnapm_device_api),
	'Current' => getvalue($espurnapm_device_ip,"current",$espurnapm_device_api),
	'Factor' => getvalue($espurnapm_device_ip,"factor",$espurnapm_device_api),
	'Energy' => getvalue($espurnapm_device_ip,"energy",$espurnapm_device_api),
	'ApparentPower' => getvalue($espurnapm_device_ip,"apparent",$espurnapm_device_api),
	'ReactivePower' => getvalue($espurnapm_device_ip,"reactive",$espurnapm_device_api),
	'Costs_Price' => $espurnapm_costs_price,
	'Costs_Unit' => $espurnapm_costs_unit
);

//header('Content-Type: application/json');
echo json_encode($json);

function getvalue($ip,$param,$apikey) {
	$Url = "http://" . $ip . "/api/" . $param . "?apikey=" . $apikey;
	$curl = curl_init($Url);
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
	$result = curl_exec($curl);
	$result1 = isset($result) ? $result : "0";
	return $result1; 
}

?>