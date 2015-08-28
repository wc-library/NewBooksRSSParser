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

    protected function get_subject($cn) {
        return "All Subjects";
    }

    protected function cmp_cn($cn1,$cn2) {
        return FALSE;
    }

    protected function in_range($cn, $range) {
        $ranges = self::parse_range(strtr($range,' ',''));
        $flag = false;
        foreach ( $ranges as $r ) {
            if (count($r)===1) {
                $flag = $flag||($this->cmp_cn($cn,$r[0])==0);
            } else {
                $flag = $flag||($this->cmp_cn($r[0],$cn)<=0 && $this->cmp_cn($cn,$r[1])<=0);
            }
        }

        return $flag;
    }


    protected static function parse_range($range) {
        $ranges = explode(',',$range);
        $ret = array();
        foreach ($ranges as $r) {
            if (stripos($range,'-') !== FALSE) {
                $ret[] = explode('-',$range);
            } else {
                $ret[] = array($range);
            }
        }
        return $ret;
    }
}
