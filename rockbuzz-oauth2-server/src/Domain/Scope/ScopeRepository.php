<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/16/19
 * Time: 7:59 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\Scope;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Get a scope by it's name
     *
     * @param string $name
     *
     * @return ScopeEntity|null
     */
    public function findOneByName($name) {
        $builder = $this->em->createQueryBuilder();

        try {
            return $builder->select("s")
                ->from(ScopeEntity::class, "s")
                ->where("s.name = ?1")
                ->setParameter(1, $name)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $ex) {
        } catch (NonUniqueResultException $ex) {
        }

        return null;
    }

    /**
     * Return information about a scope.
     *
     * @param string $identifier The scope identifier
     *
     * @return ScopeEntity|null
     */
    public function getScopeEntityByIdentifier($identifier) {
        return $this->findOneByName($identifier);
    }

    /**
     * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and optionally
     * append additional scopes or remove requested scopes.
     *
     * @param ScopeEntity[] $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null|string $userIdentifier
     *
     * @return ScopeEntity[]
     */
    public function finalizeScopes($scopes, $grantType, $clientEntity, $userIdentifier = null) {
        return $scopes;
    }
}