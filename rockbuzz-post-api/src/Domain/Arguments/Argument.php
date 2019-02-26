<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/23/19
 * Time: 6:46 PM
 */

namespace RockBuzz\Post\Domain\Arguments;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

interface Argument {

    public function append(QueryBuilder $builder, Criteria $criteria);
}