<?php

class Histogram extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'Histogram';
        parent::__construct($data, $config);
    }
}

?>
