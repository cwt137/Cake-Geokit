<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//if(!class_exists('LatLng')) {
//    App::import('libs', 'geokit.lat_lng', FALSE);
//}

/**
 * Description of Mappable
 *
 * @author cwthomas
 */
abstract class Mappable {
    const  PI_DIV_RAD = 0.0174;
    const  KMS_PER_MILE = 1.609344;
    const  NMS_PER_MILE = 0.868976242;
    const  EARTH_RADIUS_IN_MILES = 3963.19;
    const  EARTH_RADIUS_IN_KMS = 6376.77271;//EARTH_RADIUS_IN_MILES * KMS_PER_MILE;
    const  EARTH_RADIUS_IN_NMS = 3443.917952532;//EARTH_RADIUS_IN_MILES * NMS_PER_MILE;
    const  MILES_PER_LATITUDE_DEGREE = 69.1;
    const  KMS_PER_LATITUDE_DEGREE = 111.1819; //MILES_PER_LATITUDE_DEGREE * KMS_PER_MILE;
    const  NMS_PER_LATITUDE_DEGREE = 60.046258322; //MILES_PER_LATITUDE_DEGREE * NMS_PER_MILE;
    const  LATITUDE_DEGREES = 57.354413893; //EARTH_RADIUS_IN_MILES / MILES_PER_LATITUDE_DEGREE;
    //put your code here


    /**
     *
     * @param <type> $from
     * @param <type> $to
     * @param <type> $options
     * @return float
     */
    public static function distanceBetween($from, $to, $options = array()) {
        $from = LatLng::normalize($from);
        $to = LatLng::normalize($to);
        if($from == $to) {
            return 0.0;
        }
        
        if(isset ($options['units'])) {
            $units = $options['units'];
        } else {
            $units =  Configure::read('Geokit.default_units');
        }
        
        if(isset ($options['formula'])) {
            $formula = $options['formula'];
        } else {
            $formula = Configure::read('Geokit.default_formula');
        }
        
        switch ($formula) {
            case 'sphere':
                $tmpVal  = Mappable::_unitsSphereMultiplier($units) *
                acos(sin(Mappable::_deg2rad($from->getLat())) * sin(Mappable::_deg2rad($to->getLat())) +
                cos(Mappable::_deg2rad($from->getLat())) * cos(Mappable::_deg2rad($to->getLat())) *
                cos(Mappable::_deg2rad($to->getLng()) - Mappable::_deg2rad($from->getLng())));
                
                return $tmpVal;
                break;

            case 'flat':
                $tmpVal = sqrt(pow((Mappable::_unitsPerLatitudeDegree($units)*($from->getLat() - $to->getLat())),2) +
              pow((Mappable::_unitsPerLongitudeDegree($from->getLat(), $units)*($from->getLng() - $to->getLng())),2));

                return $tmpVal;
                break;
        }
    }

    /**
     *
     * @param <type> $from
     * @param <type> $to
     * @return float
     */
    public static function headingBetween($from, $to) {
        $from = LatLng::normalize($from);
        $to = LatLng::normalize($to);

        $dLng = LatLng::_deg2rad($to->getLng() - $from->getLng());
        $fromLat = LatLng::_deg2rad($from->getLat());
        $toLat = LatLng::_deg2rad($to->getLat());
        $y = sin($dLng) * cos($toLat);
        $x = cos($fromLat) * sin($toLat) - sin($fromLat) * cos($toLat) * cos($dLng);
        $heading = Mappable::_toHeading(atan2($y, $x));

        return $heading;
    }

    /**
     *
     * @param <type> $start
     * @param <type> $heading
     * @param <type> $distance
     * @param <type> $options
     * @return LatLng
     */
    public static function endpoint($start, $heading, $distance, $options = array ()) {
        
        if(isset ($options['units'])) {
            $units = $options['units'];
        } else {
            $units =  Configure::read('Geokit.default_units');
        }
        
        switch ($units) {
            case 'kms':
                $radius = Mappable::EARTH_RADIUS_IN_KMS;
                break;
            case 'nms':
                $radius = Mappable::EARTH_RADIUS_IN_KMS;                
                break;
            default:
                $radius = Mappable::EARTH_RADIUS_IN_MILES;
                break;
        }
        
        $start = LatLng::normalize($start);
        $lat = Mappable::_deg2rad($start->getLat());
        $lng = Mappable::_deg2rad($start->getLng());
        $heading = Mappable::_deg2rad($heading);
        $distance = (float) $distance;
        
        $endLat = asin(sin($lat) * cos($distance/$radius) +
                          cos($lat) * sin($distance/$radius) * cos($heading));

        $endLng = $lng + atan2(sin($heading) * sin($distance/$radius) * cos($lat),
                               cos($distance/$radius) - sin($lat) * sin($endLat));

        return new LatLng(Mappable::_rad2deg($endLat), Mappable::_rad2deg($endLng));
    }

