<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 4:49 PM
 */

namespace RockBuzz\Post\Domain\Author;

use Doctrine\ORM\EntityManager;
use Pimple\Container;

class AuthorRepository {

    /** @var EntityManager */
    private $em;

    public function __construct(Container $container) {
        $this->em = $container[EntityManager::class];
    }

    /**
     * @return AuthorEntity[]
     */
    public function findAll() {
        return $this->em->createQueryBuilder()->select("a")
            ->from(AuthorEntity::class, "a")
            ->getQuery()
            ->getResult();
    }
}