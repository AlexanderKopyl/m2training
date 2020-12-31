<?php
namespace Developer\RequestPrice\Model\ResourceModel\Request;

/**
 * Class Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(
            \Developer\RequestPrice\Model\Request::class,
            \Developer\RequestPrice\Model\ResourceModel\Request::class
        );
    }
}
