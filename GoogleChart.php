<?php
// Jordan McQueen

// TODO:
// 
//      Currently, the $data property can really only accept Mysql_Result
//          - work to make the data input stronger, and tranform all inputted
//          data into a common format.
//
//      Work out how to make Dashboard object work.


abstract class GoogleChart
{

    public $chart_javascript;
    public $chart_class;

    protected $data;
    protected $config;
    protected $dependents;
    protected $independent;
    protected $data_table;
    protected $package;
    protected $codename;
    protected $title;
    protected $independent_type;
    protected $data_headers;
    protected $settings;
    protected $features;
    protected $characteristics;


    protected function __construct($data, $config)
    {
        $this->data = $data;
        $this->initialize_default_settings($config);
        $this->do_prework();
    }
    

    public static function factory($data, $kind = null)
    {
        $config = include('config/config.php');
        if ($kind === null)
        {
            $kind = $config['default_settings']['kind']; 
        }
        $class_name = $config['class_name_map'][$kind];
        require_once("charts/$class_name.php");
        $chart = new $class_name($data, $config);
        return $chart;
    }


    protected function initialize_default_settings($config)
    {
        $this->settings = $config['default_settings'];
        $this->characteristics = $config['default_characteristics'];
        $this->settings['annotated_dates'] = $config['annotated_dates'];
        $this->features = $config['default_features'];
        $this->config['supported_features'] = $config['supported_features'];
    }


    protected function do_prework()
    {
        $this->construct_codename();
        $this->objectify_data();
        $this->refresh_data_headers();
    }


    public function set_annotated_dates($dates)
    {
        if (!is_array($dates))
        {
            throw new Exception("set_annotated_dates() only takes an array.");
        }

        $this->settings['annotated_dates'] = $dates;
        return $this;
    }

    // do I want this to be protected?...
    public function set_data($data)
    {
        $this->data = $data;
        $this->do_prework();
        return $this;
    }


    protected function construct_codename()
    {
        // generate a 'unique' codename to avoid naming collisions
        $this->codename = $this->chart_class; 
        $this->codename .= substr(md5(rand()), 0, 7);
    }


    protected function objectify_data()
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
   
 
    protected function refresh_data_headers()
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


    protected function build_dependents_guess()
    {   
        if (!empty($this->dependents))
        {
            return true;
        }

        $this->dependents = array_diff($this->get_data_headers(),
                                       [$this->get_independent()]);
        if (empty($this->dependents))
        {
            return false;
        }

        return true;
    }


    // this is broken.
    public function with_png($mode)
    {
        switch ($mode)
        {
            case 'extras':
                return "google.visualization.events.addListener(chart, 'ready', "
                . "function () {
                {$this->codename}.innerHTML = '<img src=\"' + "
                . "chart.getImageURI() + '\">';
             });";

            break;

        }
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


    protected function build_independent_guess()
    {
        if (!empty($this->independent))
        {
            return true;
        }

        if (in_array('date', $this->data_headers))
        {
            $this->set_independent(['name' => 'date', 'type' => 'date']);
            return true;
        }
        
        return false;
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


    public function get_data()
    {
        return $this->data;
    }


    public function with($feature) 
    {
        $feature = strtolower($feature);

        if (!in_array($feature, $this->config['supported_features'])) 
        {
            throw new Exception("'$feature' is not a supported with() feature.");
        }
        
        if (in_array($feature, $this->options)) 
        {
            return $this;
        }

        $this->features[] = $feature;
        return $this;
    }


    # TODO:
    # Build out the various with_() functions.

    protected function with_separate_axes($mode) 
    { 
        // there will be more cases here eventually
        switch ($mode) 
        {
            case 'special_options':
        }
    } 


    protected function with_stacked($mode) 
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


    protected function prepare_independent($value)
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


    public function build()
    {
        if (empty($this->independent))
        {
            $guessed = $this->build_independent_guess();

            if ($guessed === false)
            {
                throw new Exception("Unable to find/guess independent var.");
            }
        } 

        if (empty($this->dependents))
        {
            $guessed = $this->build_dependents_guess();

            if ($guessed === false)
            {
                throw new Exception("Unable to find/guess dependent vars.");
            }
        }
        
        $this->build_js_data_table();
        $this->build_chart_javascript();
    }


    protected function get_data_table()
    {
        return $this->data_table;
    }


    #TODO:
    #
    #clean this up.
    protected function build_js_data_table()
    {
        $data_body = "";
        foreach ($this->data as $row)
        {
            if ($this->get_independent_type() == 'date' && 
                array_key_exists($row->{$this->get_independent()}, 
                                 $this->settings['annotated_dates'])) 
            {
                $annotation = "'R'";
                $annotation_text = "'{$this
                  ->settings['annotated_dates'][$row->{$this->independent}]}'";
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


    protected function get_special_options() 
    {
        $special_options = "";
        if (!empty($this->features))
        {
            foreach ($this->features as $feature) 
            {
                $func_name = "with_$feature";
                $special_options .= $this->$func_name('special_options');
            }
        }
        $special_options .= "pointSize: {$this->settings['point_size']}";
        $special_options .= "\n";
        return $special_options;
    }


    protected function get_options()
    {
        $options = "var options = {
                title: '$this->title',
                height: 400,
                {$this->get_axes_options()},
                {$this->get_special_options()}
            };";
        return $options;
    }
    

    protected function build_columns()
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


    protected function get_axes_options()
    {
        $axes = "vAxes: {\n";
        $series = "\t\t\t\t" . "series: {" . "\n";
        if ($this->settings['is_sharing_axes'] === False) 
        {
            foreach ($this->dependents as $index => $y)
            {
                $axes .= "\t\t\t\t\t" . "$index: {title: '$y'}," . "\n";
                $series .= "\t\t\t\t\t" . "$index:{ targetAxisIndex: $index},"
                    . "\n";
            }
        } else if ($this->settings['is_sharing_axes'] === True) 
        {
            $axes .= "\t\t\t\t\t" . "0: {title: ''}," . "\n";
            foreach ($this->dependents as $index => $y)
            {
                $series .= "\t\t\t\t\t" . "$index:{ targetAxisIndex: 0},"
                    . "\n";
            }
        }
        $axes .= "\t\t\t\t" . "}," . "\n";
        $series .= "\t\t\t\t" . "}";
        return $axes . $series;
    }


    public function get_chart_javascript()
    {
        return $this->chart_javascript;
    }


    protected function build_chart_javascript()
    {
        $this->chart_javascript = "
        <div id='$this->codename' {$this->settings['div_style']}'></div>
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
    }


    public function display()
    {
        if (!$this->characteristics['has_results']) 
        {
            echo "No data found to plot with for $this->title.";
            return Null;
        }
        return $this->get_chart_javascript();
    }
}

