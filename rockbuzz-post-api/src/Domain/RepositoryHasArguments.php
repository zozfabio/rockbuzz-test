<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/23/19
 * Time: 6:50 PM
 */

namespace RockBuzz\Post\Domain;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use RockBuzz\Post\Domain\Arguments\Argument;

trait RepositoryHasArguments {

    /**
     * @param QueryBuilder $builder
     * @param Argument[] $arguments
     * @return Criteria
     */
    private function createCriteria(QueryBuilder $builder, array $arguments): Criteria {
        $criteria = Criteria::create();
        foreach ($arguments as $argument) {
            $argument->append($builder, $criteria);
        }
        return $criteria;
    }
}