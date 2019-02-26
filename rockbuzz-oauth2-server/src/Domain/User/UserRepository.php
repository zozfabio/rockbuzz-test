<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/15/19
 * Time: 3:17 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\User;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Get a user by it's email.
     *
     * @param $email
     *
     * @return UserEntity|null
     */
    public function findOneByEmail($email) {
        $builder = $this->em->createQueryBuilder();

        try {
            return $builder->select("u")
                ->from(UserEntity::class, "u")
                ->where("u.email = ?1")
                ->setParameter(1, $email)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $ex) {
        } catch (NonUniqueResultException $ex) {
        }

        return null;
    }

    /**
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     * @param string $grantType The grant type used
     * @param ClientEntityInterface $clientEntity
     *
     * @return UserEntityInterface
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType,
                                                   ?ClientEntityInterface $clientEntity) {
        $user = $this->findOneByEmail($username);
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                return $user;
            }
        }

        return null;
    }
}