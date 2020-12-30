<?php

namespace Training\Product\ViewModel;

class Product implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $urlBuilder;

    private $_registry;

    private $_escaper;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $_request;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $_productRepository;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Escaper $escaper
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->_escaper = $escaper;
        $this->_request = $request;
        $this->_productRepository= $productRepository;
    }

    private function getCurrentProduct()
    {
        $product_id = $this->_request->getParam('id');
        $currentProduct = $this->_productRepository->getById($product_id);

        return $currentProduct;
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
