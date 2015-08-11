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
class DefaultProcessor extends AbstractClassificationProcessor {
    public function __construct($segments) {
        parent::__construct(null);
        $txt = "";
        foreach($segments as $seg) {
            if ($txt==='')
                $txt = "{ $seg";
            else
                $txt .= ", $seg";
        }
        $txt .= "}";
        $this->data['classification_type'] = "UNKNOWN";
    }

    public function get_subject($cn) {
        return "All Subjects";
    }

    public function data() {
        return $this->data;
    }
}
