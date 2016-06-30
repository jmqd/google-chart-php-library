<?php

require_once('../GoogleChart.php');

class ScatterChart extends GoogleChart 
{
    protected $package;
    protected $chart_class;


    protected function __construct($data, $config) 
    {
        parent::__construct($data, $config);
        $this->package = 'corechart';
        $this->chart_class = 'ScatterChart';
        $this->chart_settings['point_size'] = 1;
    }

}

?>
