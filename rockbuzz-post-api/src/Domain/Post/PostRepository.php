<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/22/19
 * Time: 4:58 PM
 */

namespace RockBuzz\Post\Domain\Post;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\QueryException;
use Monolog\Logger;
use Pimple\Container;
use RockBuzz\Post\Domain\Arguments\Argument;
use RockBuzz\Post\Domain\NotFoundRepositoryException;
use RockBuzz\Post\Domain\Repository;
use RockBuzz\Post\Domain\RepositoryException;
use RockBuzz\Post\Domain\RepositoryHasArguments;

/**
 * @method PostEntity findOne(int $id)
 *
 * @method PostEntity save(PostEntity $entity)
 * @method PostEntity delete(PostEntity $entity)
 */
class PostRepository extends Repository {

    use RepositoryHasArguments;

    protected $entityClass = PostEntity::class;

    /** @var Logger */
    private $logger;

    public function __construct(Container $container) {
        parent::__construct($container[EntityManager::class]);
        $this->logger = $container[Logger::class];
    }

    /**
     * @param Argument[] $arguments
     * @return PostEntity[]
     */
    public function findAll($arguments = []): array {
        $builder  = $this->getBuilder("post");
        $criteria = $this->createCriteria($builder, $arguments);

        try {
            return $builder
                ->distinct()
                ->innerJoin("post.author", "author")
                ->leftJoin("post.tags", "tag")
                ->addCriteria($criteria)
                ->getQuery()
                ->getResult();
        } catch (QueryException $ex) {
            throw new RepositoryException("Fail building the posts query.", 0, $ex);
        }
    }

    /**
     * @param Argument[] $arguments
     * @return PostEntity[]
     */
    public function findAllPublished($arguments = []): array {
        $builder  = $this->getBuilder("post");
        $criteria = $this->createCriteria($builder, $arguments);

        $criteria->andWhere(Criteria::expr()->eq("published", true));

        try {
            return $builder
                ->distinct()
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
        /** @var PostEntity $post */
        $post = $this->findOneBy(["slug" => $slug]);
        if (!$post) {
            throw new NotFoundRepositoryException("Post {$slug} not found!");
        }
        return $post;
    }
}