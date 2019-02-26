<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/23/19
 * Time: 7:04 PM
 */

namespace RockBuzz\Post\Domain\Arguments;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

class ArgumentEqualsNull extends ArgumentEquals {

    public function append(QueryBuilder $builder, Criteria $criteria) {
    }
}