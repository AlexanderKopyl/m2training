<?php
declare(strict_types=1);

namespace Developer\Blog\Model\ResourceModel\Post;

use Developer\Blog\Api\Data\PostInterface;
use Developer\Blog\Model\ResourceModel\AbstractCollection;
use Magento\Store\Model\Store;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'post_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'developer_blog_post_collection';
    /**
     * @var string
     */
    protected $_eventObject = 'post_collection';

    protected function _construct()
    {
        $this->_init(
            \Developer\Blog\Model\Post::class,
            \Developer\Blog\Model\ResourceModel\Post::class
        );

        $this->_map['fields']['post_id'] = 'main_table.post_id';
        $this->_map['fields']['store'] = 'store_table.store_id';
    }


    /**
     * Set first store flag
     *
     * @param bool $flag
     * @return $this
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
            $this->setFlag('store_filter_added', true);
        }

        return $this;
    }

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $entityMetadata = $this->metadataPool->getMetadata(PostInterface::class);
        $this->performAfterLoad('blog_post_store', $entityMetadata->getLinkField());
        $this->_previewFlag = false;

        return parent::_afterLoad();
    }

    /**
     * Perform operations before rendering filters
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(PostInterface::class);
        $this->joinStoreRelationTable('blog_post_store', $entityMetadata->getLinkField());
    }
}
