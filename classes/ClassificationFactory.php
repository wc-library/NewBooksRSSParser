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

    public static function makeProcessor($callnumber,$location) {
        $segments = explode(' ',$callnumber);
        $prefix = "";
        $number = "";
        $cutter = "";

        $type = "";

        foreach($segments as $segment) {
            if ($number === "") {
                $seg_arr = str_split($segment);
                if ($seg_arr[count($seg_arr)-1]==='.' || $seg_arr[0]==='.' || stripos($segment,'-') !== FALSE) {
                    $prefix .= "$segment ";
                    continue;
                }

                if (preg_match('/^[A-Z]+[0-9]+/',$segment)===1) {
                    $number = $segment;
                    $type = "lc";
                    continue;
                }

                if (preg_match('/^[0-9]{3}/',$segment)===1) {
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
        return new CDProcessor($callnumber, $location);
    }
}
