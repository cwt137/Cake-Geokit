<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists('GeoLoc')) {
    App::import('libs','geokit.geo_loc');
}

Configure::load('geokit.geokit');

class BoundsTestCase extends CakeTestCase {

    /**
     *
     * @var GeoLoc
     */
    private $loc;

    public function startTest() {
        $this->loc = new GeoLoc();
    }


    public function testIsUs() {
        $this->assertTrue(!$this->loc->isUS());
        $this->loc->setCountryCode('US');
        $this->assertTrue($this->loc->isUS());
    }

    public function testSuccess() {
        $this->assertTrue(!$this->loc->getSuccess());
        $this->loc->setSuccess(FALSE);
        $this->assertTrue(!$this->loc->getSuccess());
        $this->loc->setSuccess(FALSE);
        $this->assertTrue($this->loc->getSuccess());
    }

    public function testStreetNumber() {
        $this->loc->setStreetAddress('123 Spear St.');
        $this->assertEqual('123', $this->loc->getStreetNumber());
    }

    public function testStreetName() {
        $this->loc->setStreetAddress('123 Spear St.');
        $this->assertEqual('Spear St.', $this->loc->getStreetName());
    }

    public function testCity() {
        $this->loc->setCity("san francisco");
        $this->assertEqual('San Francisco', $this->loc->getCity());
    }

    public function testFullAddress() {
        $this->loc->setCity('San Francisco');
        $this->loc->setState('CA');
        $this->loc->setZip('94105');
        $this->loc->setCountryCode('US');
        $this->assertEqual('San Francisco, CA, 94105, US', $this->loc->getFullAddress());
        $this->loc->setFullAddress('Irving, TX, 75063, US');
        $this->assertEqual('Irving, TX, 75063, US', $this->loc->getFullAddress());
    }

    public function testArray() {
        $this->loc->setCity('San Francisco');
        $this->loc->setState('CA');
        $this->loc->setZip('94105');
        $this->loc->setCountryCode('US');
        $another = new GeoLoc($this->loc->toArray());
        $this->assertEqual($this->loc, $another);
    }
}
?>
