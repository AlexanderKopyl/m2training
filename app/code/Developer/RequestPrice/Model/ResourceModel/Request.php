<?php
namespace Developer\RequestPrice\Model\ResourceModel;

/**
 * Class Request
 */
class Request extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init('request_price', 'request_price_id');
    }
}
