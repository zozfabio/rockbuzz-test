<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/16/19
 * Time: 7:37 PM
 */

namespace RockBuzz\OAuth2\Server\Domain\Client;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Get a client by it's name.
     *
     * @param $name
     *
     * @return ClientEntity|null
     */
    public function findOneByName($name) {
        $builder = $this->em->createQueryBuilder();

        try {
            return $builder->select("c")
                ->from(ClientEntity::class, "c")
                ->where("c.name = ?1")
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
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     * @param null|string $grantType The grant type used (if sent)
     * @param null|string $clientSecret The client's secret (if sent)
     * @param bool $mustValidateSecret If true the client must attempt to validate the secret if the client is confidential
     *
     * @return ClientEntity|null
     */
    public function getClientEntity($clientIdentifier, $grantType = null, $clientSecret = null, $mustValidateSecret = true) {
        $client = $this->findOneByName($clientIdentifier);

        if ($client) {
            if ($mustValidateSecret && $client->isConfidential()) {
                if (!password_verify($clientSecret, $client->getSecret())) {
                    return null;
                }
            }

            return $client;
        }

        return null;
    }
}