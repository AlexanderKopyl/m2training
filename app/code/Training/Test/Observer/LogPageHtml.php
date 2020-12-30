<?php

declare(strict_types=1);

namespace Training\Test\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use \Psr\Log\LoggerInterface;

class LogPageHtml implements ObserverInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * LogPageHtml constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        // TODO: Implement execute() method.
        $response = $observer->getEvent()->getData('response');
        $this->logger->debug($response->getBody());
    }
}
