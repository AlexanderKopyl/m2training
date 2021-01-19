<?php


namespace Developer\Blog\Api\Data;


use Developer\Blog\Model\Post;

interface PostInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const POST_ID = 'post_id';
    const AUTHOR_NAME = 'author_name';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();
    /**
     * Get author name
     *
     * @return string
     */
    public function getAuthorName();
    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();
    /**
     * Get update time
     * @return string|null
     */
    public function getUpdateTime();
    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return Post|PostInterface
     */
    public function setId(int $id): PostInterface;

    /**
     * Set author name
     *
     * @param string $authorName
     * @return PostInterface
     */
    public function setAuthorName(string $authorName): PostInterface;
    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return PostInterface
     */
    public function setCreationTime(string $creationTime): PostInterface;

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return PostInterface
     */
    public function setUpdateTime(string $updateTime): PostInterface;
    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return PostInterface
     */
    public function setIsActive($isActive): PostInterface;
}
