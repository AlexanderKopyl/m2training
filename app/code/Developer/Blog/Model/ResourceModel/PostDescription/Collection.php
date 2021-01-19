<?php
declare(strict_types=1);


namespace Developer\Blog\Model\ResourceModel\PostDescription;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'developer_blog_post_description_collection';
    /**
     * @var string
     */
    protected $_eventObject = 'post_description_collection';

    protected function _construct()
    {
        $this->_init(
            \Developer\Blog\Model\PostDescription::class,
            \Developer\Blog\Model\ResourceModel\PostDescription::class
        );
    }
}
