<?php
declare(strict_types=1);

namespace Developer\FastShipping\Plugin\Checkout\Cart;

use Magento\Quote\Model\Quote\Item;

class AddDefaultItem
{
    public function aroundGetItemData($subject, \Closure $proceed, Item $item)
    {
        $data = $proceed($item);
        $product = $item->getProduct();
        $atts = [];
        if ($product->getCustomAttribute('fast_shipping')) {
            $atts = [
                "fast_shipping" => $product->getCustomAttribute('fast_shipping')->getValue(),
            ];
        }

        return array_merge($data, $atts);
    }
}
