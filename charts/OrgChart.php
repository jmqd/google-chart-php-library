<?php

class OrgChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'orgchart';
        $this->chart_class = 'OrgChart';
        parent::__construct($data, $config);
    }
}

?>
