<?php


namespace App\Action\Product;


use App\Core\AbstractAction;
use App\Service\StockManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetPriceAction
 * @package App\Action\Product
 * @Route("/product/price/{productId}/{numberOfItems}", name="get_total_price")
 */
class GetPriceAction extends AbstractAction
{
    /**
     * @var StockManager
     */
    private $stockManager;

    public function __construct(StockManager $stockManager)
    {
        $this->stockManager = $stockManager;
    }

    public function __invoke(int $productId, int $numberOfItems)
    {
        try {
            $price = $this->stockManager->getTotalPrice($productId, $numberOfItems);
            return $this->renderSuccess(['price' => $price]);
        } catch (\Exception $exception) {
            return $this->renderError($exception->getCode(), ['message' => $exception->getMessage()]);
        }
    }
}