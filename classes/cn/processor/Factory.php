<?php

namespace cn\processor;

class Factory {

    // Possible call number prefixes for textbooks (preceded by 'CURR ')
    // See docs/education-classification-list.pdf
    const CURR_CN_PREFIXES = [
        // elementary
        'E-AR', 'E-GU', 'E-SE',
        'E-LA', 'E-MA', 'E-MC',
        'E-MU', 'E-RE', 'E-SC',
        'E-SO',
        // secondary
        'S-AR', 'S-BU', 'S-FL',
        'S-GU', 'S-HE', 'S-LA',
        'S-LI', 'S-MC', 'S-MA',
        'S-SC', 'S-SO', 'S-VO',
        // audio/visual
        'A-V'
    ];

    // Additional call number prefixes to clean up
    const MISC_CN_PREFIXES = [
        'Oversize',
        'Honey Rock'
    ];


    public static function make($item_data) {

        // to fix classification for books with location 'Oversize Books'
        $callnumber = Factory::clean_call_number($item_data['call_number']);

        if(preg_match("/^INTERNET/",$callnumber)) {
            $location = "Internet";
        } else {
            $location = $item_data['location'];
        }

        $cd_check = preg_match("/^[a-zA-Z]{4}/",$callnumber);
        if ($cd_check!==FALSE && $cd_check===1) {
            return new CD($callnumber, $location);
        } else {
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

            if ($type === "lc") {
                return new LC(trim($number),$location);
            } else if ($type === "dewey") {
                return new Dewey(trim($number),$location);
            } else {
                return new Generic($segments,$location);
            }
        }
    }


    /**
     * Remove any inconsistent prefixes from call number
     * @param string $cn Call number to process
     * @return string Call number with any inconsistencies removed
     */
    private static function clean_call_number($cn) {
        // Matches 'CURR ' followed by zero or one of the strings in CURR_CN_PREFIXES
        $curr_regex = 'CURR (' . implode('|', Factory::CURR_CN_PREFIXES) . ')?';
        // Matches any of the other prefixes specificed in MISC_CN_PREFIXES
        $misc_regex = implode('|', Factory::MISC_CN_PREFIXES);

        $pattern = "/^($curr_regex|$misc_regex)/i";

        // Remove prefixes
        return trim(preg_replace($pattern,'',$cn));
    }

}
