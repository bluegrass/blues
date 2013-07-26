<?php

namespace Bluegrass\Blues\Component\Widget\AjaxGrid\Builder;

use Bluegrass\Blues\Component\Model\Web\Location\WebLocation;
use Bluegrass\Blues\Component\Widget\Grid\Builder\GridWidgetBuilderInterface;

/**
 *
 * @author ldelia
 */
interface AjaxGridWidgetBuilderInterface extends GridWidgetBuilderInterface
{
    public function withDataAjaxRequestRoute( WebLocation $route );
}