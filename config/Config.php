<?php

class Config 
{

    public $annotated_dates;
    public $supported_options;
    public $default_chart;

    public function __construct()
    {

        $this->annotated_dates = [
            '2016-01-01' => 'New Years Day!',
            '2016-11-01' => 'First of November',
            '2016-06-23' => 'The day I wrote this config file',
            ];

        $this->supported_options = [
            'stacked',
            'separate_axes',
            ];

        $this->default_chart = 'line';
        $this->default_style = "style='border: 0px solid; width:1400px;";

    }

}

?>
