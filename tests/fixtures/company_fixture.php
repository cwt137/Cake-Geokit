<?php
 class CompanyFixture extends CakeTestFixture {
      var $name = 'company';

      var $fields = array(
          'id' => array('type' => 'integer', 'key' => 'primary'),
          'name' => array('type' => 'string', 'length' => 255, 'null' => false)

      );
      var $records = array(
          array ('id' => 1, 'name' => 'Starbucks'),
          array ('id' => 2, 'name' => 'Barnes & Noble')
      );
 }
 ?>
