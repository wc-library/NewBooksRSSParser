<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CDProcessor
 *
 * @author bgarcia
 */
class CDProcessor extends AbstractClassificationProcessor {

    protected function __construct($cn,$location) {
        $this->data = array('classification_type'=>'CD',
            'subject' => $this->get_subject(strtolower($location)));
    }

    protected function cmp_cn($cn1, $cn2) {
        return FALSE;
    }

    protected function get_subject($location) {
        $subjects = array();

        if (stripos($location,"music library")!==FALSE)
            $subjects[] = "Music";

        return implode(', ',$subjects);
    }

}
