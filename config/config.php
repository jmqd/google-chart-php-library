<?php

return 
[
    'annotated_dates' => [
        '2016-01-01' => 'New Years Day!',
        '2016-11-01' => 'First of November',
        '2016-06-23' => 'The day I wrote this config file',
        ],

    'default_settings' => [
        'is_sharing_axes' => true,
        'is_stacked' => false,
        'point_size' => 0,
        'div_style' => "style='border: 0px solid; width:1400px",
        'kind' => 'line',
        ],
    
    'supported_features' => ['png'],
    
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
	
    'default_characteristics' => [
        'has_results' => true,
        ],

    'default_features' => [
        
        ],
];

?>
