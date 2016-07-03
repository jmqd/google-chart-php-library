<?php

class TreeMap extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'TreeMap';
        parent::__construct($data, $config);
    }
}

?>
