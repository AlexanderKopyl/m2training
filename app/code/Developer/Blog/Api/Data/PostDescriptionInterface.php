<?php

namespace Developer\Blog\Api\Data;

use Developer\Blog\Model\PostDescription;

interface PostDescriptionInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const POST_ID = 'post_id';
    const DESCRIPTION = 'description';
    const TITLE = 'title';
    const META_DESCRIPTION = 'meta_description';
    const META_TITLE = 'meta_title';
    const SHORT_DESCRIPTION = 'SHORT_DESCRIPTION';
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * @return string|null
     */
    public function getDescription();
    /**
     * @return string|null
     */
    public function getShortDescription();

    /**
     * @return string|null
     */
    public function getMetaTitle();

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @return string|null
     */
    public function getMetaDescription();
    /**
     * Set ID
     *
     * @param int $id
     * @return PostDescription|PostDescriptionInterface
     */
    public function setId(int $id): PostDescriptionInterface;
    /**
     * @param $description
     * @return PostDescriptionInterface
     */
    public function setDescription($description): PostDescriptionInterface;
    /**
     * @param $short_description
     * @return PostDescriptionInterface
     */
    public function setShortDescription($short_description): PostDescriptionInterface;

    /**
     *  @param $meta_title
     *  @return PostDescriptionInterface
     */
    public function setMetaTitle($meta_title);

    /**
     *  @param $title
     *  @return PostDescriptionInterface
     */
    public function setTitle($title);
    /**
     * @param $meta_description
     * @return PostDescriptionInterface
     */
    public function setMetaDescription($meta_description): PostDescriptionInterface;
}
