<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 4:58 PM
 */

namespace RockBuzz\Post\Domain\Post;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\QueryException;
use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Post\Domain\Arguments\Argument;
use RockBuzz\Post\Domain\NotFoundRepositoryException;
use RockBuzz\Post\Domain\RepositoryException;
use RockBuzz\Post\Domain\RepositoryHasArguments;

class PostRepository {

    use RepositoryHasArguments;

    /** @var Logger */
    private $logger;

    /** @var EntityManager */
    private $em;

    public function __construct(Container $container) {
        $this->logger = $container[Logger::class];
        $this->em     = $container[EntityManager::class];
    }

    /**
     * @param Argument[] $arguments
     * @return PostEntity[]
     */
    public function findAll($arguments = []): array {
        $this->logger->debug("Arguments: ", $arguments);
        $builder  = $this->em->createQueryBuilder();
        $criteria = $this->createCriteria($builder, $arguments);

        try {
            return $builder
                ->select("post")
                ->distinct()
                ->from(PostEntity::class, "post")
                ->innerJoin("post.author", "author")
                ->leftJoin("post.tags", "tag")
                ->addCriteria($criteria)
                ->getQuery()
                ->getResult();
        } catch (QueryException $ex) {
            throw new RepositoryException("Fail building the posts query.", 0, $ex);
        }
    }

    public function findOneBySlug(string $slug): PostEntity {
        try {
            return $this->em->createQueryBuilder()
                ->select("post")
                ->from(PostEntity::class, "post")
                ->where("post.slug = ?1")
                ->setParameter(1, $slug)
                ->getQuery()
                ->setMaxResults(1)
                ->getSingleResult();
        } catch (NonUniqueResultException $ex) {
            throw new RepositoryException("Unexpected Exception!", 0, $ex);
        } catch (NoResultException $ex) {
            throw new NotFoundRepositoryException("Post {$slug} not found!", 0, $ex);
        }
    }
}