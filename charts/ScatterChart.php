<?php

require_once('../GoogleChart.php');

class ScatterChart extends GoogleChart 
{
    private $package;
    private $chart_class;


    public function __construct(GoogleChart $chart) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'ScatterChart';

    }

}

?>
