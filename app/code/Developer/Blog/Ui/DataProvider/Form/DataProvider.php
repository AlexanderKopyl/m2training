<?php
declare(strict_types=1);

namespace Developer\Blog\Ui\DataProvider\Form;

use Developer\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

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
        StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
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
        $data = $this->dataPersistor->get('developer_blog');

        if (!empty($data)) {
            $post = $this->collection->getNewEmptyItem();
            $post->setData($data);
            $this->loadedData[$post->getId()] = $post->getData();
            $this->dataPersistor->clear('developer_blog');
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var \Developer\Blog\Model\Post $post */
        foreach ($items as $posts) {
            $this->loadedData[$posts->getId()] = $posts->getData();
            if ($posts->getThumb()) {
                $m['thumb'][0]['name'] = $posts->getThumb();
                $m['thumb'][0]['url'] = $this->getMediaUrl() . $posts->getThumb();
                $fullData = $this->loadedData;
                $this->loadedData[$posts->getId()] = array_merge($fullData[$posts->getId()], $m);
            }

        }
        return $this->loadedData;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'blog/tmp/icon/';
        return $mediaUrl;
    }
}
