<?php


namespace Developer\Blog\Api\Data;


use Developer\Blog\Model\Post;

interface PostInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const POST_ID = 'post_id';
    const AUTHOR_NAME = 'author';
    const SHORT_DESCRIPTION = 'short_description';
    const META_DESCRIPTION = 'meta_description';
    const META_TITLE = 'meta_title';
    const IDENTIFIER = 'identifier';
    const CONTENT = 'content';
    const THUMB = 'thumb';
    const SORT_ORDER = 'sort_order';
    const POST_LAYOUT = 'post_layout';
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
     * Get page layout
     *
     * @return string|null
     */
    public function getAuthorName();

    /**
     * Get author name
     *
     * @return string|null
     */
    public function getShortDescription();

    /**
     * Get page layout
     *
     * @return string|null
     */
    public function getMetaDescription();

    /**
     * Get page layout
     *
     * @return string|null
     */
    public function getMetaTitle();

    /**
     * Get page layout
     *
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Get page layout
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get page layout
     *
     * @return string|null
     */
    public function getThumb();

    /**
     * Get page layout
     *
     * @return string|null
     */
    public function getSortOrder();

    /**
     * Get page layout
     *
     * @return string|null
     */
    public function getPostLayout();

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
    public function setId($id);

    /**
     * Set author name
     *
     * @param string $authorName
     * @return PostInterface
     */
    public function setAuthorName($authorName);

    /**
     * Set author name
     *
     * @param string $shortDescription
     * @return PostInterface
     */
    public function setShortDescription($shortDescription);


    /**
     * Set author name
     *
     * @param string $metaDescription
     * @return PostInterface
     */
    public function setMetaDescription($metaDescription);

    /**
     * Set author name
     *
     * @param string $metaTitle
     * @return PostInterface
     */
    public function setMetaTitle($metaTitle);

    /**
     * Set author name
     *
     * @param string $identifier
     * @return PostInterface
     */
    public function setIdentifier($identifier);

    /**
     * Set author name
     *
     * @param string $content
     * @return PostInterface
     */
    public function setContent($content);

    /**
     * Set author name
     *
     * @param string $thumb
     * @return PostInterface
     */
    public function setThumb($thumb);

    /**
     * Set author name
     *
     * @param string $sortOrder
     * @return PostInterface
     */
    public function setSortOrder($sortOrder);

    /**
     * Set author name
     *
     * @param string $postLayout
     * @return PostInterface
     */
    public function setPostLayout($postLayout);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return PostInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return PostInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return PostInterface
     */
    public function setIsActive($isActive);
}
