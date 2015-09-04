<?php

/**
 *
 * @author bgarcia
 */
abstract class AbstractClassificationProcessor {

    public function __construct($type,$prefix,$number,$cutter) {
        $this->data = array('classification_type'=>$type,
            'subject' => $this->get_subject($number));
    }

    // returns an associative array (fieldname=>value)
    // indicating the fields CarliBookFeed should append
    // to an entry
    public function data() {
        return $this->data;
    }

    protected abstract function get_subject($cn);

    protected abstract function matches($cn, $range);
}
