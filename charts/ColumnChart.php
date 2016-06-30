<?php

require_once('../GoogleChart.php');

class ColumnChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'ColumnChart'; 
        parent::__construct($data, $config);
    }
}

?>
