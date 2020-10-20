<?php


namespace Training\FeedbackProduct\Model;

use Magento\Framework\Model\AbstractModel;

class FeedbackProducts extends AbstractModel
{
    private $feedbackDataLoader;
    private $feedbackProductsResource;
    public function __construct(
        \Training\FeedbackProduct\Model\FeedbackDataLoader $feedbackDataLoader,
        \Training\FeedbackProduct\Model\ResourceModel\FeedbackProducts $feedbackProductsResource
    ) {
        $this->feedbackDataLoader = $feedbackDataLoader;
        $this->feedbackProductsResource = $feedbackProductsResource;
    }
    public function loadProductRelations($feedback)
    {
        $productIds = $this->feedbackProductsResource->loadProductRelations($feedback->getId());
        return $this->feedbackDataLoader->addProductsToFeedbackByIds($feedback, $productIds);
    }
    public function saveProductRelations($feedback)
    {
        $productIds = [];
        $products = $feedback->getExtensionAttributes()->getProducts();
        if (is_array($products)) {
            foreach ($products as $product) {
                $productIds[] = $product->getId();
            }
        }
        $this->feedbackProductsResource->saveProductRelations($feedback->getId(), $productIds);
        return $this;
    }
}
