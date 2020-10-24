<?php


namespace App\Action\Product;


use App\Core\AbstractPostingAction;
use App\Entity\Product;
use App\Service\ProductManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateAction
 * @package App\Action\Product
 * @Route("/product/create", name="api_create_product")
 */
class CreateAction extends AbstractPostingAction implements ProductInterface
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
            //get payload as json and convert it as an array
            $payload = json_decode($request->getContent(), true);
            //check if all required payload are given
            $this->validatePayload($payload);
            $product = $this->craftProductFromPayload($payload);
            //save to database
            $id = $this->productManager->saveProduct($product);
            return $this->renderSuccess(['product_id' => $id]);
        } catch (\Exception $exception) {
            return $this->renderError($exception->getCode(), ['message' => $exception->getMessage()]);
        }
    }

    protected function getRequiredPayload(): array
    {
        return self::REQUIRED_PAYLOAD;
    }

    protected function craftProductFromPayload(array $payload)
    {
        $product = new Product();
        $product->setName($payload[self::NAME])
            ->setDescription($payload[self::DESCRIPTION]);

        return $product;
    }
}