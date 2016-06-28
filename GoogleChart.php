<?php
// Jordan McQueen

// TODO:
// 
//      - finish building out charts classes for transition to library-style
//
//         - constructor will do something along these lines, akin to a driver:
//           - construct things common to ALL types of chart (data, title, etc)
//           - $this->class_instance = $this->kind . "Chart"
//           - return new {$this->class_instance}($this);
//      - adhere to 80 width lines
//      - build out $config options
//
//      Currently, the $data property can really only accept Mysql_Result
//          - work to make the data input stronger, and tranform all inputted
//          data into a common format.

require_once('config/Config.php');	

class GoogleChart
{

    private $kind;
    private $dependents;
    private $independent;
    private $data_table;
    private $codename;
    private $title;
    private $data;
    private $chart_class;
    private $package;
    private $is_sharing_axes;
    private $independent_type;
    private $data_headers;
    private $is_controllable;
    private $is_including_png;
    private $has_results;
    private $linked_report;


    # I wrote this constructor when I was much less experienced...
    # TODO
    #
    # refactor this into better code. 
    public function __construct($args)
    {
        $this->config = new Config();
        $this->title = $args['title'];
        $this->has_results = array_key_exists('has_results', $args)
            ? $args['has_results']
            : true;

        if ($this->has_results === false)
        {   
            return "Nothing data to plot for $this->title";
        }
        $this->kind = array_key_exists('kind', $args)
            ? $args['kind']
            : $this->config->default_chart;
        $this->codename = $this->construct_codename();
        $this->data = $args['data'];
        $this->objectify_data();
        $this->refresh_data_headers();
        $this->is_controllable = array_key_exists('is_controllable', $args) 
            ? $args['is_controllable']
            : false;
        $args['independent'] = array_key_exists('independent', $args)
            ? $args['independent']
            : '';
        $this->set_independent($args['independent']);
        $this->is_including_png = array_key_exists('is_including_png',
                                                   $args)
            ? $args['is_including_png']
            : false;
        $this->linked_report = array_key_exists('linked_report', $args)
            ? $args['linked_reports']
            : null;
        $this->dependents = array_key_exists('dependents', $args)
            ? $args['dependents']
            : $this->build_dependents_guess();
        $this->chart_class = $this->lookup_chart_class();
        $this->package = $this->lookup_package(); 
        $this->is_sharing_axes = array_key_exists('is_sharing_axes', $args)
            ? $args['is_sharing_axes']
            : True;
        $this->make_js_data_table();
        }
    

    private function construct_codename()
    {
        // generate a 'unique' codename to avoid naming collisions
        $codename = preg_replace('/[^a-zA-Z]/', '', $this->title); 
        $codename .= substr(md5(rand()), 0, 7);

        return $codename;
    }


    private function objectify_data()
    {
        // presently, data is assumed to be objects in all operations
    	if (!is_object($this->data))
        {
            foreach ($this->data as $index => $row)
            {
                if (isset($row))
                {
                    $data[$index] = json_decode(json_encode($row));
                }
            }
            $this->data = $data;
        }       
    } 
   
 
    private function refresh_data_headers()
    {
        $this->data_headers = [];

        foreach ($this->data[0] as $key => $value)
        {
            $this->data_headers[] = $key;
        }
    }


    public function get_data_headers()
    {
        $this->refresh_data_headers();
        return $this->data_headers;
    }


    public function get_independent()
    {
        return $this->independent;
    }


    private function build_dependents_guess()
    {   
        return array_diff($this->get_data_headers(),
                          [$this->get_independent()]);
    }

    // factor this into with() strategy function if possible?
    public function with_png()
    {
        $this->is_including_png = True;
        return $this;
    }

