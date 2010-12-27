<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Geocoders {

    public static $proxyAddr = NULL;
    public static $proxyPort = NULL;
    public static $proxyUser = NULL;
    public static $proxyPass = NULL;
    public static $requestTimeout = NULL;
    public static $yahoo = 'REPLACE_WITH_YOUR_YAHOO_KEY';
    public static $google = 'REPLACE_WITH_YOUR_GOOGLE_KEY';
    public static $geocoderUs = false;
    public static $geocoderCa = false;
    public static $geonames = false;
    public static $providerOrder = array('google', 'us');
    public static $ip_providerOrder = array('geo_plugin','ip');
    //public static $logger;
    public static $domain = NULL;

}
?>
