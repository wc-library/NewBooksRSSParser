<?php

class Util {
    public static function parse_range($strlist) {
        $ranges = explode(',',str_replace(' ','',$strlist));
        $n = count($ranges);
        for ($i=0; $i<$n; ++$i) {
            $ranges[$i] = explode('-',$ranges[$i]);
        }

        return $ranges;
    }
}
