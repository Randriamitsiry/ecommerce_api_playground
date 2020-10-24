<?php


namespace App\Action\Order;


use App\Core\AbstractPostingAction;
use App\Service\OrderManager;
use App\Service\StockManager;
use Symfony\Component\HttpFoundation\Request;

class OrderProductsAction extends AbstractPostingAction
{
    /** @var StockManager  */
    private $stockManager;
    /** @var OrderManager  */
    private $orderManager;
    public function __construct(StockManager $stockManager, OrderManager $orderManager)
    {
        $this->stockManager = $stockManager;
        $this->orderManager = $orderManager;
    }
    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $this->validatePayload($payload);

    }

    protected function getRequiredPayload(): array
    {
        return ['orderId', 'contents'];
    }
}