<?php

namespace App\Repository;

use App\Entity\Lot;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lot[]    findAll()
 * @method Lot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lot::class);
    }
    public function getLotsWillExpiredSoon(int $product)
    {
        $qb = $this->createQueryBuilder('lot');
        return $qb->where('lot.expireAt < :refDate')
            ->andWhere('lot.product = :product')
            ->andWhere('lot.expireAt > :currentDate')
            ->orderBy('lot.expireAt', 'ASC')
            ->setParameters([
                'refDate' => (new \DateTime())->modify('+2 days'),
                'product' => $product,
                'currentDate' => new \DateTime()
            ])->getQuery()->getResult();
    }

    /**
     * @return mixed
     */
    public function getLotToExpireInNextTwoDays()
    {
        $qb = $this->createQueryBuilder('lot');
        return $qb->where('lot.expireAt < :refDate')
            ->andWhere('lot.expireAt > :currentDate')
            ->orderBy('lot.expireAt', 'ASC')
            ->setParameters([
                'refDate' => (new \DateTime())->modify('+2 days'),
                'currentDate' => new \DateTime()
            ])->getQuery()->getResult();
    }

    public function getExpiredLots()
    {
        $qb = $this->createQueryBuilder('lot');
        return $qb->where('lot.expireAt < :currentDate')
            ->orderBy('lot.expireAt', 'ASC')
            ->setParameters([
                'currentDate' => new \DateTime()
            ])->getQuery()->getResult();
    }

    public function getGoodLots(int $product)
    {
        $qb = $this->createQueryBuilder('lot');
        return $qb->where('lot.expireAt > :refDate')
            ->andWhere('lot.product = :product')
            ->orderBy('lot.expireAt', 'ASC')
            ->setParameters([
                'refDate' => (new \DateTime())->modify('+2 days'),
                'product' => $product
            ])->getQuery()->getResult();
    }
}
