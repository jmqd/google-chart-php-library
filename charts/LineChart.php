<?php

class LineChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'LineChart';
        parent::__construct($data, $config);
    }
}

?>
