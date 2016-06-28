<?php

require_once('../GoogleChart.php');

class GaugeChart extends GoogleChart 
{

    public function __construct(GoogleChart $chart) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'GaugeChart';

    }

}

?>
