<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultProcessor
 *
 * @author bgarcia
 */
class DefaultProcessor implements ClassificationProcessorInterface {
    public function __construct($callnumber,$prefix,$number,$cutter) {
        $this->data = array();
        $this->data['classification_type'] = "{\"$prefix\", \"$number\", \"$cutter\" } (UNKNOWN)";
    }

    public function data() {
        return $this->data;
    }
}
