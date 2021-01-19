<?php
declare(strict_types=1);


namespace Developer\Blog\Model;

use Developer\Blog\Api\Data\PostInterface;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements PostInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
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
    public function getAuthorName(): ?string
    {
        return (string)$this->getData(self::AUTHOR_NAME);
    }

    /**
     * Retrieve post creation time
     *
     * @return string
     */
    public function getCreationTime(): ?string
    {
        return $this->getData(self::CREATION_TIME);
    }


    /**
     * Retrieve post update time
     *
     * @return string
     */
    public function getUpdateTime(): ?string
    {
        return $this->getData(self::UPDATE_TIME);
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
    public function setId($id): PostInterface
    {
        return $this->setData(self::POST_ID, $id);
    }

    /**
     * Set author name
     *
     * @param string $authorName
     * @return PostInterface
     */
    public function setAuthorName(string $authorName) : PostInterface
    {
        return $this->setData(self::AUTHOR_NAME, $authorName);
    }
    /**
     * Set creation time
     * @param string $creationTime
     * @return  PostInterface
     */
    public function setCreationTime(string $creationTime): PostInterface
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return PostInterface
     */
    public function setUpdateTime(string $updateTime): PostInterface
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }
    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return PostInterface
     */
    public function setIsActive($isActive): PostInterface
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }


}
