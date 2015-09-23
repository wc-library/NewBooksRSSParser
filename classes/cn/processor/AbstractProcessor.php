<?php

namespace cn\processor;

abstract class AbstractProcessor {

    // returns an associative array (fieldname=>value)
    // indicating the fields CarliBookFeed should append
    // to an entry
    public function data() {
        return $this->data;
    }

    public abstract function getSubject();

    public abstract function matches($range);

    //returns 0 when $this->cn == $cn
    //returns -1 when $this->cn < $cn
    //returns 1 when $this->cn > $cn
    protected abstract function compareTo($cn);

    protected function equals($cn) {
        return $this->compareTo($cn)===0;
    }

    protected function lessThan($cn) {
        return $this->compareTo($cn)===-1;
    }

    protected function greaterThan($cn) {
        return $this->compareTo($cn)===1;
    }


}
