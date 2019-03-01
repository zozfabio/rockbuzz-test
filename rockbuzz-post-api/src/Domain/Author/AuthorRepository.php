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
use RockBuzz\Post\Domain\Repository;

/**
 * @method AuthorEntity[] findAll()
 * @method AuthorEntity findOne(int $id)
 *
 * @method AuthorEntity save(AuthorEntity $entity)
 * @method AuthorEntity delete(AuthorEntity $entity)
 */
class AuthorRepository extends Repository {

    protected $entityClass = AuthorEntity::class;

    public function __construct(Container $container) {
        parent::__construct($container[EntityManager::class]);
    }
}