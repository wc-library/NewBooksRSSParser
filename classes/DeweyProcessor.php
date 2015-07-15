<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeweyProcessor
 *
 * @author bgarcia
 */
class DeweyProcessor implements ClassificationProcessorInterface {
    public function __construct($prefix,$number,$cutter) {
    }

    public function data() {
        $data = array();
        $data['classification_type'] = 'Dewey';
        return $data;
    }
}
