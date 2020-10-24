<?php


namespace App\Action\Stock;


use App\Core\AbstractPostingAction;
use App\Entity\Lot;
use App\Service\ProductManager;
use App\Service\StockManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddItemAction
 * @package App\Action\Stock
 * @Route("/stock/add-item", name="add_product_stock")
 */
class AddItemAction extends AbstractPostingAction implements StockInterface
{
    /** @var ProductManager  */
    private $productManager;
    /** @var StockManager  */
    private $lotManager;
    public function __construct(ProductManager $productManager, StockManager $stockManager)
    {
        $this->productManager = $productManager;
        $this->lotManager = $stockManager;
    }
    public function __invoke(Request $request)
    {
        try {
            $payload = json_decode($request->getContent(), true);
            $this->validatePayload($payload);
            $lot = $this->craftStockFromPayload($payload);
            $this->lotManager->save($lot);
            return $this->renderSuccess([]);
        } catch (\Exception $exception) {
            return  $this->renderError($exception->getCode(), ['message' => $exception->getMessage()]);
        }
    }

    protected function getRequiredPayload(): array
    {
        return self::REQUIRED_PAYLOAD;
    }

    /**
     * @param array $payload
     * @return Lot
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    protected function craftStockFromPayload(array $payload)
    {
        $stock = new Lot();
        $stock->setExpireAt(new \DateTime($payload[self::EXPIRATION_DATE]));
        $stock->setHowManyItems($payload[self::HOW_MANY_ITEMS]);
        $stock->setProduct($this->productManager->get($payload[self::PRODUCT_ID]));
        return $stock;
    }
}