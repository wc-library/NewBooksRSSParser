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
    public function __construct($callnumber) {
    }

    public function data() {
        $data = array();
        $data['classification_type'] = 'UNKNOWN';
        return $data;
    }
}
