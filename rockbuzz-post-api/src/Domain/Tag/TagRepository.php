<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 4:59 PM
 */

namespace RockBuzz\Post\Domain\Tag;

use Doctrine\ORM\EntityManager;
use Pimple\Container;

class TagRepository {

    /** @var EntityManager */
    private $em;

    public function __construct(Container $container) {
        $this->em = $container[EntityManager::class];
    }

    /**
     * @return TagEntity[]
     */
    public function findAll() {
        return $this->em->createQueryBuilder()->select("t")
            ->from(TagEntity::class, "t")
            ->getQuery()
            ->getResult();
    }
}