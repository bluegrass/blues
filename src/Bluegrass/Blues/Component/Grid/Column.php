<?php

namespace Bluegrass\Blues\Component\Grid;

class Column
{
    private $name;
    private $label;

    public function __construct($name, $label)
    {
        $this->setName($name);
        $this->setLabel($label);
    }

    protected function setName($value)
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    protected function setLabel($value)
    {
        $this->label = $value;
    }

    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Procesa una fila o conjunto de valores para generar el valor de una celda.
     *
     * @param $value Fila o conjunto de valores a procesar.
     */
    public function processValue($row)
    {
        return $row[$this->getName()];
    }
}
