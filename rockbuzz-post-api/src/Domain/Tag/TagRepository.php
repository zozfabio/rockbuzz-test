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
use RockBuzz\Post\Domain\Repository;

/**
 * @method TagEntity[] findAll()
 * @method TagEntity findOne(int $id)
 *
 * @method TagEntity save(TagEntity $entity)
 * @method TagEntity delete(TagEntity $entity)
 */
class TagRepository extends Repository {

    protected $entityClass = TagEntity::class;

    public function __construct(Container $container) {
        parent::__construct($container[EntityManager::class]);
    }
}