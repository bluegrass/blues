<?php

namespace Bluegrass\Blues\Component\DataSource;

interface DataSourceInterface
{
    public function getData($page = 1, $rowsPerPage = null);

    public function count();
    
    public function getIterator();
    
    public function addOrderBy( $field, $dir );
}
