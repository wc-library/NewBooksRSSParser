<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassificationFactory
 *
 * @author bgarcia
 */
class ClassificationFactory {
    private static $regex_lc = '#^[A-Z]{2,3}[0-9]+([.][A-Z][0-9]+)?$#';
    private static $regex_dewey = '#^[0-9]{3}([/]?[.][0-9]+)?$#';

    public static function makeProcessor($callnumber) {
        $segments = explode(' ',$callnumber);
        $prefix = "";
        $number = "";
        $cutter = "";

        $type = "";


        $match = array();

        foreach($segments as $segment) {
            if ($number === "") {

                if ($prefix==='' && preg_match('/^[0-9]{3}/',$segment)===1) {
                    $number = $segment;
                    $type = "dewey";
                    continue;
                }

                $seg_arr = str_split($segment);
                if ($seg_arr[count($seg_arr)-1]==='.' || $seg_arr[0]==='.' || stripos($segment,'-') !== FALSE) {
                    $prefix .= "$segment ";
                    continue;
                }

                $match = preg_match(self::$regex_lc,$segment,$match);
                if ($match[0] === $segment) {
                    $number = $segment;
                    $type = "lc";
                    continue;
                }

                $match = preg_match(self::$regex_dewey,$segment,$match);
                if ($match[0] === $segment) {
                    $number = $segment;
                    $type = "dewey";
                    continue;
                }

                $prefix .= "$segment ";
                continue;
            }

            $cutter .= "$segment ";
        }

        $prefix = trim($prefix);
        $number = trim($number);
        $cutter = trim ($cutter);

        if ($type === "lc")
            return new LCProcessor($prefix,$number,$cutter);
        else if ($type === "dewey")
            return new DeweyProcessor($prefix,$number,$cutter);
        return new DefaultProcessor($callnumber,$prefix,$number,$cutter);
    }
}
