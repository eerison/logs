<?php

namespace App\Repository;

use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    public function persist(Log $log): Log
    {
        $this->getEntityManager()->persist($log);

        return $log;
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}