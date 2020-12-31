<?php
declare(strict_types=1);

namespace Developer\RequestPrice\Controller\Price;

use Developer\RequestPrice\Model\Request;

class Save implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $_request;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var
     */
    private $error;

    /**
     * @var \Developer\RequestPrice\Model\RequestFactory
     */
    private $requestPriceFactory;
    /**
     * @var \Developer\RequestPrice\Model\ResourceModel\Request
     */
    private $requestPriceResource;

    public function __construct(
        \Developer\RequestPrice\Model\RequestFactory $requestPriceFactory,
        \Developer\RequestPrice\Model\ResourceModel\Request $requestPriceResource,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->_request = $request;
        $this->requestPriceFactory = $requestPriceFactory;
        $this->requestPriceResource = $requestPriceResource;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $json = [];

        if ($post = $this->_request->getPostValue()) {

            $this->validatePost($post);

            if (!$this->error) {
                $requestPrice = $this->requestPriceFactory->create();
                $requestPrice->setData($post);
                $this->requestPriceResource->save($requestPrice);
                $json['success'] = __('Thank you for your Request Price, wait for email from Administrator.');
            } else {
                $json['error'] = $this->error;
                $resultJson->setData($json);
                return $resultJson;
            }
        }
        $resultJson->setData($json);
        return $resultJson;
    }

    private function validatePost($post)
    {
        if (!isset($post['name']) || trim($post['name']) === '') {
            $this->error['name'] = __('Name is missing');
        }
        if (!isset($post['email']) || false === \strpos($post['email'], '@')) {
            $this->error['email'] = __('Invalid email address');
        }
    }
}
