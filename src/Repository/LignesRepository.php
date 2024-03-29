<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Facture;
use App\Entity\Lignes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lignes>
 *
 * @method Lignes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lignes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lignes[]    findAll()
 * @method Lignes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LignesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lignes::class);
    }

    public function add(Lignes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Lignes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Lignes[] Returns an array of Lignes objects
     */
    public function getLignesByFacture(Facture $facture): array
    {
        return $this->createQueryBuilder('l')
            ->join('App\Entity\Article','a')
            ->andWhere('a.id = l.article')
            ->andWhere('l.facture = :val')
            ->setParameter('val', $facture)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Lignes
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
