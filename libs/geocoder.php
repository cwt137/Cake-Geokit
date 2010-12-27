<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Geocoder
 *
 */
class Geocoder extends Geocoders {

    /**
     *
     * @param string $url
     */
    public static function callGeocoderService($url) {

    }

    /**
     *
     * @param LatLngComponent $latLng
     * @return GeoLocComponent
     */
    public static function doReverseGeocode($latLng) {
        return new GeoLocComponent();
    }

    /**
     *
     * @param string $address
     * @param array $options
     * @return GeoLocComponent
     */
    public static function geocode($address, $options = array ()) {
        //$res =
    }

    /**
     *
     * @param <type> $latLng
     */
    public static function reverseGeocode($latLng) {
        $res = static::doReverseGeocode($latLng);

        if($res->getSuccess()) {
            return $res;
        } else {
            return new GeoLocComponent();
        }
    }

    protected static function logger() {

    }

    private static function doGet($url) {
        
    }


    //put your code here
}
?>
