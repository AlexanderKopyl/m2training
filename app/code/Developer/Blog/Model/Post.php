<?php
declare(strict_types=1);

namespace Developer\Blog\Model;

use Developer\Blog\Api\Data\PostInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * @method Post setStoreId(int $storeId)
 * @method int getStoreId()
 *
 **/
class Post extends AbstractModel implements PostInterface, IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * Blog post cache tag
     */
    const CACHE_TAG = 'blog_p';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'developer_blog';
    /**
     * @var string
     */
    protected $_eventObject = 'post';

    protected function _construct()
    {
        $this->_init(\Developer\Blog\Model\ResourceModel\Post::class);
    }

    /**
     * @return array|int|mixed|null
     */
    public function getId()
    {
        return $this->getData(self::POST_ID);
    }
    /**
     * Get author name
     *
     * @return string
     */
    public function getAuthorName()
    {
        return (string)$this->getData(self::AUTHOR_NAME);
    }

    /**
     * Retrieve post creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }
    /**
     * Retrieve post update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * @return string|null
     */
    public function getShortDescription()
    {
        return $this->getData(self::SHORT_DESCRIPTION);
    }

    /**
     * @return string|null
     */
    public function getMetaDescription()
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * @return string|null
     */
    public function getMetaTitle()
    {
        return $this->getData(self::META_TITLE);
    }

    /**
     * @return string|null
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @return string|null
     */
    public function getThumb()
    {
        return $this->getData(self::THUMB);
    }

    /**
     * @return string|null
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * @return string|null
     */
    public function getPostLayout()
    {
        return $this->getData(self::POST_LAYOUT);
    }

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive() :?bool
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return Post|PostInterface
     */
    public function setId($id)
    {
        return $this->setData(self::POST_ID, $id);
    }

    /**
     * Set author name
     *
     * @param string $authorName
     * @return PostInterface
     */
    public function setAuthorName($authorName)
    {
        return $this->setData(self::AUTHOR_NAME, $authorName);
    }
    /**
     * Set creation time
     * @param string $creationTime
     * @return  PostInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return PostInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }
    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return PostInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * @param string $shortDescription
     * @return PostInterface|Post
     */
    public function setShortDescription($shortDescription)
    {
        return $this->setData(self::SHORT_DESCRIPTION, $shortDescription);
    }

    /**
     * @param string $metaDescription
     * @return PostInterface|Post
     */
    public function setMetaDescription($metaDescription)
    {
        return $this->setData(self::META_DESCRIPTION, $metaDescription);
    }

    /**
     * @param string $metaTitle
     * @return PostInterface|Post
     */
    public function setMetaTitle($metaTitle)
    {
        return $this->setData(self::META_TITLE, $metaTitle);
    }

    /**
     * @param string $identifier
     * @return PostInterface|Post
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * @param string $content
     * @return PostInterface|Post
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @param string $thumb
     * @return PostInterface|Post
     */
    public function setThumb($thumb)
    {
        return $this->setData(self::THUMB, $thumb);
    }

    /**
     * @param string $sortOrder
     * @return PostInterface|Post
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * @param string $postLayout
     * @return PostInterface|Post
     */
    public function setPostLayout($postLayout)
    {
        return $this->setData(self::POST_LAYOUT, $postLayout);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
