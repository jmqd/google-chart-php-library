<?php

require_once('../GoogleChart.php');

class ScatterChart extends GoogleChart 
{

    protected function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'ScatterChart';
        $this->chart_settings['point_size'] = 1;
        parent::__construct($data, $config);
    }

}

?>
