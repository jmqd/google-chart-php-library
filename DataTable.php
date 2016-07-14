<?php

/*
 * @package GoogleChart
 * @author Jordan McQueen
 *
 * This isn't a part of the package yet. Aiming to replace the
 * $data property of GoogleChart class with this object.
 *
 * TODO:
 *      - Flow of validation needs revising. Some $data
 *      will be an array with elements of objects. need
 *      to address this case.
 */

class DataTable
{
    private $is_valid;
    private $data;
    private $columns;
    private $number_of_rows;
    private $number_of_columns;

    public function __construct($data)
    {
        $data_format = gettype($data);

        switch ($data_format)
        {
            case 'array':
                $this->array_validator($data);
                break;
            case 'object':
                $data = $this->object_to_array($data);
                break;
            default:
                throw new Exception("$data_format data format is not valid.");
                break;
        }
    }

    private function array_validator($data)
    {
        if (!array_key_exists(0, $data))
        {
            // invalid $data -- diverge & throw exception
        }

        if ($data[0] === false)
        {
            // no results in the data table -- diverge & mark flag
        }

        if (!is_array($data[0]))
        {
            // 1 dimensional data -- diverge from typical here to
            // function for 1 dimensional data?
        }

        $this->columns = array_keys($data[0]);
        
        if (empty($this->columns))
        {
            // no results in the data table -- diverge & mark flag
        }

        $this->number_of_columns = count($this->columns);
        $this->number_of_rows = 0;

        foreach ($data as $row)
        {
            ++$this->number_of_rows;
            if (count(array_keys($row)) > $this->number_of_columns)
            {
                // invalid data
                // data must have same number of columns throughout.
                // although, there is a desgin decision here: it is possible
                // that this ought to be considered valid data, and a filling
                // of the data could be performed... *thinking on that*
            }
            
            foreach ($this->columns as $key)
            {
                if (!array_key_exists($key, $row))
                {
                    // invalid data? or possibly same decison as above
                    // and fill the data...
                }
            }
        }

        // valid array. from here, either pass $data to a building function
        // or simply say $this->data = $data. unsure of design yet.
    }

    /**
     * Turns the data rows into arrays, if they are objects.
     */
    private function object_to_array($data)
    {

        if (is_object($data))
        {
            foreach ($data as $index => $row)
            {
                if (isset($row))
                {
                    $data[$index] = json_decode(json_encode($row), true);
                }
            }
        }       
        return $data;
    }
}


?>
