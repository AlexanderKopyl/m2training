<?php
declare(strict_types=1);


namespace Developer\Blog\Model;

use Developer\Blog\Api\Data\PostDescriptionInterface;
use Magento\Framework\Model\AbstractModel;

class PostDescription extends AbstractModel implements PostDescriptionInterface
{

    /**
     * @var string
     */
    protected $_eventPrefix = 'developer_blog_description';
    /**
     * @var string
     */
    protected $_eventObject = 'post_description';

    protected function _construct()
    {
        $this->_init(\Developer\Blog\Model\ResourceModel\PostDescription::class);
    }

    /**
     * @return array|int|mixed|null
     */
    public function getId()
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }
    /**
     * Set ID
     *
     * @param int $id
     * @return PostDescription|PostDescriptionInterface
     */
    public function setId($id): PostDescriptionInterface
    {
        return $this->setData(self::POST_ID, $id);
    }
    /**
     * Set message
     *
     * @param string $description
     * @return  PostDescriptionInterface
     */
    public function setDescription($description) : PostDescriptionInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }


    public function getShortDescription()
    {
        return $this->getData(self::SHORT_DESCRIPTION);
    }

    public function getMetaTitle()
    {
        return $this->getData(self::META_TITLE);
    }

    public function getMetaDescription()
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function setShortDescription($short_description): PostDescriptionInterface
    {
        return $this->setData(self::SHORT_DESCRIPTION, $short_description);
    }

    public function setMetaTitle($meta_title): PostDescriptionInterface
    {
        return $this->setData(self::META_TITLE, $meta_title);
    }

    public function setMetaDescription($meta_description): PostDescriptionInterface
    {
        return $this->setData(self::META_DESCRIPTION, $meta_description);
    }


    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }
}
