<?php
// Start connect to the API Server
function checklicense()
{
    $license = "Arb4sMQ3Ovm7b";
    $hash = "26f738e86e6f93ce9ed223cc48f512bd";
    $thmvrsn = "1.0";


    $product_key = "549a85845ce8d96e32a75c9d";
    $domain = "hesk.com";

    // global $license, $hash, $thmvrsn;
    //  $url = "http://api.arb4host.net/licenses/newchecker.php";
    $url = "http://async777.com/api/license/registration/";
    //$postinfo = "license=" . $license . "&hash=" . $hash . "&version=" . $thmvrsn;
    $postinfo = "domain=" . $domain . "&product_key=" . $product_key;
    $agent = $_SERVER["HTTP_USER_AGENT"];
    //$cookipath = get_template_directory().'/cookie.txt';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookipath);
//    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookipath);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_exec($ch);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;

}

// End connect to the API Server

$check_license = checklicense();
$check_license = json_decode($check_license, true);
print_r($check_license);
die("ended right here");