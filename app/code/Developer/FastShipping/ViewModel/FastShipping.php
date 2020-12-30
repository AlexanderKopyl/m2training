<?php
declare(strict_types=1);

namespace Developer\FastShipping\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Checkout\Block\Cart\Additional\Info as AdditionalBlockInfo;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template as ViewTemplate;
use Magento\Framework\View\Element\Template\Context;

class FastShipping extends ViewTemplate implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * Product
     *
     * @var ProductInterface|null
     */
    protected $product = null;
    /**
     * Product Factory
     *
     * @var ProductInterfaceFactory
     */
    protected $productFactory;

    public function __construct(
        Context $context,
        \Magento\Catalog\Api\Data\ProductInterfaceFactory $productFactory
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
    }

    /**
     * Get Product Brand Text
     *
     * @return string
     */
    public function getProductFastShipping()
    {
        $product = $this->getProduct();
        if ($product->getCustomAttribute('fast_shipping')) {
            return  $product->getCustomAttribute('fast_shipping')->getValue();
        }

        return false;
    }
    /**
     * Get product from quote item
     *
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        try {
            $layout = $this->getLayout();
        } catch (LocalizedException $e) {
            $this->product = $this->productFactory->create();
            return $this->product;
        }
        /** @var AdditionalBlockInfo $block */
        $block = $layout->getBlock('additional.product.info');
        if ($block instanceof AdditionalBlockInfo) {
            $item = $block->getItem();
            $this->product = $item->getProduct();
        }
        return $this->product;
    }
}
