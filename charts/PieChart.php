<?php

class PieChart extends GoogleChart 
{

    public function __construct($data, $config) 
    {
        $this->package = 'corechart';
        $this->chart_class = 'PieChart';
        parent::__construct($data, $config);
    }

    protected function build_independent_guess()
    {
        if (!empty($this->independent))
        {
            return true;
        }

        throw new Exception('PieCharts need an explicit independent variable');
    }


}

?>
