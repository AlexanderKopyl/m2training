<?php

declare(strict_types=1);

namespace Training\Product\Controller\Stock;

class Index implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $_request;

    /**
     * @var \Magento\CatalogInventory\Model\Stock\StockItemRepository
     */
    protected $_stockItemRepository;

    /**
     * Index constructor.
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_request = $request;
        $this->_stockItemRepository = $stockItemRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // TODO: Implement execute() method.
        $product_id = $this->_request->getPost('product_id');
        $result = $this->resultJsonFactory->create();
        if ($product_id) {
            $result->setData(json_encode(['count' => $this->getStockItemQty($product_id)]));
        } else {
            $result->setData(null);
        }
        return $result;
    }

    /**
     * @param $productId
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getStockItemQty($productId)
    {
        $item = $this->_stockItemRepository->get($productId);
        return $item->getQty();
    }
}
