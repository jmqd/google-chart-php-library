<?php

require_once('../GoogleChart.php');

class AreaChart extends GoogleChart 
{
    private $package;
    private $chart_class;

    
    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'AreaChart';
        parent::__construct($data, $config);
    }

}

?>