    public function set_independent($independent)
    {
        switch (True)
        {
            case (is_array($independent)):
                $this->independent = $independent['name'];
                $this->independent_type = $independent['type'];
                break;

            case (!empty($independent) && 
                DateTime::createFromFormat
                (
                    'Y-m-d', 
                    $this->get_data()[0]->$independent
                ) !== FALSE):

                $this->independent = $independent;
                $this->independent_type = 'date';
                break;

            case (in_array('date', $this->get_data_headers()) && 
                empty($independent)):

                $this->independent = 'date';
                $this->independent_type = 'date';
                break;

            default:
                $this->independent = $independent;
                $this->independent_type = 'string';
                break;
        }
        return $this;
    } 


    public function set_kind($kind)
    {
        $this->kind = strtolower($kind);
        return $this;
    }


    public function set_is_sharing_axes($boolean)
    {
        if (!is_bool($boolean)) 
        {
            $type = gettype($boolean);
            throw new Exception ("set_is_sharing_axes() of GooglePlot class "
                . "requires type Boolean; $type was given.");
        }

        $this->is_sharing_axes = $boolean;
        return $this;
    }


    public function get_kind()
    {   
        return $this->kind;
    }


    public function get_data()
    {
        return $this->data;
    }


    public function with($option) 
    {
        $option = strtolower($option);

        if (!in_array($option, $this->config->supported_options)) 
        {
            throw new Exception("$option is not a supported with() option.");
        }
        
        if (in_array($option, $this->options)) 
        {
            return $this;
        }

        $this->options[] = $option;
        return $this;
    }


    # TODO:
    # Build out the various with_() functions.

    private function with_separate_axes($mode) 
    { 
        // there will be more cases here eventually
        switch ($mode) 
        {
            case 'special_options':
        }
    } 


    private function with_stacked($mode) 
    {
        switch ($mode) 
        {
            case 'special_options':
                return "isStacked: true,\n";
                break;
        }
    }

    public function set_dependents($dependents)
    {
        $this->dependents = $dependents;
        return $this;
    }


    public function set_title($title)
    {
        $this->title = $title;
        return $this;
    }


    public function get_title()
    {
        return $this->title;
    }

    public function get_dependents()
    {
        return $this->dependents;
    }


    public function get_independent_type()
    {
        return $this->independent_type;
    }


    public function add_dependent($dependent)
    {
        $this->dependents[] = $dependent;
        return $this;
    }


    private function prepare_independent($value)
    {
        switch ($this->get_independent_type())
        {
            case 'date':
                $value = new DateTime($value);
                $value = $value->modify('+1 day')->format('Y-m-d');
                $value = "new Date('$value')";
                return $value;
                break;
            case 'number':
                return $value;
                break;
            case 'string':
                return "'$value'";
                break;
        }
    }


    private function get_data_table()
    {
        return $this->data_table;
    }


    #TODO:
    #
    #clean this up.
    private function make_js_data_table()
    {
        $data_body = "";
        foreach ($this->data as $row)
        {
            if ($this->get_independent_type() == 'date' && 
                array_key_exists($row->{$this->get_independent()}, 
                                 $this->config->annotated_dates)) 
            {
                $annotation = "'R'";
                $annotation_text = "'{$this->config->annotated_dates[
                    $row->{$this->independent}]}'";
            } else 
            {
                $annotation = 'null';
                $annotation_text = "null";
            }
            
