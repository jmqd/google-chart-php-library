<?php

class LineChart extends GoogleChart 
{
    protected $package;
    protected $chart_class;


    public function __construct($data) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'LineChart';
        parent::__construct($this);
    }
}

?>
