<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/23/19
 * Time: 6:59 PM
 */

namespace RockBuzz\Post\Domain\Arguments;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

class ArgumentEqualsArray extends ArgumentEquals {

    private $name;

    private $value;

    /**
     * @param string $name
     * @param array $value
     */
    public function __construct($name, array $value) {
        $this->name  = $name;
        $this->value = $value;
    }

    public function append(QueryBuilder $builder, Criteria $criteria) {
        $criteria->andWhere(Criteria::expr()
            ->in($this->name, $this->value));
    }
}