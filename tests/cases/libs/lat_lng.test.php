<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists('LatLng')) {
    App::import('libs', 'geokit.lat_lng', FALSE);
}

Configure::load('geokit.geokit');

class LatLngTestCase extends CakeTestCase {

    /**
     *
     * @var LatLng
     */
    private $_locA;

    /**
     *
     * @var LatLng
     */
    private $_locE;

    /**
     *
     * @var LatLng
     */
    private $_point;

    public function startTest() {
        $this->_locA = new LatLng(32.918593,-96.958444);
        $this->_locE = new LatLng(32.969527,-96.990159);
        $this->_point = new LatLng($this->_locA->getLat(), $this->_locA->getLng());
    }

//
//    def valid_reverse_geocoding_result
//    location = Geokit::GeoLoc.new({
//      :city => "Essen",
//      :country_code => "DE",
//      :lat => 51.4578329,
//      :lng => 7.0166848,
//      :provider => "google",
//      :state => "Nordrhein-Westfalen",
//      :street_address => "Porscheplatz 1",
//      :zip => "45127"
//    })
//
//    location.full_address = "Porscheplatz 1, 45127 Essen, Deutschland"
//    location.precision = 'address'
//    location.provider = 'google'
//    location.success = true
//    location
//  end
    
    public function testDistanceBetweenSameUsingDefaults() {
        $this->assertEqual(0, LatLng::distanceBetween($this->_locA, $this->_locA));
        $this->assertEqual(0, $this->_locA->distanceTo($this->_locA));

    }
    
    public function testDistanceBetweenSameWithMilesAndFlat() {
        $this->assertEqual(0, LatLng::distanceBetween($this->_locA, $this->_locA, array('units' => 'miles', 'formula' => 'flat')));
        $this->assertEqual(0, $this->_locA->distanceTo($this->_locA, array('units' => 'miles', 'formula' => 'flat')));
        
    }
    
    public function testDistanceBetweenSameWithKmsAndFlat() {
        $this->assertEqual(0,  LatLng::distanceBetween($this->_locA, $this->_locA, array('units' => 'kms', 'formula' => 'flat')));
        $this->assertEqual(0, $this->_locA->distanceTo($this->_locA, array('units' => 'kms', 'formula' => 'flat')));
        
    }

    public function testDistanceBetweenSameWithNmsAndFlat() {
        $this->assertEqual(0,  LatLng::distanceBetween($this->_locA, $this->_locA, array('units' => 'nms', 'formula' => 'flat')));
        $this->assertEqual(0, $this->_locA->distanceTo($this->_locA, array('units' => 'nms', 'formula' => 'flat')));

    }

    public function testDistanceBetweenSameWithMilesAndSphere() {
        $this->assertEqual(0, LatLng::distanceBetween($this->_locA, $this->_locA, array('units' => 'miles', 'formula' => 'sphere')));
        $this->assertEqual(0, $this->_locA->distanceTo($this->_locA, array('units' => 'miles', 'formula' => 'sphere')));

    }

    public function testDistanceBetweenSameWithKmsAndSphere() {
        $this->assertEqual(0,  LatLng::distanceBetween($this->_locA, $this->_locA, array('units' => 'kms', 'formula' => 'sphere')));
        $this->assertEqual(0, $this->_locA->distanceTo($this->_locA, array('units' => 'kms', 'formula' => 'sphere')));

    }

    public function testDistanceBetweenSameWithNmsAndSphere() {
        $this->assertEqual(0,  LatLng::distanceBetween($this->_locA, $this->_locA, array('units' => 'nms', 'formula' => 'sphere')));
        $this->assertEqual(0, $this->_locA->distanceTo($this->_locA, array('units' => 'nms', 'formula' => 'sphere')));

    }

    public function testDistanceBetweenDiffUsingDefaults() {
        $this->assertWithinMargin(3.97, LatLng::distanceBetween($this->_locA, $this->_locE), 0.01);
        $this->assertWithinMargin(3.97, $this->_locA->distanceTo($this->_locE), 0.01);
    }

