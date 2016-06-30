<?php

require_once('../GoogleChart.php');

class PieChart extends GoogleChart 
{
    private $package;
    private $chart_class;


    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'LineChart';
        $this->data = $data;
        $this->config = $config;
        parent::__construct();
    }

}

?>
