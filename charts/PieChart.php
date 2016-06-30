<?php

require_once('../GoogleChart.php');

class PieChart extends GoogleChart 
{
    private $package;
    private $chart_class;


    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'PieChart';
        $this->config = $config;
        $this->data = $data;
        parent::__construct();
    }

}

?>
