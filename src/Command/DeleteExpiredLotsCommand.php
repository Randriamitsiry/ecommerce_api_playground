<?php


namespace App\Command;


use App\Entity\Lot;
use App\Repository\LotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteExpiredLotsCommand extends Command
{
    protected static $defaultName = 'app:delete-expired-product';
    /** @var LotRepository  */
    private $lotRepository;
    /** @var EntityManagerInterface  */
    private $entityManager;
    public function __construct(LotRepository $lotRepository, EntityManagerInterface  $entityManager, string $name = null)
    {
        $this->lotRepository = $lotRepository;
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $toDeletes = $this->lotRepository->getExpiredLots();
        /** @var Lot $toDelete */
        foreach ($toDeletes as $toDelete) {
            $this->entityManager->remove($toDelete);
        }

        $this->entityManager->flush();

        return 0;
    }
}