<?php


namespace App\Service;


use App\Entity\Lot;
use App\Repository\LotRepository;
use Doctrine\ORM\EntityManagerInterface;

class StockManager
{
    /** @var EntityManagerInterface  */
    private $entityManager;
    /** @var LotRepository  */
    private $lotRepository;
    public function __construct(EntityManagerInterface $entityManager, LotRepository $lotRepository)
    {
        $this->entityManager = $entityManager;
        $this->lotRepository = $lotRepository;
    }

    /**
     * @param Lot $lot
     * @return int|null
     */
    public function save(Lot $lot)
    {
        $this->entityManager->persist($lot);
        $this->entityManager->flush();
        return $lot->getId();
    }

    public function getTotalPrice(int $productId, int $numberOfItems)
    {
        $lots = $this->lotRepository->getLotsWillExpiredSoon($productId);
        $found = 0;
        /** @var Lot $lot */
        foreach ($lots as $lot) {
            $found = $found + $lot->getHowManyItems();
            if ($found >= $numberOfItems) {
                return ($lot->getProduct()->getPrice()/2)*$numberOfItems;
            }
        }
        $goodLots = 0;
        $anotherLots = $this->lotRepository->getGoodLots($productId);
        /** @var Lot $lot */
        foreach ($anotherLots as $lot) {
            $goodLots = $goodLots + $lot->getHowManyItems();
            $totalLots = $goodLots + $found;
            if ($totalLots >= $numberOfItems) {
                return (($numberOfItems-$found)*$lot->getProduct()->getPrice()) + ($lot->getProduct()->getPrice()/2)*$found;
            }
        }
        throw new \Exception('Not enough product available');
    }

    /**
     * @param int $productId
     * @param int $numberOfItems
     * @return void
     * @throws \Exception
     */
    public function decreaseAvailableLots(int $productId, int $numberOfItems)
    {
        $lots = $this->lotRepository->getLotsWillExpiredSoon($productId);
        $current = $numberOfItems;
        /** @var Lot $lot */
        foreach ($lots as $lot) {
            if ($lot->getHowManyItems() >= $current) {
                $itemsCount = $lot->getHowManyItems();
                $lot->setHowManyItems($itemsCount - $current);
                $current = 0;
            } else {
                $current = $current - $lot->getHowManyItems();
                $lot->setHowManyItems(0);
            }
            if ($current === 0) break;
        }
        throw new \Exception('Not enough product available');
    }
}