# ecommerce_api_playground
Endpoints list:
 - /product/create : expects a json data with the product name and description as payload
 - /product/set-price: expects a json data with product id (product_id) and price as payload
 - /product/price/{productId}/{numberOfItems} : get total price of the given given product with the specified count items (This will priorize products that expiration date will come soon)
 - /stock/add-item: Add lot to the specified product. Expect a json data with the product id (product_id), count of items (count) and expiration date (expiration_date)
 - /order/place-order: Place an order of items. Expects the order ID (orderId) and the contents of the order (contents). 'contents' key will have an array of products with the count of items specified 
 
Alert on expiration date:
- This command should be executed by a cron everyday : `php bin/console app:check-expired-product`
Delete all expired products:
- This command should be executed by a cron everyday : `php bin/console app:delete-expired-product`
