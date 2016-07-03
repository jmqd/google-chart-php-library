<?php

class SteppedAreaChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'SteppedAreaChart'; 
        parent::__construct($data, $config);
    }
}

?>
