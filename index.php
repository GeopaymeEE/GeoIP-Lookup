<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK href="main.css" rel="stylesheet" type="text/css">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>IP Lookup Tool
</title>
</head>


<body>
<div id="header">
  <div class="title">GeoIP Lookup Tool</div>
</div>
<div id="dbdate">
  <?php
    //ini_set('display_errors', 'on');
    //error_reporting(E_ALL | E_STRICT);  
    date_default_timezone_set('America/Denver');
    
    //Modify these for your environment
    $path = '/var/www/html/maxmind/maxmind_db/';
    $country_db = "{$path}GeoIP-106/GeoIP.dat";
    $city_db = "{$path}GeoIP-133/GeoLiteCity.dat";
    $org_db = "{$path}GeoIP-111/GeoIPOrg.dat";

    function filedate($file,$name) {
        if (file_exists($file)) {
            echo "<p>" . "$name database timestamp: " . date ("F d Y", filemtime($file)) . "</p>";
        } else {
            echo "$name database: File was not found</p>";
       }
    }

    filedate($org_db,"Organization");
    filedate($country_db,"Country");
    filedate($city_db,"City");
   ?>

</div>
<div id="body">
  <form action="geoip.php" method="post">
  <textarea name="ipaddress" cols="45" rows="25" placeholder="Enter a list of IP(s)"></textarea>
</div>
<div id="button">
  <input type="submit">
</form>
</div>

</html>

