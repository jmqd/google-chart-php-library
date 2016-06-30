<?php

require_once('../GoogleChart.php');

class PieChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'PieChart';
        parent::__construct($data, $config);
    }

}

?>
