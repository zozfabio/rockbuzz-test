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

class ArgumentEqualsDefault extends ArgumentEquals {

    private $name;

    private $value;

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __construct($name, $value) {
        $this->name  = $name;
        $this->value = $value;
    }

    public function append(QueryBuilder $builder, Criteria $criteria) {
        $criteria->andWhere(Criteria::expr()
            ->eq($this->name, $this->value));
    }
}