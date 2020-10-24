<?php


namespace App\Command;


use App\Entity\Lot;
use App\Repository\LotRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TooManyExpiredProductSoonCommand extends Command
{
    protected static $defaultName = 'app:check-expired-product';
    const MAX_ALLOWED_EXPIRED_COUNT = 200;
    /** @var LotRepository  */
    private $lotRepository;
    /** @var \Swift_Mailer  */
    private $mailer;

    public function __construct(LotRepository $lotRepository, \Swift_Mailer $mailer, string $name = null)
    {
        $this->mailer = $mailer;
        $this->lotRepository = $lotRepository;
        parent::__construct($name);
    }

    public function configure()
    {
        $this->addArgument('max-count', InputArgument::OPTIONAL);
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this->lotRepository->getLotToExpireInNextTwoDays();
        $totalCount = 0;
        /** @var Lot $product */
        foreach ($products as $product) {
            $totalCount = $totalCount + $product->getHowManyItems();
        }
        $allowedCount = $input->getArgument('max-count') ?? self::MAX_ALLOWED_EXPIRED_COUNT;
        if ($totalCount > $allowedCount) {
            $message = (new \Swift_Message('EXPIRED PRODUCTS ALERTS'))
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                ->setBody('A lot of products will be expired soon')
            ;

            $this->mailer->send($message);
        }

        return 0;
    }
}