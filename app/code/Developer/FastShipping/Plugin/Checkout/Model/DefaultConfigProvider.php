<?php
declare(strict_types=1);

namespace Developer\FastShipping\Plugin\Checkout\Model;

use Magento\Checkout\Model\Session as CheckoutSession;

class DefaultConfigProvider
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * Constructor
     *
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(
        CheckoutSession $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    public function afterGetConfig(
        \Magento\Checkout\Model\DefaultConfigProvider $subject,
        array $result
    ) {
        $items = $result['totalsData']['items'];
        foreach ($items as $index => $item) {
            $quoteItem = $this->checkoutSession->getQuote()->getItemById($item['item_id']);

            if ($quoteItem->getProduct()->getData('fast_shipping')) {
                $result['totalsData']['items'][$index]['fast_shipping'] = $quoteItem->getProduct()->getData('fast_shipping');
            }
        }
        return $result;
    }
}
