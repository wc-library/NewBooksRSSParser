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
        $txt = "";
        foreach($segments as $seg) {
            if ($txt==='')
                $txt = "{ $seg";
            else
                $txt .= ", $seg";
        }
        $txt .= "}";
        $this->data = array('classification_type'=>"UNKNOWN",
            'UNKNOWN'=>$txt);

    }

    protected function get_subject($cn) {
        return "";
    }

    protected function matches($cn, $range) {
        return FALSE;
    }
}
