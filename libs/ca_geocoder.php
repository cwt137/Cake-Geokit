<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CaGeocoder
 *s
 */
class CaGeocoder extends Geocoder {

    /**
     * Template method which does the geocode lookup.
     *
     * @param GeoLocComponent $address
     * @param array $options
     */
    private static function doGeocode($address, $options = array()) {
        if(!($address instanceof GeoLocComponent)) {
            throw new Exception('Geocoder.ca requires a GeoLocComponet argument');
        }

        $url = self::constructRequest($address);
        $res = self::callGeocoderService($url);

    }
    
    /**
     * Formats the request in the format acceptable by the CA geocoder.
     *
     * @param GeoLocComponent $location 
     */
    private static function constructRequest($location) {
        $url  = '';
        if(!empty($location->getStreetAddress())) {
            
            $url += self::addAmpersand($url) + "stno=" + $location->getStreetNumber();
            $url += self::addAmpersand($url) + "addresst=" + InflectorComponent::urlEscape($location->getStreetName());
        }

        if(!empty($location->getCity())) {

            $url += self::addAmpersand($url) + "city=" + InflectorComponent::urlEscape($location->getCity());
        }

        return $url;
    }

    /**
     *
     *
     * @param string $url
     * @return string
     */
    private static function addAmpersand($url) {
        if(!empty ($url) and strlen($url) > 0) {
            return '&';
        }

        return '';
    }

}
?>
