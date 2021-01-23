<?php
declare(strict_types=1);

namespace Developer\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Upload extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    /**
     * @var string
     */
    const IMAGE_TMP_PATH = 'blog/tmp/images/image';
    /**
     * @var string
     */
    const IMAGE_PATH = 'blog/images/image';


    protected $imageUploader;

    protected $resultFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Developer\Blog\Model\ImageUploader $imageUploader,
        ResultFactory $resultFactory
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }

    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('thumb');
            $result['cookie'] = [
              'name' => $this->_getSession()->getName(),
              'value' => $this->_getSession()->getSessionId(),
              'lifetime' => $this->_getSession()->getCookieLifetime(),
              'path' => $this->_getSession()->getCookiePath(),
              'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
