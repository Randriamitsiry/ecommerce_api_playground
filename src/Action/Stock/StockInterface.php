<?php


namespace App\Action\Stock;


interface StockInterface
{
    const PRODUCT_ID = 'product_id';
    const HOW_MANY_ITEMS = 'count';
    const EXPIRATION_DATE = 'expiration_date';
    const REQUIRED_PAYLOAD = [self::PRODUCT_ID, self::HOW_MANY_ITEMS, self::EXPIRATION_DATE];
}