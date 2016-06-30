<?php

return 
[
    'annotated_dates' => [
        '2016-01-01' => 'New Years Day!',
        '2016-11-01' => 'First of November',
        '2016-06-23' => 'The day I wrote this config file',
        ],


    'default_chart_settings' => [
        'is_sharing_axes' => true,
        'is_stacked' => false,
        ],
    

    'supported_features' => [],


    'default_kind' => 'line',

    
    'default_div_style' => "style='border: 0px solid; width:1400px",


    'class_name_map' => [
 		'line' => 'LineChart',
         'bar' => 'BarChart',
         'area' => 'AreaChart',
         'pie' => 'PieChart',
         'column' => 'ColumnChart',
         'table' => 'Table',
         'timeseries' => 'TimeseriesChart',
         'scatter' => 'ScatterChart',
    	],
	

    'is_including_png' => false,


    'is_sharing_axes' => true,


    'stacking' => false,


    'default_features' => [],
];

?>
