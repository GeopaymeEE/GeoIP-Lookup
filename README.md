GeoIP-Lookup
============

PHP scripts written to quickly query local Maxmind database for IP organization, city, and country information. 

### Dependencies

* php5
* php-mbstring

I paid for a subscription to the Maxmind IP organization database for a nominal fee. I used the lite country and city databases they provide free of charge. 

### Library Information

The following APIs were provided by the Maxmind and the latest versions can be found on github:

* geoip.inc
* geoipcity.inc
* georegionvars.php

https://github.com/maxmind/geoip-api-php

### Directory Setup

The following files need to be configured for your webserver directory structure:

* index.php
* geoip.php

The variables are near the top of the scripts and are commented with path information. For testing, I had everything in the top level web directory and a sub directory that held the maxmind database files.  

### Information

The script provides error checking to insure the information provided is an IP address, it discards any invalid entries. It also allows users to export the results into a randomized CSV file. It is also wise to setup a cronjob to delete old CSV files from the directory where the CSV files are generated. I didn't add this functionality into the script in case these files wanted to be kept long term. The geoip_update.php script was implemented in an older version of the program but is no longer used. I need to update it to auto pull org information from Maxmind. Results are returned very quickly, even when searching for thousands of entries. Make sure you give PHP enough memory resources if you will be doing lots of queries.  

I am not a web developer/designer by trade, sorry if the design is a bit dated :).  

### Screenshots

Main Interface - Smart enough to identify real IP addresses from random text. Also, IP information can be entered in any fashion as long as there is a space between IP addresses. 

![Main Page](https://github.com/seth-paxton/GeoIP-Lookup/blob/master/screenshot1.png?raw=true)

Results - Results are shown in a table. They can be highlighted by mouseover. Results can be exported using the "Export CSV" button.

![Results](https://github.com/seth-paxton/GeoIP-Lookup/blob/master/screenshot2.png?raw=true)
