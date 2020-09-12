<?php

namespace Training\TestOM\Controller\Page;

use Magento\Framework\App\Action\Action as M_Action;
use Magento\Framework\App\Action\Context;
use Training\TestOM\Model\Test;

class Action extends M_Action
{
    private $testPage;

    public function __construct(
        Context $context,
        Test $testPage
    ) {
        $this->testPage = $testPage;
        parent::__construct($context);

    }

    public function execute()
    {
        // TODO: Implement execute() method.

        $this->testPage->log();
    }
}
