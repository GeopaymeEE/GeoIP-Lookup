<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK href="main.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Results
</title>
</head>

<body>
<div id="header">
  <div class="title">GeoIP Lookup Results</div>
</div>
<br /><br /><br />

<?php
//Seth Paxton v.1.1
//ini_set('display_errors', 'on');
//error_reporting(E_ALL | E_STRICT);

include("geoip.inc");
include("geoipcity.inc");
include("geoipregionvars.php");

//DB file locations, modify to fit your environment. 
$dbpath = '/var/www/html/maxmind/maxmind_db';
$gi = geoip_open("{$dbpath}/GeoIP-106/GeoIP.dat",GEOIP_STANDARD);
$org = geoip_open("{$dbpath}/GeoIP-111/GeoIPOrg.dat",GEOIP_STANDARD);
$city = geoip_open("{$dbpath}/GeoIP-133/GeoLiteCity.dat",GEOIP_STANDARD);
$csvpath = '/maxmind/maxmind_db/';
$fname = "/export_maxmind_{$random}.csv";

//Do not modify. 
$ip = preg_split("/[\s,]+/", $_POST["ipaddress"]);
$random = substr(md5(rand()),0,5);
$fp = fopen("{$dbpath}{$fname}", 'w');

//HEADER
$header = array("IP Address", "Country Code", "Country Name", "Region", "City", "Zip code", "Organization");

echo "<table>";
echo "<tr>";
echo "<thead>";

foreach ($header as $title) {
    echo "<th>" . $title . "</th>";
}
echo "</tr>";
echo "</thead>";

//IP INFORMATION
foreach ($ip as $address) {

    if (empty($address)) {
        continue;
    }
  
    if (filter_var($address, FILTER_VALIDATE_IP)) {
           $record = geoip_record_by_addr($city, $address);
           echo "<tr>";
           echo "<td>" . $address . "</td>";
           echo "<td>" . geoip_country_code_by_addr($gi, $address) . "</td>";
           echo "<td>" . geoip_country_name_by_addr($gi, $address) . "</td>";
           echo "<td>" . $record->region . "</td>"; 
           echo "<td>" . $record->city . "</td>"; 
           echo "<td>" . $record->postal_code . "</td>"; 
           echo "<td>" . geoip_org_by_addr($org, $address) . "</td>";
           echo "</tr>";
    } else {
        echo "ERROR: " . $address . " is an invalid ip";
        echo "<br />";
    }
} 
echo "</tr>";
echo "</table>";

//CSV Functionality
fputcsv($fp, $header);

foreach ($ip as $address) {

    if (empty($address)) {
        continue;
    }

    if (filter_var($address, FILTER_VALIDATE_IP)) {
	$record = geoip_record_by_addr($city, $address);
        $values = array();
        $values[] = $address;
        $values[] = geoip_country_code_by_addr($gi, $address);
 	$values[] = geoip_country_name_by_addr($gi, $address);
 	$values[] = $record->region;
 	$values[] = $record->city;
        $values[] = $record->postal_code; 
        $values[] = geoip_org_by_addr($org, $address);
        fputcsv($fp, $values);
    }
}

echo "<br />";
echo "<a href={$csvpath}{$fname}>Download CSV</a>";
fclose($fp);

?>
