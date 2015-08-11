<?php

/**
 *
 * @author bgarcia
 */
abstract class AbstractClassificationProcessor {

    public function __construct($number) {
        $this->data = array('subject' => $this->get_subject($number));
    }

    // returns an associative array (fieldname=>value)
    // indicating the fields CarliBookFeed should append
    // to an entry
    public function data() {
        return $this->data;
    }

    protected abstract function get_subject($cn);
}
