<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Column\Builder;

/**
 *
 * @author ldelia
 */
interface GridWidgetColumnBuilderInterface
{
    public function build();
    public function setLabel($label);
    public function setName($name);
}
