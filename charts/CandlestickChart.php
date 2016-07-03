<?php

class CandlestickChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'CandlestickChart'; 
        parent::__construct($data, $config);
    }
}

?>
