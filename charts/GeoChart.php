<?php

class GeoChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'geochart';
        $this->chart_class = 'GeoChart';
        parent::__construct($data, $config);
    }
}

?>
