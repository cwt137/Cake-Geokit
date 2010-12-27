<?php

class MockAddressFixture extends CakeTestFixture {

    var $name = 'mock_address';


      var $fields = array(
          'id' => array('type' => 'integer', 'key' => 'primary'),
          'addressable_id' => array('type' => 'integer', 'null' => false),
          'addressable_type' => array('type' => 'string', 'null' => false),
          'street' => array('type' => 'string', 'length' => 60),
          'city' => array('type' => 'string', 'length' => 60),
          'state' => array('type' => 'string', 'length' => 2),
          'postal_code' => array('type' => 'string', 'length' => 16),
          'lat' => array('type' => 'float'),
          'lng' => array('type' => 'float')
          );
}

?>