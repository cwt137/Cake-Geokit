<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists('Bounds')) {
    App::import('libs','geokit.bounds');
}

Configure::load('geokit.geokit');

class BoundsTestCase extends CakeTestCase {

    /**
     *
     * @var LatLng
     */
    private $_sw;

    /**
     *
     * @var LatLng
     */
    private $_ne;

    /**
     *
     * @var Bounds
     */
    private $_bounds;

    /**
     *
     * @var LatLng
     */
    private $_locA;

    /**
     *
     * @var LatLng
     */
    private $_locB;

    /**
     *
     * @var Bounds
     */
    private $_crossesMeridian;

    /**
     *
     * @var LatLng
     */
    private $_insideCm;

    /**
     *
     * @var LatLng
     */
    private $_insideCm2;

    /**
     *
     * @var LatLng
     */
    private $_eastOfCm;

    /**
     *
     * @var LatLng
     */
    private $_westOfCm;

    public function startTest() {
        //This is the area in Texas
        $this->_sw =  new LatLng(32.91663,-96.982841);
        $this->_ne = new LatLng(32.96302,-96.919495);
        $this->_bounds = new Bounds($this->_sw, $this->_ne);
        $this->_locA =  new LatLng(32.918593,-96.958444); // inside bounds
        $this->_locB = new LatLng(32.914144,-96.958444); // outside bouds

        // this is a cross-meridan area
        $this->_crossMeridian = Bounds::normalize(array(30, 170), array(40, -170));
        $this->_insideCm = new LatLng(35,175);
        $this->_insideCm2 = new LatLng(35,-175);
        $this->_eastOfCm = new LatLng(35,-165);
        $this->_westOfCm = new LatLng(35,165);
    }

    public function testEquality() {
        $this->assertEqual(new Bounds($this->_sw, $this->_ne), new Bounds($this->_sw, $this->_ne));
    }



    public function testNormalize() {
        $res = Bounds::normalize($this->_sw, $this->_ne);
        $this->assertEqual($res, new Bounds($this->_sw, $this->_ne));
        $res = Bounds::normalize(array($this->_sw, $this->_ne));
        $this->assertEqual($res, new Bounds($this->_sw, $this->_ne));
        $res = Bounds::normalize(array($this->_sw->getLat(), $this->_sw->getLng()), array($this->_ne->getLat(), $this->_ne->getLng()));
        $this->assertEqual($res, new Bounds($this->_sw, $this->_ne));
        $res = Bounds::normalize(array(array($this->_sw->getLat(), $this->_sw->getLng()), array($this->_ne->getLat(), $this->_ne->getLng())));
        $this->assertEqual($res, new Bounds($this->_sw, $this->_ne));
    }

    public function testPointInsideBounds() {
        $this->assertTrue($this->_bounds->contains($this->_locA));
    }

    public function testPointOutsideBounds() {
        $this->assertTrue(!$this->_bounds->contains($this->_locB));
    }


    public function testPointInsideBoundsCrossMeridian() {
        $this->assertTrue($this->_crossMeridian->contains($this->_insideCm));
        $this->assertTrue($this->_crossMeridian->contains($this->_insideCm2));
    }

    public function testPointOutsideBoundsCrossMeridian() {
        $this->assertTrue(!$this->_crossMeridian->contains($this->_eastOfCm));
        $this->assertTrue(!$this->_crossMeridian->contains($this->_westOfCm));
    }


    public function testCenter() {
        $this->assertWithinMargin(32.939828, $this->_bounds->center()->getLat(), 0.0005);
        $this->assertWithinMargin(-96.9511763, $this->_bounds->center()->getLng(), 0.0005);
    }


    public function testCenterCrossMeridian() {

        
        $this->assertWithinMargin(35.41160, $this->_crossMeridian->center()->getLat(), 0.00005);
        $this->assertWithinMargin(179.38112, $this->_crossMeridian->center()->getLng(), 0.00005);
    }


    public function testCreationFromCircle() {
        $bounds = Bounds::fromPointAndRadius(array(32.939829, -96.951176), 2.5);
        $inside = new LatLng(32.9695270000, -96.9901590000);
        $outside = new LatLng(32.8951550000, -96.9584440000);
        $this->assertTrue($bounds->contains($inside));
        $this->assertTrue(!$bounds->contains($outside));
    }

    public function testBoundsToSpan() {
        $sw = new LatLng(32, -96);
        $ne = new LatLng(40, -70);
        $bounds = new Bounds($sw, $ne);

        $this->assertEqual(new LatLng(8, 26), $bounds->toSpan());
    }


    public function testBoundsToSpanWithBoundsCrossingPrimeMeridian() {
        $sw = new LatLng(20, -70);
        $ne = new LatLng(40, 100);
        $bounds = new Bounds($sw, $ne);

        $this->assertEqual(new LatLng(20, 170), $bounds->toSpan());
    }


    public function test_bounds_to_span_with_bounds_crossing_dateline() {
        $sw = new LatLng(20, 100);
        $ne = new LatLng(40, -70);
        $bounds = new Bounds($sw, $ne);

        $this->assertEqual(new LatLng(20, 190), $bounds->toSpan());
    }
}