    public function testDistanceBetweenDiffWithMilesAndFlat() {
        $this->assertWithinMargin(3.97, LatLng::distanceBetween($this->_locA, $this->_locE, array('units' => 'miles', 'formula' => 'flat')), 0.2);
        $this->assertWithinMargin(3.97, $this->_locA->distanceTo($this->_locE, array('units' => 'miles', 'formula' => 'flat')), 0.2);

    }

    public function testDistanceBetweenDiffWithKmsAndFlat() {
        $this->assertWithinMargin(6.39, LatLng::distanceBetween($this->_locA, $this->_locE, array('units' => 'kms', 'formula' => 'flat')), 0.4);
        $this->assertWithinMargin(6.39, $this->_locA->distanceTo($this->_locE, array('units' => 'kms', 'formula' => 'flat')), 0.4);

    }

    public function testDistanceBetweenDiffWithNmsAndFlat() {
         $this->assertWithinMargin(3.334, LatLng::distanceBetween($this->_locA, $this->_locE, array('units' => 'nms', 'formula' => 'flat')), 0.4);
        $this->assertWithinMargin(3.334, $this->_locA->distanceTo($this->_locE, array('units' => 'nms', 'formula' => 'flat')), 0.4);

    }


    public function testDistanceBetweenDiffWithMilesAndSphere() {
        $this->assertWithinMargin(3.97, LatLng::distanceBetween($this->_locA, $this->_locE, array('units' => 'miles', 'formula' => 'sphere')), 0.01);
        $this->assertWithinMargin(3.97, $this->_locA->distanceTo($this->_locE, array('units' => 'miles', 'formula' => 'sphere')), 0.01);

    }

    public function testDistanceBetweenDiffWithKmsAndSphere() {
         $this->assertWithinMargin(6.39, LatLng::distanceBetween($this->_locA, $this->_locE, array('units' => 'kms', 'formula' => 'sphere')), 0.01);
        $this->assertWithinMargin(6.39, $this->_locA->distanceTo($this->_locE, array('units' => 'kms', 'formula' => 'sphere')), 0.01);

    }

    public function testDistanceBetweenDiffWithNmsAndSphere() {
        $this->assertWithinMargin(3.454, LatLng::distanceBetween($this->_locA, $this->_locE, array('units' => 'nms', 'formula' => 'sphere')), 0.01);
        $this->assertWithinMargin(3.454, $this->_locA->distanceTo($this->_locE, array('units' => 'nms', 'formula' => 'sphere')), 0.01);

    }

    public function testManuallyMixedIn() {
        $this->assertEqual(0, LatLng::distanceBetween($this->_point, $this->_point));
        $this->assertEqual(0, $this->_point->distanceTo($this->_point));
        $this->assertEqual(0, $this->_point->distanceTo($this->_locA));
        $this->assertWithinMargin(3.97, $this->_point->distanceTo($this->_locE, array('units' => 'miles', 'formula' => 'flat')), 0.2);
        $this->assertWithinMargin(6.39, $this->_point->distanceTo($this->_locE, array('units' => 'kms', 'formula' => 'flat')), 0.4);
        $this->assertWithinMargin(3.334, $this->_point->distanceTo($this->_locE, array('units' => 'nms', 'formula' => 'flat')), 0.4);
    }

    public function testHeadingBetween() {
        $this->assertWithinMargin(332, LatLng::headingBetween($this->_locA,$this->_locE), 0.5);
    }

    public function testHeadingTo() {
        $this->assertWithinMargin(332, $this->_locA->headingTo($this->_locE), 0.5);
    }


    public function testClassEndpoint() {
        $endpoint = LatLng::endpoint($this->_locA, 332, 3.97);
        $this->assertWithinMargin($this->_locE->getLat(), $endpoint->getLat(), 0.0005);
        $this->assertWithinMargin($this->_locE->getLng(), $endpoint->getLng(), 0.0005);
    }

