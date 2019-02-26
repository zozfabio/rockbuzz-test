<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/23/19
 * Time: 6:57 PM
 */

namespace RockBuzz\Post\Domain\Arguments;

abstract class ArgumentEquals implements Argument {

    /**
     * @param string $name
     * @param mixed $value
     * @return self
     */
    public static function of($name, $value): self {
        if (!is_null($value) and $value !== "") {
            if (is_array($value)) {
                return new ArgumentEqualsArray($name, $value);
            }
            return new ArgumentEqualsDefault($name, $value);
        }
        return new ArgumentEqualsNull();
    }
}