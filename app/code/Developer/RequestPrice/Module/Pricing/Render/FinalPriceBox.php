<?php
declare(strict_types=1);


namespace Developer\RequestPrice\Module\Pricing\Render;

use Magento\Catalog\Pricing\Price;
use Magento\Framework\Pricing\Render;
use Magento\Framework\Pricing\Render\PriceBox as BasePriceBox;
use Magento\Msrp\Pricing\Price\MsrpPrice;

class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    protected function wrapResult($html)
    {
        return '';

    }
}
