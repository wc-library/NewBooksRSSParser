<?php

namespace cn\processor;

class CURR extends AbstractProcessor {

    public function __construct($cn,$location) {
        $this->location = strtolower($location);
        $this->data = array('classification_type'=>'CD',
            'subject' => $this->getSubject(),
            'location' => $location);
    }

    public function matches($range) {
        return FALSE;
    }

    protected function compareTo($cn) {
        return -2; // invalid
    }

    public function getSubject() {
        $subjects = array();

        $subjects[] = "Education";

        if (preg_match("/music library/", $this->location)){
            $subjects[] = "Music";
        }

        return implode(', ',$subjects);
    }

}
