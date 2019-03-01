<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/27/19
 * Time: 8:34 PM
 */

namespace RockBuzz\Post\Domain;

abstract class Preconditions {

    public static function nonEmpty($value, $message) {
        if (empty($value)) {
            throw new InvalidValueException($message);
        }
    }

    public static function nonEmptyKey($values, $key, $message) {
        if (!isset($values[$key]) || empty($values[$key])) {
            throw new InvalidValueException($message);
        }
    }
}