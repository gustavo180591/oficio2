<?php

namespace App\Repository;

use App\Entity\Registro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Registro>
 */
class RegistroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Registro::class);
    }
/**
     * Método personalizado para buscar registros por oficio y delegación.
     */
    public function buscar($oficio, array $delegaciones)
    {
        return $this->createQueryBuilder('r')
            ->join('r.delegacion', 'd')  // Hacemos un JOIN con la tabla delegacion
            ->andWhere('r.oficio = :oficio')
            ->andWhere('d.id IN (:delegaciones)')  // Filtramos usando los IDs de las delegaciones
            ->setParameter('oficio', $oficio)
            ->setParameter('delegaciones', $delegaciones)
            ->getQuery()
            ->getResult();
    }
    
    //    /**
    //     * @return Registro[] Returns an array of Registro objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Registro
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

}
