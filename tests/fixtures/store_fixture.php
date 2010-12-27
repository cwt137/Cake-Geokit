<?php
class StoreFixture extends CakeTestFixture {
      var $name = 'store';

      var $fields = array(
          'id' => array('type' => 'integer', 'key' => 'primary'),
          'address' => array('type' => 'string'),
          'lat' => array('type' => 'float'),
          'lng' => array('type' => 'float')

          );
      
}

?>