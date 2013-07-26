<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Model\Column;

class GridWidgetColumnModel implements GridWidgetColumnModelInterface
{
    private $name;

    public function __construct($name)
    {
        $this->setName($name);
    }

    protected function setName($value)
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

}
