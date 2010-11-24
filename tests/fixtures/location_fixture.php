<?php
 class LocationFixture extends CakeTestFixture {
      var $name = 'location';

      var $fields = array(
          'id' => array('type' => 'integer', 'key' => 'primary'),
          'company_id' => array('type' => 'integer', 'default' => '0', 'null' => false),
          'street' => array('type' => 'string', 'length' => 60, 'null' => false),
          'city' => array('type' => 'string', 'length' => 60, 'null' => false),
          'state' => array('type' => 'string', 'length' => 2, 'null' => false),
          'postal_code' => array('type' => 'string', 'length' => 16 , 'null' => false),
          'lat' => array('type' => 'float'),
          'lng' => array('type' => 'float')

      );
      var $records = array(
          array('id' => '1', 'company_id' => '1', 'street' => '7979 N MacArthur Blvd',
              'city' => 'Irving', 'state' => 'TX', 'postal_code' => '75063',
              'lat' => '32.918593', 'lng' => '-96.958444'),
          array('id' => '2', 'company_id' => '1', 'street' => '7750 N Macarthur Blvd # 160',
              'city' => 'Irving', 'state' => 'TX', 'postal_code' => '75063',
              'lat' => '32.914144', 'lng' => '-96.958444'),
          array('id' => '3', 'company_id' => '1', 'street' => '5904 N Macarthur Blvd # 160',
              'city' => 'Irving', 'state' => 'TX', 'postal_code' => '75039',
              'lat' => '32.895155', 'lng' => '-96.958444'),
          array('id' => '4', 'company_id' => '1', 'street' => '817 S Macarthur Blvd # 145',
              'city' => 'Coppell', 'state' => 'TX', 'postal_code' => '75019',
              'lat' => '32.951613', 'lng' => '-96.958444'),
          array('id' => '4', 'company_id' => '1', 'street' => '817 S Macarthur Blvd # 145',
              'city' => 'Coppell', 'state' => 'TX', 'postal_code' => '75019',
              'lat' => '32.951613', 'lng' => '-96.958444'),
e:
  id: 5
  company_id: 1
  street: 106 N Denton Tap Rd # 350
  city: Coppell
  state: TX
  postal_code: 75019
  lat: 32.969527
  lng: -96.990159
f:
  id: 6
  company_id: 2
  street: 5904 N Macarthur Blvd # 160
  city: Irving
  state: TX
  postal_code: 75039
  lat: 32.895155
  lng: -96.958444
      );
 }
 ?>
