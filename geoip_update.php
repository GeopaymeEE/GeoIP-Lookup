<?php

$url_country = "http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz";
$url_city = "http://www.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz";

$compressed_city = "GeoLiteCity.dat.gz"; 
$uncompressed_city = "GeoLiteCity.dat";
$compressed_country = "GeoIP.dat.gz";
$uncompressed_country = "GeoIP.dat";

//Download new database

function download($url, $compressed_file) {
    $path = "/var/www/maxmind_db/";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $download = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo "Curl error: " . curl_error($ch);
            echo "<br /><br />Please validate the URL in geoip_update.php"; 
        exit(1);
        }
    
    curl_close($ch);
    file_put_contents($path . $compressed_file, $download);
}

download($url_city, $compressed_city);
download($url_country, $compressed_country);

//Uncompress the new database

function uncompress($srcName, $dstName) {
    $sfp = gzopen($srcName, "rb");
    $fp = fopen($dstName, "w");

        while ($string = gzread($sfp, 4096)) {
            fwrite($fp, $string, strlen($string));
        }
        gzclose($sfp);
        fclose($fp);
        unlink($srcName);
}

function uncompress_action($compressed_file, $file_extract) {
    $path = "/var/www/maxmind_db/";
    if (file_exists($path . $compressed_file)) {
        uncompress($path . $compressed_file, $path . $file_extract);
    } else {
        echo "The file " . $path . $compressed_file . " does not exist";
        exit(1);
    }
}

uncompress_action($compressed_city, $uncompressed_city);
uncompress_action($compressed_country, $uncompressed_country);

echo "<h3>Download Successful</h3>";

echo "<input type=\"button\" onclick=\"history.go(-1);\" value=\"Back\">";
?>
