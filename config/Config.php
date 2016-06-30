<?php

require('charts/LineChart.php');

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
    

    public static function get_class_name($kind)
    {
        $class_map = [
            'line' => 'LineChart',
            'bar' => 'BarChart',
            'area' => 'AreaChart',
            'pie' => 'PieChart',
            'column' => 'ColumnChart',
            'table' => 'Table',
            'timeseries' => 'TimeseriesChart',
            'scatter' => 'ScatterChart',
        ];
        if (array_key_exists($kind, $class_map))
        {
            return $class_map[$kind]; 
        }

        if (!array_key_exists($kind, $class_map))
        {
            throw new Exception("'$kind' kind of chart is not supported.");
        }
    }
}

?>
