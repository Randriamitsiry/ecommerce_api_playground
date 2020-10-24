<?php

namespace App\Action\Product;

use App\Core\AbstractPostingAction;
use App\Service\ProductManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SetPriceAction
 * @package App\Action\Product
 * @Route("/product/set-price", name="set_product_price")
 */
class UpdatePriceAction extends AbstractPostingAction implements ProductInterface
{
    /** @var ProductManager  */
    private $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    public function __invoke(Request $request)
    {
        try {
            $payload = json_decode($request->getContent(), true);
            $this->validatePayload($payload);
            $this->productManager->setPrice($payload[self::PRODUCT_ID], floatval($payload[self::PRICE]));
            return new JsonResponse([]);
        } catch (\Exception $exception) {
            return $this->renderError($exception->getCode(), ['message' => $exception->getMessage()]);
        }
    }

    protected function getRequiredPayload(): array
    {
        return [self::PRICE, self::PRODUCT_ID];
    }
}