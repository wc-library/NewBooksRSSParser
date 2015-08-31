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

    protected abstract function cmp_cn($cn1,$cn2);

    protected function in_range($cn, $range) {
        foreach ( Util::parse_range($range) as $r ) {
            if (count($r)===1) {
                if ($this->cmp_cn($cn,$r[0])===0)
                    return true;
            } else if ($this->cmp_cn($r[0],$cn)<=0 && $this->cmp_cn($cn,$r[1])<=0) {
                return true;
            }
        }
        return false;
    }
}
