<?php

namespace cn\processor;

abstract class AbstractProcessor {

    public function __construct($type,$prefix,$number,$cutter) {
        $this->data = array('classification_type'=>$type,
            'subject' => $this->getSubject($number));
    }

    // returns an associative array (fieldname=>value)
    // indicating the fields CarliBookFeed should append
    // to an entry
    public function data() {
        return $this->data;
    }

    protected abstract function getSubject($cn);

    protected abstract function matches($cn, $range);
}
