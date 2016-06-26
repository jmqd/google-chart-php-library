<?php

class Config {


    public function __construct() {

        $config['annotated_dates'] = 
        [
            '2016-01-01' => 'New Year\'s Day!',
            '2016-11-01' => 'First of November',
            '2016-06-23' => 'The day I wrote this config file',
        ];

        $config['supported_options'] = [
            'stacked',
            'separate_axes',
        ];

}

}
?>
