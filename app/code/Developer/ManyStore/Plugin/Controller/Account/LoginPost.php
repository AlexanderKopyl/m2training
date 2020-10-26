<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Developer\ManyStore\Plugin\Controller\Account;

/**
 * Post login customer action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class LoginPost
{
    const STORE_LANGUAGE = 'store_language';
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;

        $this->storeRepository = $storeRepository;
        $this->storeManager = $storeManager;
    }

    public function afterExecute(
        \Magento\Customer\Controller\Account\LoginPost $subject,
        $result
    ) {
        $customerId = $this->customerSession->getCustomer()->getId();
        if ($customerId) {
            $lang = $this->getAttributeValue($customerId, self::STORE_LANGUAGE)->getValue();

            $storeCode = $this->getStoreCodeByValue($lang);

            $result->setUrl('/' . $storeCode . '/');
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
