<?php
namespace Developer\RequestPrice\Model;

/**
 * Class Request
 */
class Request extends \Magento\Framework\Model\AbstractModel implements
    \Developer\RequestPrice\Api\Data\RequestInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'request_price';
    const STATUS_NEW = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_CLOSED = 3;

    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(\Developer\RequestPrice\Model\ResourceModel\Request::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
