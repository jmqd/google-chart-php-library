<?php

class ComboChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'ScatterChart';
        parent::__construct($data, $config);
    }
}

?>
