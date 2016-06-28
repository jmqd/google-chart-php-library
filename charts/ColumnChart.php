<?php

require_once('../GoogleChart.php');

class ColumnChart extends GoogleChart 
{

    public function __construct(GoogleChart $chart) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'ColumnChart'; 
    }
}

?>
