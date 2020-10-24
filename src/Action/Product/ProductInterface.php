<?php


namespace App\Action\Product;


interface ProductInterface
{
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const PRICE = 'price';
    const PRODUCT_ID = 'product_id';

    const REQUIRED_PAYLOAD = [
        self::NAME,
        self::DESCRIPTION
    ];
}