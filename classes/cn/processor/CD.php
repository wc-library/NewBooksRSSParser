<?php

namespace cn\processor;

class CD extends AbstractProcessor {

    public function __construct($cn,$location) {
        $this->data = array('classification_type'=>'CD',
            'subject' => $this->getSubject(strtolower($location)));
    }

    protected function matches($cn, $range) {
        return FALSE;
    }

    protected function getSubject($location) {
        $subjects = array();

        if (stripos($location,"music library")!==FALSE)
            $subjects[] = "Music";

        return implode(', ',$subjects);
    }

}
