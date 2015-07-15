<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LCProcessor
 *
 * @author bgarcia
 */
class LCProcessor implements ClassificationProcessorInterface {
    public function __construct($prefix,$number,$cutter) {
        $this->data = array();
        $this->data['classification_type'] = "{\"$prefix\", \"$number\", \"$cutter\" } (LC)";
    }

    public function data() {
        return $this->data;
    }
}
