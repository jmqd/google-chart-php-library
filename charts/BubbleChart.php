<?php

class BubbleChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'BubbleChart';
        parent::__construct($data, $config);
    }
}

?>
