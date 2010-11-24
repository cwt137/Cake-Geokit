<?php

/**
 * GeoKit MappableBehavior
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org
 * @package       geo_kit
 * @subpackage    geo_kit.models.behaviors
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class MappableBehavior extends ModelBehavior {

    public static $distanceColumnName;
    public static $defaultUnits;
    public static $defaultFormula;
    public static $latColumnName;
    public static $lngColumnName;
    public static $qualifiedLatColumnName;
    public static $qualifiedLngColumnName;
    public static $autoGeocodeField;
    public static $autoGeocodeErrorMessage;
    /**
     * Behavior settings
     *
     * @access public
     * @var array
     */
    public $settings = array();
    /**
     * Default setting values
     *
     * @access protected
     * @var array
     */
    protected $_defaults = array('default_units' => 'miles',
        'default_formula' => 'sphere',
        'distance_field_name' => 'distance',
        'lat_column_name' => 'lat',
        'lng_column_name' => 'lng');

    /**
     * Setup the behavior and import required classes.
     *
     * @param object $Model Model using the behavior
     * @param array $settings Settings to override for model.
     * @access public
     * @return void
     */
    public function setup(&$Model, $options = array()) {
        if (array_key_exists('distance_column_name', $options)) {
            $this->_distanceColumnName = $options['distance_column_name'];
        } else {
            $this->_distanceColumnName = 'distance';
        }

        if (array_key_exists('default_units', $options)) {
            $this->_defaultUnits = $options['default_units'];
        } else {
            $this->_defaultUnits = Configure::read('Geokit.default_units');
        }

        if (array_key_exists('default_formula', $options)) {
            $this->_defaultFormula = $options['default_formula'];
        } else {
            $this->_defaultUnits = Configure::read('Geokit.default_formula');
        }

        if (array_key_exists('lat_column_name', $options)) {
            $this->_latColumnName = $options['lat_column_name'];
        } else {
            $this->_latColumnName = 'lat';
        }

        if (array_key_exists('lng_column_name', $options)) {
            $this->_lngColumnName = $options['lng_column_name'];
        } else {
            $this->_lngColumnName = 'lng';
        }


        if (array_key_exists('auto_geocode', $options) and $options['auto_geocode'] == true) {

            if (array_key_exists('field', $options['auto_geocode'])) {
                $this->_autoGeocodeField = $options['auto_geocode']['field'];
            } else {
                $this->_autoGeocodeField = 'address';
            }

            if (array_key_exists('error_message', $options['auto_geocode'])) {
                $this->_autoGeocodeErrorMessage = $options['auto_geocode']['error_message'];
            } else {
                $this->_autoGeocodeErrorMessage = 'could not locate address';
            }
        }
    }

    /**
     * beforeFind
     *
     * @param Model $Model
     * @param array $queryData Array of query data (not modified)
     * @return boolean true
     */
    public function beforeFind(&$Model, $query) {

        return $this->_prepareForFindOrCount($Model, 'find', $query);
    }
    