            $x = $this->prepare_independent($row->{$this->independent});
            $data_body .= "[$x";
            foreach ($this->dependents as $y) 
            {
                $value = $row->{$y};
                if ($value == NULL) 
                {
                    $value = 0;
                }
                $data_body .= ", $value";
            }
            if ($this->independent_type == 'date') 
            {
                $data_body .= ", $annotation";
                $data_body .= ", $annotation_text";
            }
            $data_body .= "],\n\t\t\t\t";
        }
        $this->data_table = $data_body;
    }    


    private function get_special_options() 
    {
        $special_options = "";
        if (!empty($this->options))
        {
            foreach ($this->options as $option) 
            {
                $func_name = "with_$option";
                $special_options .= $this->$func_name('special_options');
            }
        }
        $special_options .= "pointSize: {$this->get_point_size()}\n";
        return $special_options;
    }


    public function set_point_size_options($size=Null)
    {
        if ($size != Null) 
        {
            $this->point_size = $size;
            return $this;
        }

        switch ($this->kind)
        {
            case 'scatter':
                $this->point_size = 1;
                break;
            default:
                $this->point_size = 0;
                break;
        }
        return $this;
    }


    public function get_point_size()
    {
        if (isset($this->point_size) === False) 
        {
            $this->set_point_size_options();
        }
        return $this->point_size;
    }


    private function get_options()
    {
        $options = "var options = {
                title: '$this->title',
                height: 400,
                {$this->get_axes_options()},
                {$this->get_special_options()}
            };";
        return $options;
    }
    

    private function lookup_package()
    {
        switch ($this->kind)
        {
            case 'table':
                return 'table';
                break;
            default:
                return 'corechart';
                break;
        }
    }


    private function lookup_chart_class()
    {
        $class_lookup = [
            'timeseries' => 'LineChart',
            'line' => 'LineChart',
            'column' => 'ColumnChart',
            'combo' => 'ComboChart',
            'pie' => 'PieChart',
            'area' => 'AreaChart',
            'stacked' => 'AreaChart',
            'bar' => 'BarChart',
            'table' => 'Table',
            'scatter' => 'ScatterChart',
            ];
        return $class_lookup[$this->kind];
    }


    private function build_columns()
    {
        $columns = "";
        $columns .= "data.addColumn('{$this->get_independent_type()}', ";
        $columns .= "'{$this->get_independent()}');";
        foreach ($this->get_dependents() as $dependent)
        {
            $columns .= "\n\t\t\t";
            $columns .= "data.addColumn('number', '$dependent');";
        }
        if ($this->independent_type == 'date') 
        {
            $columns .= " data.addColumn({type:'string', role:'annotation'});
            data.addColumn({type:'string', role:'annotationText'});";
        }

        return $columns;
    }


    private function get_axes_options()
    {
        $axes = "vAxes: {\n";
        $series = "\t\t\t\tseries: {\n";
        if ($this->is_sharing_axes === False) 
        {
            foreach ($this->dependents as $index => $y)
            {
                $axes .= "\t\t\t\t\t$index: {title: '$y'},\n";
                $series .= "\t\t\t\t\t$index:{ targetAxisIndex: $index},\n";
            }
        } else if ($this->is_sharing_axes === True) 
        {
            $axes .= "\t\t\t\t\t0: {title: ''},\n";
            foreach ($this->dependents as $index => $y)
            {
                $series .= "\t\t\t\t\t$index:{ targetAxisIndex: 0},\n";
            }
        }
        $axes .= "\t\t\t\t" . "}," ."\n";
        $series .= "\t\t\t\t" . "}";
        return $axes . $series;
    }


    private function buildJsExtras()
    {
        if ($this->is_including_png === True) 
        {
            return "google.visualization.events.addListener(chart, 'ready', "
                . "function () {
                 png = chart.getImageURI();
             });";
        }
    }


    private function build_js_for_chart()
    {
        $js = "
        <div id='$this->codename' {$this->config->default_style}'></div>
        <script type='text/javascript'>
        google.charts.load('current', {packages:['{$this->package}']});
        google.charts.setOnLoadCallback($this->codename);
        function $this->codename() {
            var data = new google.visualization.DataTable()
            {$this->build_columns()}
            data.addRows(
            [
                {$this->get_data_table()}
            ]);

            {$this->get_options()}
            var chart = new google.visualization.{$this->chart_class}"
        . "            (document.getElementById('$this->codename'));

            chart.draw(data, options);
        }
        </script>";

        return $js;
    }

    // TODO
    // build out method to create a google.visualization.Dashboard object
    //
    // public function buildJsForDashboard()


    public function display()
    {
        if ($this->has_results === False) 
        {
            echo "No data found to plot with for $this->title.";
            return Null;
        }
        echo $this->build_js_for_chart(); # is echo bad here? maybe return is better.
    }
}

