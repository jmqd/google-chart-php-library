<?php

class AreaChart extends GoogleChart 
{
    
    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'AreaChart';
        parent::__construct($data, $config);
    }

}

?>
