<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stage::class);
    }
/**
*@return Stage[] Returns an array of Stage objects
*/

    public function findByEntreprise()
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise','e')
            ->orderBy('s.entreprise', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

/**
*@return Stage[] Returns an array of Stage objects
*/

    public function findByNomEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise','e')
            ->where('e.intitule = :nomEnt')
            ->setParameter('nomEnt',$nomEntreprise)
            ->orderBy('s.entreprise', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

/**
*@return Stage[] Returns an array of Stage objects
*/
    public function findByNomFormation($nomFormation)
    {
      $gestEntite = $this->getEntityManager();

      $requete = $gestEntite->createQuery(
                              'SELECT s FROM App\Entity\Stage s
                              JOIN s.formations f
                              WHERE f.intitule = :nomFor'
                              );

      $requete->setParameter('nomFor',$nomFormation);
      return $requete->execute();
      /*  return $this->createQueryBuilder('s')
            ->join('s.formation','f')
            ->where('f.intitule = :nomFor')
            ->setParameter('nomFor',$nomFormation)
            ->orderBy('s.formation', 'DESC')
            ->getQuery()
            ->getResult()
        ; */
    }

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
