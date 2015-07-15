<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LCProcessor
 *
 * @author bgarcia
 */
class LCProcessor implements ClassificationProcessorInterface {
    public function __construct($prefix,$number,$cutter) {
        $this->data = array();
        $this->data['classification_type'] = "LC";

        //$this->data['subject'] = self::get_subject($cn);
        $this->data['subject'] = self::normalize_cn($number);
    }

    public function data() {
        return $this->data;
    }

    private static function get_subject($cn) {
        return "Unknown";
    }

    private static function in_range($cn,$min,$max) {
        $min = self::normalize_cn($min);
        $cn = self::normalize_cn($cn);
        $max = self::normalize_cn($max);

        return (strcmp($min,$cn)<=0 && strcmp($cn,$max)<=0);
    }

    private static function normalize_cn($cn) {
        $cn_normalized = "ERROR";

        $regex_alpha = "([A-Z]{1,3})";
        $regex_num = "([0-9]{0,4})";
        $regex_extra = "(\.[A-Z0-9][0-9]*)";
        $regex = "/^{$regex_alpha}{$regex_num}?{$regex_extra}?/";

        $matches = array();
        if (preg_match($regex,$cn,$matches)) {
            $alpha = "AAA";
            if (isset($matches[1]))
                $alpha = self::normalize_alpha($matches[1]);

            $num = "0000";
            if (isset($matches[2]))
                $num = self::normalize_num($matches[2]);

            $extra = ".A0000";
            if (isset($matches[3]))
                $extra = self::normalize_extra($matches[3]);

            $cn_normalized = $alpha . $num . $extra;
        }
        return $cn_normalized;
    }

    private static function normalize_alpha($alpha) {
        if ($alpha == '')
            return "AAA";
        else if (strlen($alpha)==1)
            $alpha .= 'AA';
        else if (strlen($alpha)==2)
            $alpha .= 'A';

        return $alpha;
    }

    private static function normalize_num($num) {
        if (strlen($num)===0)
            return "0000";
        if (strlen($num)===1)
            return "000$num";
        if (strlen($num)===2)
            return "00$num";
        if (strlen($num)===3)
            return "0$num";

        return $num;
    }

    private static function normalize_extra($extra) {
        $extra = str_replace('.','',$extra);
        if (strlen($extra)===0)
            return ".A0000";

        if (ctype_digit($extra))
            $extra = "A$extra";

        if (strlen($extra)===1)
            return ".{$extra}0000";

        $alpha = str_split($extra);
        $alpha = $alpha[0];
        $extra = substr($extra,1);

        if (strlen($extra)===1)
            $extra = "000$extra";
        if (strlen($extra)===2)
            $extra = "00$extra";
        if (strlen($extra)===3)
            $extra = "0$extra";

        return ".{$alpha}{$extra}";
    }
}
