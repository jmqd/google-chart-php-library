<?php

require_once('../GoogleChart.php');

class Table extends GoogleChart 
{

    public function __construct(GoogleChart $chart) 
    {
        $this->package = 'table';
        $this->chart_class = 'Table';
        parent::__construct();
    }


}

?>
