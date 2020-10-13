<?php

namespace Training\Product\ViewModel;

class Product implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $urlBuilder;

    private $_registry;

    private $_escaper;


    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Escaper $escaper
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->_registry = $registry;
        $this->_escaper = $escaper;
    }

    private function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

    public function getCurrentProductId()
    {
        $currentProduct = $this->getCurrentProduct();

        return $this->_escaper->escapeJs($currentProduct->getId());
    }

    private function getCurrentProductType()
    {
        $currentProduct = $this->getCurrentProduct();

        return $currentProduct->getTypeId();
    }

    public function canShow() : bool
    {
        if ($this->getCurrentProductType() === 'simple') {
            return true;
        }

        return false;
    }

    public function getActionUrl()
    {
        return $this->urlBuilder->getUrl('training_product/stock');
        // it can be found in parent too
    }
}
