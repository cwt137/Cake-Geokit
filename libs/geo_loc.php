<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeoLoc
 *
 * @author cwthomas
 */
class GeoLoc extends LatLng {

    /**
     *
     * @var string
     */
    protected $_streetAddress;

    /**
     *
     * @var string
     */
    protected $_city;

    /**
     *
     * @var string
     */
    protected $_state;

    /**
     *
     * @var string
     */
    protected $_zip;

    /**
     *
     * @var string
     */
    protected $_countryCode;

    /**
     *
     * @var string
     */
    protected $_country;

    /**
     *
     * @var string
     */
    protected $_fullAddress;

    /**
     *
     * @var string
     */
    protected $_all;

    /**
     *
     * @var string
     */
    protected $_district;

    /**
     *
     * @var string
     */
    protected $_province;

    /**
     *
     * @var boolean
     */
    protected $_success;

    /**
     *
     * @var string
     */
    protected $_provider;

    /**
     *
     * @var string
     */
    protected $_precision;

    /**
     *
     * @var <type>
     */
    protected $_suggestedBounds;

    /**
     *
     * @var string
     */
    protected $_accuracy;

    /**
     * Constructor expects an array of symbols to correspond with attributes.
     *
     * @param array $h
     */
    public function  __construct($h = array()) {
        //$this->setAll($this);
        
        if(count($h) > 0) {

            $this->setStreetAddress($h['streetAddress']);
            $this->setCity($h['city']);
            $this->setState($h['state']);
            $this->setZip($h['zip']);
            $this->setCountryCode($h['countryCode']);
            $this->setProvince($h['province']);
            $this->setSuccess(FALSE);
            $this->setPrecision('unknown');
            $this->setFullAddress(NULL);
            parent::__construct($h['lat'], $h['lng']);
        } else {

            parent::__construct();
        }
        
    }

    /**
     * gives you all the important fields as key-value pairs
     *
     * @return array
     */
    public function hash() {
        $arr = array('success' => $this->getSuccess(), 'lat' => $this->getLat(),
            'lng' => $this->getLng(), 'countryCode' => $this->getCountryCode(),
            'city' => $this->getCity(), 'state' => $this->getState(),
            'zip' => $this->getZip(), 'streetAddress' => $this->getStreetAddress(),
            'province' => $this->getProvince(), 'district' => $this->getDistrict(),
            'provider' => $this->getProvider(), 'fullAddress' => $this->getFullAddress(),
            'isUS' => $this->isUS(), 'll' => $this->ll(),
            'precision' => $this->getPrecision());
        
        return $arr;
    }

    /**
     *
     * @return array
     */
    public function  toArray() {
        return $this->hash();
    }

    /**
     *
     * @return boolean true if geocoded to the United States.
     */
    public function isUS() {
        return ($this->getCountry() == 'US');
    }

    /**
     *
     * @return string
     */
    public function toGeocodeableString() {
        $arr = array($this->getStreetAddress(), $this->getDistrict(), 
            $this->getCity(), $this->getProvince(), $this->getState(), 
            $this->getZip(), $this->getCountryCode());
        
        foreach ($arr as $v) {
            if(!empty($v)) {
                $arr2[] = $v;
            }
        }
        
        return implode(', ', $arr2);
    }

    /**
     *
     * @return string
     */
    public function  __toString() {
        $str  = "Provider: " . $this->getProvider() . "\nStreet: ";
        $str .= $this->getStreetAddress() . "\nCity: " . $this->getCity();
        $str .=  "\nState: " . $this->getState() . "\nZip: " . $this->getZip();
        $str .= "\nLatitude: " . $this->getLat() . "\nLongitude: ";
        $str .= $this->getLng() . "\nCountry: " . $this->getCountry();
        $str .= "\nSuccess: " . $this->getSuccess();
        return $str;
    }

    /**
     *
     * @return string
     */
    public function getStreetAddress() {
        return $this->_streetAddress;
    }

    public function setStreetAddress($_streetAddress) {
        if(!empty($_streetAddress)) {
            $this->_streetAddress = InflectorComponent::titleize($_streetAddress);
        }
    }


    /**
     *
     * @return string
     */
    public function getCity() {
        return $this->_city;
    }

    public function setCity($_city) {
        $this->_city = InflectorComponent::titleize($_city);
    }

    /**
     *
     * @return string
     */
    public function getState() {
        return $this->_state;
    }

    public function setState($_state) {
        $this->_state = $_state;
    }


    /**
     *
     * @return string
     */
    public function getZip() {
        return $this->_zip;
    }

    public function setZip($_zip) {
        $this->_zip = $_zip;
    }


    /**
     *
     * @return string
     */
    public function getCountryCode() {
        return $this->_countryCode;
    }

    public function setCountryCode($_countryCode) {
        $this->_countryCode = $_countryCode;
    }


    /**
     *
     * @return string
     */
    public function getCountry() {
        return $this->_country;
    }

    public function setCountry($_country) {
        $this->_country = $_country;
    }


    /**
     * full_address is provided by google but not by yahoo. It is intended that the google
     * geocoding method will provide the full address, whereas for yahoo it will be derived
     * from the parts of the address we do have.
     *
     * @return string
     */
    public function getFullAddress() {
        
        if(empty ($this->_fullAddress)) {
            // @todo need to complete        
        } else {
            return $this->_fullAddress;
        }
        
    }

    public function setFullAddress($_fullAddress) {
        $this->_fullAddress = $_fullAddress;
    }

    public function getAll() {
        return $this->_all;
    }

    public function setAll($_all) {
        $this->_all = $_all;
    }


    /**
     *
     * @return string
     */
    public function getDistrict() {
        return $this->_district;
    }

    public function setDistrict($_district) {
        $this->_district = $_district;
    }


    /**
     *
     * @return string
     */
    public function getProvince() {
        return $this->_province;
    }

    public function setProvince($_province) {
        $this->_province = $_province;
    }


    /**
     *
     * @return boolean
     */
    public function getSuccess() {
        return $this->_success;
    }

    public function setSuccess($_success) {
        $this->_success = $_success;
    }


    /**
     *
     * @return string
     */
    public function getProvider() {
        return $this->_provider;
    }

    public function setProvider($_provider) {
        $this->_provider = $_provider;
    }


    /**
     *
     * @return string
     */
    public function getPrecision() {
        return $this->_precision;
    }

    public function setPrecision($_precision) {
        $this->_precision = $_precision;
    }

    /**
     *
     * @return <type> 
     */
    public function getSuggestedBounds() {
        return $this->_suggestedBounds;
    }

    public function setSuggestedBounds($_suggestedBounds) {
        $this->_suggestedBounds = $_suggestedBounds;
    }


    /**
     * Extracts the street number from the street address if the street address
     * has a value.
     *
     * @return int
     */
    public function getStreetNumber() {

        if($this->getStreetAddress()) {
            $pattern = '/(\d*)/';
            $subject = $this->getStreetAddress();

            preg_match($pattern, $subject, $matches);

            return $matches[0];
        }
    }


    /**
     *
     * @return string the street name portion of the street address.
     */
    public function getStreetName() {
        if($this->getStreetAddress()) {
            $numberLength = strlen($this->getStreetNumber());

            return substr($this->getStreetAddress(), $numberLength);

        }
    }



    /**
     *
     * @return string
     */
    public function getAccuracy() {
        return $this->_accuracy;
    }

    public function setAccuracy($_accuracy) {
        $this->_accuracy = $_accuracy;
    }

        //put your code here
}
?>
