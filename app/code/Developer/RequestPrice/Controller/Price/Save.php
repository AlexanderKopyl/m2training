<?php
declare(strict_types=1);

namespace Developer\RequestPrice\Controller\Price;

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

    private $error;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->_request = $request;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $json = [];
        $product_id = $this->_request->getPost('product_id');

        if ($post = $this->_request->getPostValue()) {

            $this->validatePost($post);

            if (!$this->error) {
                //TO DO
                //save data
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