    /**
     *
     * @param <type> $from
     * @param <type> $to
     * @param <type> $options
     * @return LatLngComponennt
     */
    public static function midpointBetween($from, $to, $options = array ()) {
        $from = LatLng::normalize($from);

        if(isset ($options['units'])) {
            $units = $options['units'];
        } else {
            $units =  Configure::read('Geokit.default_units');
        }

        $heading = $from->headingTo($to);
        $distance = $from->distanceTo($to, $options);
        $midpoint = $from->endpoint2($heading,($distance/2),$options);
        return $midpoint;
    }

    /**
     *
     * @param <type> $location
     * @param array $options
     * @return GeoLocComponent
     */
    public static function geocode($location, $options = array()) {

    }

    /**
     *
     * @param float $degrees
     * @return float
     */
    protected static function _deg2rad($degrees) {
        //return (floatval($degrees) / 180 * M_PI);
        return deg2rad($degrees);
    }

    /**
     *
     * @param float $rad
     * @return float
     */
    protected static function _rad2deg($rad) {
        //return (floatval($rad) * 180 / M_PI);
        return rad2deg($rad);
    }

    /**
     *
     * @param float $rad
     * @return float
     */
    protected static function _toHeading($rad) {
        return ((self::_rad2deg($rad) + 360) % 360);
    }

    /**
     *
     * @param string $units
     */
    protected static function _unitsSphereMultiplier($units) {
        if($units == 'kms') {
            return self::EARTH_RADIUS_IN_KMS;
        } elseif($units == 'nms') {
            return self::EARTH_RADIUS_IN_NMS;
        } else {
            return self::EARTH_RADIUS_IN_MILES;
        }

    }

    /**
     *
     * @param string $units
     */
    protected static function _unitsPerLatitudeDegree($units) {
        if($units == 'kms') {
            return self::KMS_PER_LATITUDE_DEGREE;
        } elseif($units == 'nms') {
            return self::NMS_PER_LATITUDE_DEGREE;
        } else {
            return self::MILES_PER_LATITUDE_DEGREE;
        }
    }

    /**
     *
     * @param float $lat
     * @param string $units
     * @return float
     */
    protected static function _unitsPerLongitudeDegree($lat, $units) {
        $milesPerLongitudeDegree = abs(self::LATITUDE_DEGREES * cos($lat * self::PI_DIV_RAD));

        if($units == 'kms') {
            return $milesPerLongitudeDegree * self::KMS_PER_MILE;
        } elseif($units == 'nms') {
            return $milesPerLongitudeDegree * self::NMS_PER_MILE;
        } else {
            return $milesPerLongitudeDegree;
        }

    }

    /**
     *
     * @param <type> $other
     * @param <type> $options
     * @return float
     */
    public function distanceTo($other, $options = array ()) {
        return Mappable::distanceBetween($this, $other, $options);
    }

    /**
     *
     * @param <type> $other
     * @param <type> $options
     * @return float
     */
    public function distanceFrom($other, $options = array ()) {

    }

    /**
     *
     * @param <type> $other
     * @return float
     */
    public function headingTo($other) {
        return Mappable::headingBetween($this, $other);
    }

    /**
     *
     * @param <type> $other
     * @return float
     */
    public function headingFrom($other) {
        return Mappable::headingBetween($other, $this);
    }

    /**
     *
     * @param <type> $heading
     * @param <type> $distance
     * @param <type> $options
     * @return LatLng
     */
    public function endpoint2($heading, $distance, $options = array()) {
        return Mappable::endpoint($this, $heading, $distance, $options);

    }

    /**
     *
     * @param <type> $other
     * @param <type> $options
     * @return LatLng
     */
    public function midpointTo($other, $options = array()) {
        return Mappable::midpointBetween($this, $other, $options);
    }
}
?>
