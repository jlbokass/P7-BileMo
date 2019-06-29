<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Client::class);
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function search($clientId,$term, $order = 'asc', $limit = 10, $offset = 0)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->addSelect('c')
            ->where('c.user = :id')
            ->setParameter('id', $clientId)
            ->orderBy('c.username', $order)
        ;

        if ($term) {
            $qb
                ->andWhere('c.username LIKE ?1')
                ->setParameter(1, '%'.$term.'%')
            ;
        }

        return $this->paginate($qb, $limit, $offset);
    }

    public function search2($client_id, $term, $order = 'asc', $limit = 20)
    {
        $qb = $this
            ->createQueryBuilder('u')
            ->select('u')
            ->Where('u.client = :id')
            ->setParameter('id', $client_id)
            ->orderBy('u.username', $order)

        ;
        if ($term) {
            $qb
                ->andWhere('u.username LIKE ?1')
                ->setParameter(1, '%'.$term.'%')
            ;
        }

        return $this->paginate($qb, $limit);
    }
}
