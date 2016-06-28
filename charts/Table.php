<?php

require_once('../GoogleChart.php');

class Table extends GoogleChart 
{
    private $package;
    private $chart_class;

    public function __construct(GoogleChart $chart) 
    {
        $this->package = 'table';
        $this->chart_class = 'Table';
    }


}

?>
