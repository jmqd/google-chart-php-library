<?php

require_once('../GoogleChart.php');

class BarChart extends GoogleChart 
{
    
    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'BarChart';
        parent::__construct($data, $config);
    }

}

?>
