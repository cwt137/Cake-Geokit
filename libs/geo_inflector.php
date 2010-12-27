<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::import('Core', 'Inflector');

/**
 * Description of Inflector
 *
 * @author cwthomas
 */
class GeoInflector {

    public static function titleize($word) {

    }
    
    public static function camelize($str) {
        return Inflector::camelize($str);

    }

    public static function humanize($lowerCaseAndUnderscoredWord) {

    }

    public static function snakeCase($s) {
        return Inflector::slug($s);
    }

    public static function underscore($camelCasedWord) {

    }

    public static function urlEscape($s) {

    }

}
?>
