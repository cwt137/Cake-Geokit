<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists('LatLng')) {
    App::import('libs', 'geokit.lat_lng', FALSE);
}

/**
 * Description of Bounds
 *
 * @author cwthomas
 */
class Bounds {
    
    /**
     *
     * @var LatLng
     */
    protected $_sw;

    /**
     *
     * @var LatLng
     */
    protected $_ne;

    /**
     * Provide sw and ne to instantiate a new Bounds instance
     *
     * @param LatLng $sw
     * @param LatLng $ne
     */
    public function  __construct($sw, $ne) {

        if(($sw instanceof LatLng) and ($ne instanceof LatLng)) {
            $this->setSW($sw);
            $this->setNE($ne);
        } else {
            throw new Exception('Need to pass LatLng objects into the Bounds constructor');
        }        
    }

    /**
     *
     * @param mixed $point
     * @param float $radius
     * @param array $options
     * @return Bounds an instance of bounds which completely encompases the given circle
     */
    public static function fromPointAndRadius($point, $radius, $options = array()) {
        $point = LatLng::normalize($point);
        $p0 = $point->endpoint2(0,$radius,$options);
        $p90 = $point->endpoint2(90,$radius,$options);
        $p180 = $point->endpoint2(180,$radius,$options);
        $p270 = $point->endpoint2(270,$radius,$options);
        $sw = new LatLng($p180->getLat,$p270->getLng);
        $ne = new LatLng($p0->getLat,$p90->getLng);
        return new Bounds($sw, $ne);

    }

    /**
     * Takes two main combinations of arguments to create a bounds:
     * point,point (this is the only one which takes two arguments
     * [point,point]
     *  . . . where a point is anything LatLng#normalize can handle (which is quite a lot)
     * NOTE: everything combination is assumed to pass points in the order sw, ne
     *
     * @param mixed $thing
     * @param mixed $other
     * @return Bounds
     */
    public static function normalize($thing, $other = NULL) {
        if($thing instanceof Bounds) {
            return $thing;
        }

        if(empty($other) and is_array($thing) and count($thing) == 2) {
            list($thing, $other) = $thing;
            //$other = $thing;
        }

        return new Bounds(LatLng::normalize($thing), LatLng::normalize($other));
    }

    /** 
     *
     * @return LatLng a single point which is the center of the rectangular bounds
     */
    public function center() {
        return $this->getSW()->midpointTo($this->getNE());
    }

    /**
     * Returns true if the bounds contain the passed point.
     * Allows for bounds which cross the meridian
     *
     * @param mixed $point
     * @return boolean
     */
    public function contains($point) {
        $point = LatLng::normalize($point);
        $res = (($point->getLat() > $this->getSW()->getLat()) && ($point->getLat() < $this->getNE()->getLat()));

        if($this->crossesMeridian()) {
            $res &= (($point->getLng() < $this->getNE()->getLng()) || ($point->getLng() > $this->getSW()->getLng()));
        } else {
            $res &= (($point->getLng() < $this->getNE()->getLng()) && ($point->getLng() > $this->getSW()->getLng()));
        }

        return $res;

    }

    /**
     * Returns true if the bounds crosses the international dateline
     * 
     * @return boolean
     */
    public function crossesMeridian() {
        return ($this->getSW()->getLng() > $this->getNE()->getLng());
    }

    /**
     * a two-element array of two-element arrays: sw,ne
     *
     * @return array
     */
    public function toArray() {
        return array($this->getSW()->toArray(), $this->getNE()->toArray());
    }

    /**
     * a simple string representation:sw,ne
     *
     * @return string
     */
    public function  __toString() {
        return $this->getSW()->__toString() . ',' . $this->getNE()->__toString();
    }

    /**
     * Equivalent to Google Maps API's .toSpan() method on GLatLng's.
     *
     * @return LatLng Coordinates represent the size of a rectangle
     * defined by these bounds.
     */
    public function toSpan() {

        $latSpan = abs($this->getNE()->getLat() - $this->getSW()->getLat());

        if($this->crossesMeridian()) {
            $lngSpan = abs(360 + $this->getNE()->getLng() - $this->getSW()->getLng());
        } else {
            $lngSpan = abs($this->getNE()->getLng() - $this->getSW()->getLng());
        }

        return new LatLng($latSpan, $lngSpan);
    }

    /**
     *
     * @param LatLng $ne
     */
    public function setNE($ne) {
        $this->_ne = $ne;
        
    }

    /**
     *
     * @param LatLng $sw
     */
    public function setSW($sw) {
        $this->_sw = $sw;
    }

    /**
     *
     * @return LatLng
     */
    public function getNE() {
        return $this->_ne;
    }

    /**
     *
     * @return LatLng
     */
    public function getSW() {
        return $this->_sw;
    }

    //put your code here
}
?>
