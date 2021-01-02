<?php
declare(strict_types=1);

namespace Developer\RequestPrice\Ui\DataProvider\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Developer\RequestPrice\Model\ResourceModel\Request\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $data = $this->dataPersistor->get('request_price');

        if (!empty($data)) {
            $requestPrice = $this->collection->getNewEmptyItem();
            $requestPrice->setData($data);
            $this->loadedData[$requestPrice->getId()] = $requestPrice->getData();
            $this->dataPersistor->clear('request_price');
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var \Developer\RequestPrice\Model\Request $request_item */
        foreach ($items as $request_item) {
            $this->loadedData[$request_item->getId()] = $request_item->getData();
        }
        return $this->loadedData;
    }
}
