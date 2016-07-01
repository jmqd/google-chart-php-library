<?php

class GaugeChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'GaugeChart';
        parent::__construct($data, $config);
    }

}

?>
