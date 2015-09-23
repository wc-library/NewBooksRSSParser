<?php

namespace util;


class Tester {
    public function __construct($call_number,$location,$test_range=null) {
        $this->input = array();
        $this->input['call_number'] = $call_number;
        $this->input['location'] = $location;
        if (!is_null($test_range))
            $this->input['test_range'] = $test_range;

        $this->output = array();
    }

    public function run() {
        $processor = \cn\processor\Factory::make($this->input);
        $this->output = $processor->data();
        $this->output['number'] = implode($processor->cn);

        if (array_key_exists('test_range', $this->input)) {
            if ($processor->matches($this->input['test_range']))
                $this->output['test_range_success'] = 'true';
            else
                $this->output['test_range_success'] = 'false';
        }

        return $this;
    }

    public function display() {
        echo "\nINPUT {";
        foreach ($this->input as $k=>$v) {
            echo "\n     $k => \"$v\"";
        }
        echo "\n} OUTPUT {";
        foreach ($this->output as $k=>$v) {
            echo "\n     $k => \"$v\"";
        }
        echo "\n}";
    }
}
