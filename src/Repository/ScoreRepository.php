<?php

namespace App\Repository;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Score>
 * @SuppressWarnings(PHPMD)
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Score $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Score $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findHighScore(): int
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT MAX(score) FROM score
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        // returns an array of arrays (i.e. a raw data set)
        $res = $resultSet->fetchAllAssociative();
        return $res[0]['MAX(score)'];
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function resetScore(): void
    {
        $conn = $this->getEntityManager()->getConnection();
        $handle = fopen("../public/sql/resetScore.sql", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $sql = $line;
                $stmt = $conn->prepare($sql);
                $stmt->executeQuery();
            }
        }
    }
}
