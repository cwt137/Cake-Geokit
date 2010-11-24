<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists('Mappable')) {
    App::import('libs', 'geokit.mappable', FALSE);
}

/**
 * Description of LatLng
 *
 * @author cwthomas
 */
class LatLng extends Mappable {

    /**
     *
     * @var float
     */
    private $_lat;

    /**
     *
     * @var float
     */
    private $_lng;

    /**
     *
     * @param float $lat
     * @param float $lng
     */
    public function  __construct($lat = NULL, $lng = NULL) {
        if(!empty ($lat) and is_numeric($lat)) {
            $this->_lat = (float) $lat;
        }
        
        if(!empty ($lng) and is_numeric($lng)) {
            $this->_lng = (float) $lng;
        }
    }


    public function setLat($lat) {
        $this->_lat = (float) $lat;
    }

    /**
     *
     * @return float
     */
    public function getLat() {
        return $this->_lat;
    }

    public function setLng($lng) {
        $this->_lng = (float) $lng;
    }

    /**
     *
     * @return float
     */
    public function getLng() {
        return $this->_lng;
    }

    /**
     *
     * @return string
     */
    public function ll() {
        return $this->getLat() . ',' . $this->getLng();
    }

    /**
     *
     * @return string
     */
    public function  __toString() {
        return $this->ll();
    }

    /**
     *
     * @return array
     */
    public function toArray() {
        return array($this->getLat(), $this->getLng());
    }

    public function hash() {

    }

    public function eql($other) {
        return $this == $other;
    }

    /**
     *
     * @param mixed $thing
     * @param float $other
     * @return LatLng
     */
    public static function normalize($thing, $other = null) {
        if($other) {
            $thing = array($thing, $other);
        }
        
        if(is_string($thing)) {
            $thing = trim($thing);
            if (preg_match('/(\-?\d+\.?\d*)[, ] ?(\-?\d+\.?\d*)$/', $thing, $m)) {
                return new LatLng($m[1], $m[2]);
            } else {
                throw new Exception('Need to write geocoding stuff');
            }
            
            
        } elseif (is_array($thing) and count($thing) == 2) {
            return new LatLng($thing[0], $thing[1]);
        } elseif ($thing instanceof LatLng) {
            return $thing;
        } 
        //elseif (true) {
        //    
        //}
        $bt = debug_backtrace();
        foreach ($bt as $k) {
            $foo[] = array('file' => $k['file'], 'line' => $k['line'],
                'function' => $k['function'], 'class' => $k['class'],
                'type' => $k['type'], 'args' => $k['args'], );
        }
        throw new Exception("cannot be normalized to a LatLng. We tried interpreting it as an array, string, Mappable, etc., but no dice.<br><pre>" . print_r($foo, TRUE) . "</pre>");
        
    }
    
    /**
     *
     * @param <type> $options
     * @return GeoLoc
     */
    public function reverse_geocode($options = NULL) {

    }

    //put your code here
}
?>
