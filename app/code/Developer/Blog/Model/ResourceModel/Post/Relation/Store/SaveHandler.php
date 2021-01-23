<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Developer\Blog\Model\ResourceModel\Post\Relation\Store;

use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Developer\Blog\Api\Data\PostInterface;
use Developer\Blog\Model\ResourceModel\Post;
use Magento\Framework\EntityManager\MetadataPool;

/**
 * Class SaveHandler
 */
class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var Post
     */
    protected $resourcePost;

    /**
     * @param MetadataPool $metadataPool
     * @param Post $resourcePost
     */
    public function __construct(
        MetadataPool $metadataPool,
        Post $resourcePost
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourcePost = $resourcePost;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @throws \Exception
     */
    public function execute($entity, $arguments = [])
    {
        $entityMetadata = $this->metadataPool->getMetadata(PostInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $connection = $entityMetadata->getEntityConnection();

        $oldStores = $this->resourcePost->lookupStoreIds((int)$entity->getId());
        $newStores = (array)$entity->getStores();
        if (empty($newStores)) {
            $newStores = (array)$entity->getStoreId();
        }

        $table = $this->resourcePost->getTable('blog_post_store');

        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = [
                $linkField . ' = ?' => (int)$entity->getData($linkField),
                'store_id IN (?)' => $delete,
            ];
            $connection->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    $linkField => (int)$entity->getData($linkField),
                    'store_id' => (int)$storeId
                ];
            }
            $connection->insertMultiple($table, $data);
        }

        return $entity;
    }
}