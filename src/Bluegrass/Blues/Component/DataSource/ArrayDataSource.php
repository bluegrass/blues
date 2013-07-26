<?php

namespace Bluegrass\Blues\Component\DataSource;

class ArrayDataSource implements DataSourceInterface, \Countable
{
    protected $arrayData;
    protected $orderByDefinitions;

    public function __construct(array $data)
    {
        $this->arrayData = $data;
        $this->orderByDefinitions = array();
    }
    
    protected function sortData()
    {
        $sortableData = array();
        
        foreach ($this->arrayData as $key => $row) {
            
            foreach( $this->orderByDefinitions as $orderBy ){
                $sortableData[ $orderBy['field']  ][ $key ] = $row[ $orderBy['field']  ];
            }
        }        
        
        if ( count( $this->orderByDefinitions ) == 1){
            array_multisort( $sortableData[ $this->orderByDefinitions[0]['field']  ], $this->orderByDefinitions[0]['dir'], $this->arrayData );
        }elseif( count( $this->orderByDefinitions ) == 2 ) {
            array_multisort( $sortableData[ $this->orderByDefinitions[0]['field']  ], $this->orderByDefinitions[0]['dir'], $sortableData[$this->orderByDefinitions[1]['field']  ], $this->orderByDefinitions[1]['dir'], $this->arrayData );
        }        
    }

    public function getData($page = 1, $rowsPerPage = null)
    {    
        $this->sortData();
        
        $count = $this->count();

        if (!$rowsPerPage) {
            $rowsPerPage = $count;
        } else {
            if ($rowsPerPage > $count)
                $rowsPerPage = $count;
        }

        $start = ($page - 1) * $rowsPerPage;
        $end = ($start + $rowsPerPage > $count) ? $count : $start + $rowsPerPage;

        $result = array();
        for ($i = $start; $i < $end; $i++) {
            $result [] = $this->arrayData[$i];
        }

        return $result;
    }

    public function count()
    {
        return count($this->arrayData);
    }
    
    public function getIterator()
    {
        return new \ArrayIterator( $this->arrayData );
    }
    
    public function addOrderBy( $field, $dir )
    {
        $this->orderByDefinitions[] = array( 'field' => $field, 'dir' => $dir );
    }
}
