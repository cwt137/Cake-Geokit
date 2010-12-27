<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of custom_location_fixture
 *
 * @author cwthomas
 */
class CustomLocationFixture extends CakeTestFixture {
    var $name = 'custom_location';    
           
      var $fields = array( 
          'id' => array('type' => 'integer', 'key' => 'primary'), 
          'company_id' => array('type' => 'integer', 'default' => '0', 'null' => false),
          'street' => array('type' => 'string', 'length' => 60),
          'city' => array('type' => 'string', 'length' => 60),
          'state' => array('type' => 'string', 'length' => 2),
          'postal_code' => array('type' => 'string', 'length' => 16),
          'latitude' => array('type' => 'float'),
          'longitude' => array('type' => 'float')
      );

      var $records = array(
          array('id' => '1', 'company_id' => '1', 'street' => '7979 N MacArthur Blvd',
              'city' => 'Irving', 'state' => 'TX', 'postal_code' => '75063',
              'latitude' => '32.918593', 'longitude' => '-96.958444'),
          array('id' => '2', 'company_id' => '1', 'street' => '7750 N Macarthur Blvd # 160',
              'city' => 'Irving', 'state' => 'TX', 'postal_code' => '75063',
              'latitude' => '32.914144', 'longitude' => '-96.958444'),
          array('id' => '3', 'company_id' => '1', 'street' => '5904 N Macarthur Blvd # 160',
              'city' => 'Irving', 'state' => 'TX', 'postal_code' => '75039',
              'latitude' => '32.895155', 'longitude' => '-96.958444'),
          array('id' => '4', 'company_id' => '1', 'street' => '817 S Macarthur Blvd # 145',
              'city' => 'Coppell', 'state' => 'TX', 'postal_code' => '75019',
              'latitude' => '32.951613', 'longitude' => '-96.958444'),
          array('id' => '4', 'company_id' => '1', 'street' => '817 S Macarthur Blvd # 145',
              'city' => 'Coppell', 'state' => 'TX', 'postal_code' => '75019',
              'latitude' => '32.951613', 'longitude' => '-96.958444'),
          array('id' => '5', 'company_id' => '1', 'street' => '106 N Denton Tap Rd # 350',
              'city' => 'Coppell', 'state' => 'TX', 'postal_code' => '75019',
              'latitude' => '32.969527', 'longitude' => '-96.990159'),
          array('id' => '6', 'company_id' => '2', 'street' => '5904 N Macarthur Blvd # 160',
              'city' => 'Irving', 'state' => 'TX', 'postal_code' => '75039',
              'latitude' => '32.895155', 'longitude' => '-96.958444')
      );

}
?>
