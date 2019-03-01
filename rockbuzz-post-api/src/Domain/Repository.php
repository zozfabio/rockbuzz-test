<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/27/19
 * Time: 8:27 PM
 */

namespace RockBuzz\Post\Domain;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;

abstract class Repository {

    protected $entityClass = "";

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    protected function getRepository(): EntityRepository {
        return $this->em->getRepository($this->entityClass);
    }

    protected function getBuilder(string $alias): QueryBuilder {
        return $this->getRepository()
            ->createQueryBuilder($alias);
    }

    public function findAll() {
        return $this->getRepository()
            ->findAll();
    }

    public function findOne($id) {
        $entity = $this->getRepository()
            ->find($id);

        if (!$entity) {
            throw new NotFoundRepositoryException("Entity {$id} not found!");
        }

        return $entity;
    }

    protected function findOneBy(array $criteria) {
        return $this->getRepository()
            ->findOneBy($criteria);
    }

    public function save(Identifiable $entity): Identifiable {
        if ($entity->getId()) {
            try {
                if (!$this->em->contains($entity)) {
                    $entity = $this->em->merge($entity);
                }
                $this->em->flush();
            } catch (ORMException $ex) {
                throw new RepositoryException("Fail to update an entity!", 0, $ex);
            }
        } else {
            try {
                $this->em->persist($entity);
                $this->em->flush();
            } catch (ORMException $ex) {
                throw new RepositoryException("Fail to persist a new entity!", 0, $ex);
            }
        }
        return $entity;
    }

    public function delete($entity) {
        try {
            $this->em->remove($entity);
            $this->em->flush();
        } catch (ORMException $ex) {
            throw new RepositoryException("Fail to remove an entity!", 0, $ex);
        }
    }
}