    public function testInstanceEndpoint() {
        $endpoint = $this->_locA->endpoint2(332, 3.97);
        $this->assertWithinMargin($this->_locE->getLat(), $endpoint->getLat(), 0.0005);
        $this->assertWithinMargin($this->_locE->getLng(), $endpoint->getLng(), 0.0005);
    }

    public function testMidpoint() {
        $midpoint = $this->_locA->midpointTo($this->_locE);
        $this->assertWithinMargin(32.944061, $midpoint->getLat(), 0.0005);
        $this->assertWithinMargin(-96.974296, $midpoint->getLng(), 0.0005);
    }

    public function testNormalize() {
        $lat = 37.7690;
        $lng = -122.443;
        $res = LatLng::normalize($lat, $lng);
        $this->assertEqual($res, new LatLng($lat, $lng));
        $res = LatLng::normalize("$lat, $lng");
        $this->assertEqual($res, new LatLng($lat, $lng));
        $res = LatLng::normalize("$lat $lng");
        $this->assertEqual($res, new LatLng($lat, $lng));
        $res = LatLng::normalize(intval($lat) . ' ' . intval($lng));
        $this->assertEqual($res, new LatLng(intval($lat), intval($lng)));
        $res = LatLng::normalize(array($lat, $lng));
        $this->assertEqual($res, new LatLng($lat, $lng));
    }
    
//
//  def test_hash
//    lat=37.7690
//    lng=-122.443
//    first = Geokit::LatLng.new(lat,lng)
//    second = Geokit::LatLng.new(lat,lng)
//    assert_equal first.hash, second.hash
//  end
//
    public function testEql() {
        $lat = 37.7690;
        $lng = -122.443;
        $first = new LatLng($lat, $lng);
        $second = new LatLng($lat, $lng);
        $this->assertTrue($first->eql($second));
        $this->assertTrue($second->eql($first));
    }

//
//  def test_reverse_geocode
//    point = Geokit::LatLng.new(51.4578329, 7.0166848)
//    Geokit::Geocoders::MultiGeocoder.expects(:reverse_geocode).with(point).returns(valid_reverse_geocoding_result)
//    res = point.reverse_geocode
//
//    assert_equal "Nordrhein-Westfalen", res.state
//    assert_equal "Essen", res.city
//    assert_equal "45127", res.zip
//    assert_equal "51.4578329,7.0166848", res.ll # slightly dif from yahoo
//    assert res.is_us? == false
//    assert_equal "Porscheplatz 1, 45127 Essen, Deutschland", res.full_address #slightly different from yahoo
//  end
//
//  def test_reverse_geocoding_using_specific_geocoder
//    point = Geokit::LatLng.new(51.4578329, 7.0166848)
//    Geokit::Geocoders::GoogleGeocoder.expects(:reverse_geocode).with(point).returns(valid_reverse_geocoding_result)
//    res = point.reverse_geocode(:using => Geokit::Geocoders::GoogleGeocoder)
//
//    assert_equal "Nordrhein-Westfalen", res.state
//    assert_equal "Essen", res.city
//    assert_equal "45127", res.zip
//    assert_equal "51.4578329,7.0166848", res.ll # slightly dif from yahoo
//    assert res.is_us? == false
//    assert_equal "Porscheplatz 1, 45127 Essen, Deutschland", res.full_address #slightly different from yahoo
//    assert_equal "google", res.provider
//  end
//
//  def test_reverse_geocoding_using_specific_geocoder_short_syntax
//    point = Geokit::LatLng.new(51.4578329, 7.0166848)
//    Geokit::Geocoders::GoogleGeocoder.expects(:reverse_geocode).with(point).returns(valid_reverse_geocoding_result)
//    res = point.reverse_geocode(:using => :google)
//
//    assert_equal "Nordrhein-Westfalen", res.state
//    assert_equal "Essen", res.city
//    assert_equal "45127", res.zip
//    assert_equal "51.4578329,7.0166848", res.ll # slightly dif from yahoo
//    assert res.is_us? == false
//    assert_equal "Porscheplatz 1, 45127 Essen, Deutschland", res.full_address #slightly different from yahoo
//    assert_equal "google", res.provider
//  end

}


?>
