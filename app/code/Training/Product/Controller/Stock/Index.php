<?php

declare(strict_types=1);

namespace Training\Product\Controller\Stock;

class Index implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    private $resultJsonFactory;

    private $_request;

    private $_request_test;

    protected $_stockItemRepository;


    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_request = $request;
        $this->_stockItemRepository = $stockItemRepository;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        $product_id = $this->_request->getPost('product_id');
        $result = $this->resultJsonFactory->create();
        if ($product_id) {
            $result->setData(json_encode($this->getStockItemQty($product_id)));
        } else {
            $result->setData(null);
        }
        return $result;
    }

    private function getStockItemQty($productId)
    {
        $item = $this->_stockItemRepository->get($productId);
        return $item->getQty();
    }
}
