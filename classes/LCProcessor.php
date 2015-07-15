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
        $this->data['classification_type'] = "LC";

        $cn = intval(substr($number,0,3));
        $this->data['subject'] = self::get_subject($cn);
    }

    public function data() {
        return $this->data;
    }

    private static function get_subject($cn) {
        return "Unknown";
    }
}
