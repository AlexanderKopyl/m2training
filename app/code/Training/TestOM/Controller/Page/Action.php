<?php

namespace Training\TestOM\Controller\Page;

use Magento\Framework\App\Action\Action as M_Action;
use Magento\Framework\App\Action\Context;
use Training\TestOM\Model\PlayWithTest;

class Action extends M_Action
{
    private $new_Manager;

    public function __construct(
        Context $context,
        PlayWithTest $new_Manager
    ) {
        $this->new_Manager = $new_Manager;
        parent::__construct($context);
    }

    public function execute()
    {
        // TODO: Implement execute() method.

        $this->new_Manager->run();
    }
}
