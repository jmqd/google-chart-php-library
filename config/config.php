<?php

return 
[
    'annotated_dates' => 
    [
        '2016-01-01' => 'New Years Day!',
        '2016-11-01' => 'First of November',
        '2016-06-23' => 'The day I wrote this config file',
    ],

    'defaults' =>
    [ 
        'settings' => 
        [
            'is_sharing_axes' => true,
            'is_stacked' => false,
            'point_size' => 0,
            'div_styles' => 
            [
                ['style' => 'border', 'value' => '0px solid'],
                ['style' => 'width', 'value' => '1400px'],
            ],
        ],
        'kind' => 'line',
        'characteristics' =>
        [
            'has_results' => true,
        ],
        'features' =>
        [
        
        ],
    ],
    
    'supported_features' => ['png'],
    
    'class_name_map' => 
    [
 		'line' => 'LineChart',
         'bar' => 'BarChart',
         'area' => 'AreaChart',
         'pie' => 'PieChart',
         'column' => 'ColumnChart',
         'table' => 'Table',
         'timeseries' => 'TimeseriesChart',
         'scatter' => 'ScatterChart',
    ],
];

?>
