<?php
declare(strict_types=1);

namespace Training\FeedbackProduct\Plugin\Ui\DataProvider\Form\DataProvider;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Training\Feedback\Api\FeedbackRepositoryInterface;

class AddProductsToFeedback
{
    private $feedbackRepository;
    private $imageHelper;
    private $status;
    private $attributeSetRepository;
    /**
     * @var \Training\FeedbackProduct\Model\FeedbackProductsFactory
     */
    private $productToFeedbackFactory;

    public function __construct(
        FeedbackRepositoryInterface $feedbackRepository,
        ImageHelper $imageHelper,
        \Training\FeedbackProduct\Model\FeedbackProductsFactory $productToFeedbackFactory,
        Status $status,
        AttributeSetRepositoryInterface $attributeSetRepository
    ) {
        $this->feedbackRepository = $feedbackRepository;
        $this->imageHelper = $imageHelper;
        $this->status = $status;
        $this->productToFeedbackFactory = $productToFeedbackFactory;
        $this->attributeSetRepository = $attributeSetRepository;
    }

    public function afterGetData(
        \Training\Feedback\Ui\DataProvider\Form\DataProvider $subject,
        $result
    ) {
        if (is_array($result) || is_object($result)) {
            if (count($result) > 0) {
                foreach ($result as $index => $feedbackData) {
                    try {
                        $feedback = $this->feedbackRepository->getById($feedbackData['feedback_id']);
                    } catch (NoSuchEntityException $e) {
                        continue;
                    }
                    $productFactory = $this->productToFeedbackFactory->create();

                    $productFactory->loadProductRelations($feedback);

                    $products = $feedback->getExtensionAttributes()->getProducts();
                    if (!$products) {
                        $result[$index]['assigned_feedback_products'] = [];
                    } else {
                        $assignedProducts = [];
                        foreach ($products as $product) {
                            $assignedProducts[] = $this->prepareProductDataData($product);
                        }
                        $result[$index]['assigned_feedback_products'] = $assignedProducts;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Prepare data column
     *
     * @param ProductInterface $assignedProduct
     * @return array
     */
    private function prepareProductDataData(ProductInterface $assignedProduct)
    {
        return [
            'id' => $assignedProduct->getId(),
            'thumbnail' => $this->imageHelper->init($assignedProduct, 'product_listing_thumbnail')->getUrl(),
            'name' => $assignedProduct->getName(),
            'status' => $this->status->getOptionText($assignedProduct->getStatus()),
            'attribute_set' => $this->attributeSetRepository
                ->get($assignedProduct->getAttributeSetId())
                ->getAttributeSetName(),
            'sku' => $assignedProduct->getSku(),
            'price' => $assignedProduct->getPrice(),
        ];
    }
}