<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/23/19
 * Time: 7:07 PM
 */

namespace RockBuzz\Post\View;

use RockBuzz\Post\Domain\Arguments\Argument;

class ControllerArgument {

    private $name;

    private $type;

    private $column;

    private function __construct(string $name, string $type, string $column) {
        $this->name = $name;
        $this->type = $type;
        $this->column = $column;
    }

    public static function of(string $name, string $type, string $column): self {
        return new self($name, $type, $column);
    }

    public function getName(): string {
        return $this->name;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getColumn(): string {
        return $this->column;
    }

    /**
     * @param mixed $value
     *
     * @return Argument
     */
    public function newArgumentInstance($value): Argument {
        return call_user_func([$this->type, "of"], $this->column, $value);
    }
}