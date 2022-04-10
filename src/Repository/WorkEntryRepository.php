<?php

namespace App\Repository;

use App\Entity\WorkEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkEntry[]    findAll()
 * @method WorkEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkEntry::class);
    }

    public function save(WorkEntry $workEntry): WorkEntry
    {
        $this->_em->persist($workEntry);
        $this->_em->flush();
        return $workEntry;
    }

    public function delete(WorkEntry $workEntry): WorkEntry
    {
        $workEntry->setDeletedAt(new \DateTime());
        $this->_em->persist($workEntry);
        $this->_em->flush();
        return $workEntry;
    }

    public function update(WorkEntry $workEntry): WorkEntry
    {
        $workEntry->setUpdatedAt(new \DateTime());
        $this->_em->persist($workEntry);
        $this->_em->flush();
        return $workEntry;
    }
}
