<?php

namespace App\Services;

use Automattic\WooCommerce\Client;

class WooCommerceService
{
    private $woocommerce;

    public function __construct()
    {
        $this->woocommerce = new Client(
            config('woocommerce.store_url'),
            config('woocommerce.consumer_key'),
            config('woocommerce.consumer_secret'),
            [
                'version' => 'wc/v3',
            ]
        );
    }

    public function createProduct($data)
    {
        return $this->woocommerce->post('products', $data);
    }

    public function updateProduct($id, $data)
    {
        return $this->woocommerce->put("products/{$id}", $data);
    }

    public function getProduct($id)
    {
        return $this->woocommerce->get("products/{$id}");
    }

    public function getOrders()
    {
        return $this->woocommerce->get('orders');
    }

    public function getOrder($id)
    {
        return $this->woocommerce->get("orders/{$id}");
    }
}