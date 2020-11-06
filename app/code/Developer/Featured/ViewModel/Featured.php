<?php

namespace Developer\Featured\ViewModel;

class Featured implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->productFactory = $productFactory;
        $this->_storeManager = $storeManager;
    }

    /**
     * function Get Categories
     * @throws \Magento\Framework\Exception\LocalizedException
     * @todo filter all categories on is_featured
     * @retrun array
     * @todo Get Categories witch featured in admin panel
     */
    private function getCategoriesFeatured()
    {
        $result = $this->categoryFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('is_featured', ['eq' => 1 ])
            ->addAttributeToFilter('level', 2)
            ->setStore($this->_storeManager->getStore());

        return $result;
    }

    /**
     * function Get Products in Categories
     * @todo Get Products is_featured in categories
     * @retrun array
     */
    public function getProductsFeatured()
    {
        $catigories = $this->getCategoriesFeatured();
        $products = [];
        foreach ($catigories as $catigory) {
            $product_to_category = $this->productFactory->create()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('is_featured', ['eq' => 1 ])
                ->addCategoriesFilter(['eq' => $catigory->getId()])
                ->setStore($this->_storeManager->getStore());

            $products[$catigory->getId()]['category_info'] = $catigory;
            $products[$catigory->getId()]['products'] = $product_to_category;
        }
        return $products;
    }
}
