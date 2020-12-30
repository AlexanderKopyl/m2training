<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Developer\ManyStore\Plugin\Controller\Account;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Controller\Store\SwitchAction\CookieManager;
use Magento\Store\Model\StoreIsInactiveException;

/**
 * Post login customer action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class LoginPost
{
    const COOKIE_NAME = 'store';
    const COOKIE_DURATION = 86400;
    const STORE_LANGUAGE = 'store_language';
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var \Magento\Store\Api\StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface
     */
    private $_cookieManager;
    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */
    private $_cookieMetadataFactory;
    private $_request;
    /**
     * @var \Magento\Store\Api\StoreCookieManagerInterface
     */
    private $storeCookieManager;
    /**
     * @var \Magento\Store\Model\StoreSwitcherInterface
     */
    private $storeSwitcher;


    private $messageManager;


    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository,
//        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Api\StoreCookieManagerInterface $storeCookieManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Store\Model\StoreSwitcherInterface $storeSwitcher,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        CookieManager $cookieManager
//        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;

        $this->storeRepository = $storeRepository;
//        $this->storeManager = $storeManager;
        $this->_request = $request;
        $this->messageManager = $messageManager;
        $this->storeSwitcher = $storeSwitcher;
        $this->storeCookieManager = $storeCookieManager;
        $this->_cookieManager = $cookieManager;
//        $this->_cookieMetadataFactory = $cookieMetadataFactory;
    }

    public function afterExecute(
        \Magento\Customer\Controller\Account\LoginPost $subject,
        $result
    ) {
        $customerId = $this->customerSession->getCustomer()->getId();
        if ($customerId) {
            $lang = $this->getAttributeValue($customerId, self::STORE_LANGUAGE)->getValue();

            $storeCode = $this->getStoreCodeByValue($lang);

            $fromStoreCode = $this->_request->getParam(
                '___from_store',
                $this->storeCookieManager->getStoreCodeFromCookie()
            );

            $redirectUrl = "/";

            $error = null;
            try {
                $fromStore = $this->storeRepository->get($fromStoreCode);
                $targetStore = $this->storeRepository->getActiveStoreByCode($storeCode);

                $redirectUrl = $targetStore->getUrl();
            } catch (StoreIsInactiveException $e) {
                $error = __('Requested store is inactive');
            } catch (NoSuchEntityException $e) {
                $error = __("The store that was requested wasn't found. Verify the store and try again.");
            }
            if ($error !== null) {
                $this->messageManager->addErrorMessage($error);
            } else {
                $redirectUrl = $this->storeSwitcher->switch($fromStore, $targetStore, $redirectUrl);
                $this->_cookieManager->setCookieForStore($targetStore);
            }

            $result->setUrl($redirectUrl);
        }

        return $result;
    }

    public function getAttributeValue($customerId, string $code_attr)
    {
        $customer = $this->customerRepository->getById($customerId);
        return $customer->getCustomAttribute($code_attr);
    }

    private function getStoreCodeByValue($customerLangId)
    {
        $store_lang = [
            '1' => 'en',
            '2' => 'de',
            '3' => 'fr'
        ];
        if (array_key_exists($customerLangId, $store_lang)) {
            return $store_lang[$customerLangId];
        }
        return null;
    }
}
