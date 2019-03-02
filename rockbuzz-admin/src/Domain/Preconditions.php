<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 3/1/19
 * Time: 5:50 PM
 */

namespace RockBuzz\Admin\Domain;

abstract class Preconditions {

    public static function checkArgument($value, $message) {
        if (!$value) {
            throw new InvalidValueException($message);
        }
    }

    public static function nonEmptyKey($values, $key, $message) {
        self::checkArgument(isset($values[$key]) && !empty($values[$key]), $message);
    }
}