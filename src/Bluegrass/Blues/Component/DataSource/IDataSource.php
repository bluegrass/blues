<?php

namespace Bluegrass\Blues\Component\DataSource;

interface IDataSource
{
    function getData($page = 1, $rowsPerPage = null);

    function getCount();
}
