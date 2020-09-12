<?php

namespace Training\TestOM\Model;

class Test
{
    private $manager;
    private $arrayList;
    private $name;
    private $number;

    public function __construct(
        \Training\TestOM\Model\ManagerInterface $manager,
        $name,
        int $number,
        array $arrayList
    ) {
        $this->manager = $manager;
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
    }

    public function print_pretty($data)
    {
        print("<pre>" . print_r($data, true) . "</pre>");
    }
}
