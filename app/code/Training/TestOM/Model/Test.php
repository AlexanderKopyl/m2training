<?php

namespace Training\TestOM\Model;

class Test
{
    private $manager;
    private $managerFactory;
    private $arrayList;
    private $name;
    private $number;

    public function __construct(
        \Training\TestOM\Model\ManagerInterface $manager,
        \Training\TestOM\Model\ManagerFactory $managerFactory,
        $name,
        int $number,
        array $arrayList
    ) {
        $this->manager = $manager;
        $this->managerFactory = $managerFactory;
        $this->arrayList = $arrayList;
        $this->name = $name;
        $this->number = $number;
    }

    public function log()
    {
        $this->print_pretty(get_class($this->manager));
        echo '<br>';
        $this->print_pretty($this->name);
        echo '<br>';
        $this->print_pretty($this->number);
        echo '<br>';
        $this->print_pretty($this->arrayList);
        echo '<br>';
        $newManager = $this->managerFactory->create();
        $this->print_pretty(get_class($newManager));
    }

    public function print_pretty($data)
    {
        print("<pre>" . print_r($data, true) . "</pre>");
    }
}