//        public count($origin, $conditions) {
//
//        }

    public function findWithin($distance, $origin) {
        
    }

    public function findBeyond($distance, $origin) {
        
    }

    public function findClosest($origin) {
        
    }

    public function findFarthest($origin) {
        
    }

    public function findWithinBounds($bounds, $options = array()) {

    }

    public function countWithin($distance, $origin) {
        
    }

    public function countBeyond($distance, $origin) {
        
    }

    public function countByRange($range, $options = array()) {

    }

    public function countWithinBounds($bounds, $options = array()) {

    }

    public function distanceSql($origin, $units = 'miles', $formula = 'sphere') {
//                case formula
//        when :sphere
//          sql = sphere_distance_sql(origin, units)
//        when :flat
//          sql = flat_distance_sql(origin, units)
//        end
//        sql
    }


    protected function _prepareForFindOrCount(&$Model, $action, $args) {

        $origin = $this->_extractOriginFromOptions($options);
        $units = $this->_extractUnitsFromOptions($options);
        $formula = $this->_extractFormulaFromOptions($options);
        $bounds = $this->_extractBoundsFromOptions($options);

        if ($origin or $bounds) {
            if (!$bounds) {
                $bounds = $this->_formulateBoundsFromDistance($options, $origin, $units);
            }

            if ($origin and $action == 'find') {
                $this->_addDistanceToSelect($Model, $options, $origin, $units, $formula);
            }

            if ($bounds) {
                $this->_applyBoundsConditions($Model, &$options, $bounds);
            }

            $this->_applyDistanceScope($Model, $options);

            if ($origin and array_key_exists('conditions', $options)) {
                $this->_substituteDistanceInConditions($Model, $options, $origin, $units, $formula);
            }

            if ($action == 'find') {
                apply_find_scope($Model, $args, $options);
            }
        } else {

            return TRUE;
        }
    }
    
    protected function _applyIncludeForThrough($options) {
//         if self.through
//            case options[:include]
//            when Array
//              options[:include] << self.through
//            when Hash, String, Symbol
//              options[:include] = [ self.through, options[:include] ]
//            else
//              options[:include] = [ self.through ]
//            end
//          end
        
    }
    
    protected function _handleOrderWithInclude($options, $origin, $units, $formula) {
//                  # replace the distance_column_name with the distance sql in order clause
//          options[:order].sub!(distance_column_name, distance_sql(origin, units, formula))
    }
    
    protected function _applyFindScope($args, $options) {
//                  case args.first
//            when :nearest, :closest
//              args[0] = :first
//              options[:limit] = 1
//              options[:order] = "#{distance_column_name} ASC"
//            when :farthest
//              args[0] = :first
//              options[:limit] = 1
//              options[:order] = "#{distance_column_name} DESC"
//          end
    }
    
    
    protected function _formulateBoundsFromDistance($options, $origin, $units) {
        $distance = FALSE;
        $res = NULL;

        if (array_key_exists('within', $options)) {
            $distance = $options['within'];
        }

        if (array_key_exists('range', $options) and is_array($options)) {
            $distance = $options['range'][(count($options['range']) - 1)] - 1;
        }

        if ($distance) {
            return $res;
        } else {
            return $res;
        }
    }
    
    protected function _applyDistanceScope($options) {
//                  distance_condition = if options.has_key?(:within)
//            "#{distance_column_name} <= #{options[:within]}"
//          elsif options.has_key?(:beyond)
//            "#{distance_column_name} > #{options[:beyond]}"
//          elsif options.has_key?(:range)
//            "#{distance_column_name} >= #{options[:range].first} AND #{distance_column_name} <#{'=' unless options[:range].exclude_end?} #{options[:range].last}"
//          end
//
//          if distance_condition
//            [:within, :beyond, :range].each { |option| options.delete(option) }
//            options[:conditions] = merge_conditions(options[:conditions], distance_condition)
//          end
    }

    protected function _applyBoundsConditions($options, $bounds) {
//                  sw,ne = bounds.sw, bounds.ne
//          lng_sql = bounds.crosses_meridian? ? "(#{qualified_lng_column_name}<#{ne.lng} OR #{qualified_lng_column_name}>#{sw.lng})" : "#{qualified_lng_column_name}>#{sw.lng} AND #{qualified_lng_column_name}<#{ne.lng}"
//          bounds_sql = "#{qualified_lat_column_name}>#{sw.lat} AND #{qualified_lat_column_name}<#{ne.lat} AND #{lng_sql}"
//          options[:conditions] = merge_conditions(options[:conditions], bounds_sql)
    }
    
    protected function _extractOriginFromOptions($options) {

        if (isset($options['origin']) and is_array($options['origin'])
                and count($options['origin']) == 2) {
            return $options['origin'];
        } else {
            return FALSE;
        }
    }


    protected function _extractUnitsFromOptions($options) {
        if ($options['units']) {
            return $options['units'];
        } else {
            return $this->settings[$Model->alias]['default_units'];
        }
    }

    protected function _extractFormulaFromOptions($options) {
        if ($options['formula']) {
            return $options['formula'];
        } else {
            return $this->settings[$Model->alias]['default_formula'];
        }
    }

    protected function _extractBoundsFromOptions($queryData) {

        if (isset($options['bounds']) and is_array($options['bounds'])
                and count($options['bounds']) == 2) {
            return $options['bounds'];
        } else {
            return FALSE;
        }
    }
    
    protected function _geocodeIpAddress($origin) {
//                  geo_location = Geokit::Geocoders::MultiGeocoder.geocode(origin)
//          return geo_location if geo_location.success
//          raise Geokit::Geocoders::GeocodeError
    }
    
    
    protected function _normalizePointToLatLng($point) {
//        res = geocode_ip_address(point) if point.is_a?(String) && /^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})?$/.match(point)
//          res = Geokit::LatLng.normalize(point) unless res
//          res
    }

    
    protected function _addDistanceToSelect($model, $options, $origin, 
            $units = 'miles', $formula = 'sphere') {
//     if origin
//            distance_selector = distance_sql(origin, units, formula) + " AS #{distance_column_name}"
//            selector = options.has_key?(:select) && options[:select] ? options[:select] : "*"
//            options[:select] = "#{selector}, #{distance_selector}"
//          end    
    }
    
    protected function _substituteDistanceInConditions($options, $origin, 
            $units='miles', $formula='sphere') {
        
//                  condition = options[:conditions].is_a?(String) ? options[:conditions] : options[:conditions].first
//          pattern = Regexp.new("\\b#{distance_column_name}\\b")
//          condition.gsub!(pattern, distance_sql(origin, units, formula))
        
    }
    
    protected function _sphereDistanceSql($origin, $units) {
//                  lat = deg2rad(origin.lat)
//          lng = deg2rad(origin.lng)
//          multiplier = units_sphere_multiplier(units)
//
//          adapter.sphere_distance_sql(lat, lng, multiplier) if adapter
    }

    protected function _flatDistanceSql($origin, $units) {
//                  lat_degree_units = units_per_latitude_degree(units)
//          lng_degree_units = units_per_longitude_degree(origin.lat, units)
//          
//          adapter.flat_distance_sql(origin, lat_degree_units, lng_degree_units)
    }

}
